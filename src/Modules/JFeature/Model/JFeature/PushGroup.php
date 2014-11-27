<?php

Namespace Model\JFeature;

class PushGroup extends Base {

    private $groupId;
    private $groupUnique;

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "JFeature Push Group");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
        $this->setCmdLineParams($params);
        $this->configs = new \GCWorkflowDeployerConfigClass();
        $this->model = new \GCWorkflowDeployerModelClass();
        $this->uploadDir = $this->configs->give("temp_push_folder");
        if (substr($this->uploadDir, "-1", "1") != DS) { $this->uploadDir .= DS; }
    }

    public function askWhetherToPushGroup() {
        $this->findGroupId();
        return $this->performGroupPush();
    }

    private function setCmdLineParams($params) {
        foreach ($params as $param) {
            if ( substr($param, 0, 10)=="--group-id") {
                $this->groupId = substr($param, 11, strlen($param)-1); }
            if ( substr($param, 0, 12)=="--group-name") {
              $this->groupName = substr($param, 13, strlen($param)-1); }
            if ( substr($param, 0, 14)=="--group-unique") {
              $this->groupUnique = substr($param, 15, strlen($param)-1); } }
        return true;
    }

    private function findGroupId(){
        if ($this->groupId) {
            return; }
        else if ($this->groupUnique) {
            $this->groupId = $this->getGroupIdFromUnique($this->groupUnique);
            return; }
        $question = 'Enter a Group ID from DB Table. To enter uninqueid use --group-unique parameter';
        $this->groupId = self::askForInput($question, true);
    }

    private function getGroupIdFromUnique($group_unique) {
        $db = \JFactory::getDBO();
        $query = "SELECT id FROM #__gcworkflowdeploy_groups WHERE " ;
        $query .= 'uniqueid="'.$group_unique.'" ' ;
        $db->setQuery($query);
        $db->query();
        $result = $db->loadResult();
        return $result;
    }

    private function performGroupPush() {
        $content = array() ;
        $content["groupid"] = $this->groupId ;
        $group = array();
        $group["groupDetails"] = $this->model->getSingleGroupDetails($content["groupid"]);
        $group["groupEntries"] = $this->model->getSingleGroupEntries($content["groupid"]);
        $content["group"] = $group;
        $serializedGroup = serialize($group);
        file_put_contents($this->configs->give("metadata_store_folder").DS.$group["groupDetails"]["uniqueid"].".group" ,
          $serializedGroup );
        $this->pushGroupEntries($group["groupEntries"]);
        return $content;
    }

    private function pushGroupEntries($groupEntries) {
        foreach ($groupEntries as $groupEntry) {
          if ($groupEntry["entry_type"]=="group") {
            /* get group id from name
            $childGroupEntries = $this->model->getSingleGroupEntries($content["groupid"]);
            $this->pushGroupEntries($childGroupEntries); */ }
          else if ($groupEntry["entry_type"]== "instance" ||
                   $groupEntry["entry_type"]== "allinprofile") {
            $profUnique = substr($groupEntry["target"], 0, 16);
            $this->pushProfileOnly($profUnique); } }
    }

    private function pushProfileOnly($uniqueid) {
        $profString = $this->getProfileToString($uniqueid) ;
        $profileFilePath = $this->configs->give("metadata_store_folder").DS.$uniqueid.".profile" ;
        file_put_contents($profileFilePath, $profString) ;
    }

    private function getProfileToString($uniqueid) {
        $profileray = $this->model->getSingleProfileDetailsFromUnique($uniqueid);
        $profileray["files"] = $this->model->getSingleProfileDetailFileFolders($uniqueid);
        $profileray["datatables"] = $this->model->getDBTablesToAction($uniqueid);
        $profilestring = serialize($profileray);
        return $profilestring;
    }

}