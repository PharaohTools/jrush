<?php

Namespace Model\JFeature;

class InstallGroup extends Base {

    private static $configs ;
    private $groupFile;
    private $allGroupFiles ;
    private $model ;
    private $uploadDir ;

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "JFeature Install Group");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
        $this->setCmdLineParams($params);
        $this->configs = new \GCWorkflowDeployerConfigClass();
        $this->model = new \GCWorkflowDeployerModelClass();
        $this->uploadDir = $this->configs->give("temp_pull_folder");
    }

    public function askWhetherToInstallGroup() {
        $this->findGroupFile();
        return $this->performGroupInstall();
    }

    public function askWhetherToInstallAllGroups() {
        $this->findAllGroupFiles();
        foreach ($this->allGroupFiles as $groupFile) {
            $this->groupFile = $groupFile ;
            $this->performGroupInstall() ; }
        return true ;
    }

    private function findAllGroupFiles(){
        $allFiles = scandir($this->configs->give("metadata_store_folder")) ;
        foreach ($allFiles as $file) {
            $gstart = strlen($file)-6 ;
            if (substr($file, $gstart) == ".group") {
                $this->allGroupFiles[] = $this->configs->give("metadata_store_folder").DS.$file ; } }
    }

    private function findGroupFile(){
        if ($this->groupFile) { return; }
        $question = 'Enter Location of Group file to install';
        $this->groupFile = self::askForInput($question, true);
    }

    private function performGroupInstall() {
        $fileres = $this->receive();
        return $fileres;
    }

    private function setCmdLineParams($params) {
        foreach ($params as $param) {
            if ( substr($param, 0, 12)=="--group-file"){
                $this->groupFile = substr($param, 13, strlen($param)-1); } }
        return true;
    }

    /*
     * Here is the Receiver
     */
    private function receive() {
        $groupFileData = file_get_contents($this->groupFile) ;
        $groupArray = unserialize($groupFileData);
        $groupDBIDIfAlreadyExists = $this->model->getGroupIdFromUnique($groupArray["groupDetails"]["uniqueid"]);
        echo "Installing group {$groupArray["groupDetails"]["uniqueid"]}...\n" ;
        $groupDBID = ($groupDBIDIfAlreadyExists != null ) ? $groupDBIDIfAlreadyExists : $this->model->setNewGroupID($groupArray["groupDetails"]["uniqueid"]) ;
        $this->model->setUpdateGroupDetail($groupDBID, 'group_name', $groupArray["groupDetails"]["group_name"]);
        $this->model->setUpdateGroupDetail($groupDBID, 'group_desc', $groupArray["groupDetails"]["group_desc"]);
        $this->model->deleteAllGroupEntries($groupDBID);
        foreach ($groupArray["groupEntries"] as $groupEntry) {
            $this->model->addGroupEntryByDBID($groupDBID, $groupEntry["entry_type"], $groupEntry["target"],
                $groupEntry["ordering"]); }
        $this->installGroupProfiles($groupArray["groupEntries"]);
        return $groupArray;
    }

    private function installGroupProfiles($groupEntries) {
        foreach ($groupEntries as $groupEntry) {
            if ($groupEntry["entry_type"]=="group") {
              /*
               * // @todo
                $pullGroup = new PullGroup(array('--group-name="'.$groupEntry["target"].'"'));
                $outputLog[] = $pullGroup->silentPullGroup() ; */ }
            else if ($groupEntry["entry_type"]=="instance" ||
                     $groupEntry["entry_type"]=="allinprofile") {
            $profile_id_only = substr($groupEntry["target"], 0, 16);
            echo "Installing profile $profile_id_only...\n" ;
            $this->installProfileOnly($profile_id_only); } }
    }

    private function installProfileOnly($uniqueid) {
        $profileFilePath = $this->configs->give("metadata_store_folder").DS.$uniqueid.".profile" ;
        $profString = file_get_contents($profileFilePath) ;
        $profDetailsFromFile = unserialize($profString);

        $profileExists = $this->model->checkProfileExists($uniqueid) ;
        $profileDetailsMemory = array();
        if ($profileExists) {
            $profileDetailsMemory = $this->model->getSingleProfileDetailsFromUnique($uniqueid) ; }
        else {
            $profileDetailsMemory["id"] = $uniqueid ; }
        var_dump("pdm", $profileDetailsMemory , "pff", $profDetailsFromFile) ;
        $this->model->setUpdateProfileDetail( $profileDetailsMemory["id"], 'profile_title', $profDetailsFromFile["profile_title"]);
        $this->model->setUpdateProfileDetail( $profileDetailsMemory["id"], 'profile_description', $profDetailsFromFile["profile_description"]);

      foreach($profDetailsFromFile["filefolders"] as $folder) {
        $this->model->addProfileFileFolder($uniqueid, $folder); }

      foreach($profDetailsFromFile["files"] as $file) {
        $this->model->addProfileFileFolder($uniqueid, $file); }

      $dTables = array();
      foreach($profDetailsFromFile["datatables"] as $datatable) {
        $dTables[] = array($datatable["profile_datatable_tablename"], $datatable["profile_datatable_ordering"]); }
      $this->model->setProfileDataTables($uniqueid, $dTables);

      $tablestodo = $this->model->getDBTablesToAction($uniqueid);
      $i = 0;
      foreach ($tablestodo as $table) {
        $this->model->setProfileDataTableAction(
          $uniqueid,
          $table["profile_datatable_tablename"],
          $profDetailsFromFile["datatables"][$i]["profile_datatable_action_code"],
          $table["profile_datatable_ordering"],
          serialize($profDetailsFromFile["datatables"][$i]["profile_datatable_action_details"] ) ) ;
          $i++; }

    }

}