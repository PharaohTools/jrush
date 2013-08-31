<?php

Namespace Model\JFeature;

class InstallFeature extends Base {

    private $featureFile;
    private $targetFeatureFile;
    private $model ;
    private $uploadDir ;
    private $configs ;

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "JFeature Install Feature");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
        $this->setCmdLineParams($params);
        $this->configs = new \GCWorkflowDeployerConfigClass();
        $this->model = new \GCWorkflowDeployerModelClass();
        $this->uploadDir = $this->configs->give("temp_pull_folder");
        if (substr($this->uploadDir, "-1", "1") != "/") { $this->uploadDir .= DS; }
    }

    public function askWhetherToInstallFeature() {
        return $this->performFeatureInstall();
    }

    private function performFeatureInstall() {
        if (!isset($this->featureFile)) { $this->featureFile = $this->askForFeatureFileLocation(); }
        $fileres = $this->receive();
        return $fileres;
    }

    private function setCmdLineParams($params) {
        foreach ($params as $param) {
            if ( substr($param, 0, 14)=="--feature-file"){
                $this->featureFile = substr($param, 15, strlen($param)-1); } }
        return true;
    }

    private function askForFeatureFileLocation(){
        $question = 'Enter Location of feature file to install';
        return self::askForInput($question, true);
    }

    /*
     * Here is the Receiver
     */
    private function receive() {
      $finalSlashPosition = strrpos($this->featureFile, '/')+1 ;
      $fileNameOnly = substr($this->featureFile, $finalSlashPosition) ;
      $uniqueid = substr($fileNameOnly, 0, 16);
      $pushtime = intval( substr($fileNameOnly, 17, (strlen($fileNameOnly)-4) ) );
      $this->targetFeatureFile = $this->uploadDir.$fileNameOnly ;
      if (copy($this->featureFile, $this->targetFeatureFile)) {
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'pullClass.php';
        $pullid = \GCWorkflowDeployerPullClass::createNewPull();
        $pull = new \GCWorkflowDeployerPullClass($pullid);
        $this->model->setUpdatePull($pullid, "push_key", "N/A");
        $this->model->setUpdatePull($pullid, "push_key_desc", "This pull was performed by JRush Command Line");
        $this->model->setUpdatePull($pullid, "pull_profile_uniqueid", $uniqueid );
        $this->model->setUpdatePull($pullid, "pull_time", time() );
        $this->model->setUpdatePull($pullid, "push_time", $pushtime );
        $this->model->setUpdatePull($pullid, "pull_status", "WAITING" );
        $pull->extractZip( $this->uploadDir.'/'.$fileNameOnly );
        $pullprofiledetails = $pull->getProfileDetails();
        $this->model->setUpdatePull($pullid, "pull_profile_title", $pullprofiledetails["push_profile_title"] );
        $this->model->setUpdatePull($pullid, "pull_profile_description", $pullprofiledetails["push_profile_description"] );
        return $fileNameOnly; }
      else {
        return "NOT OK"; }
    }

}