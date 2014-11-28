<?php

Namespace Model\JFeature;

class PullGroup extends Base {

    private $groupId;
    private $groupUnique;
    private $groupName;

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "JFeature Pull Group");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
        $this->setCmdLineParams($params);
        $this->configs = new \GCWorkflowDeployerConfigClass();
        $this->model = new \GCWorkflowDeployerModelClass();
        $this->uploadDir = $this->configs->give("temp_pull_folder");
        if (substr($this->uploadDir, "-1", "1") != DS) { $this->uploadDir .= DS; }
    }

    public function askWhetherToPullGroup() {
      $this->findGroupId();
      return $this->performGroupPull();
    }

    public function silentPullGroup() {
      return $this->performGroupPull();
    }

    private function setCmdLineParams($params) {
      foreach ($params as $param) {
        if ( substr($param, 0, 10)=="--group-id") {
          $this->groupId = substr($param, 11, strlen($param)); }
        if ( substr($param, 0, 12)=="--group-name") {
          $this->groupName = substr($param, 13, strlen($param)); }
          if ( substr($param, 0, 17)=="--group-unique-id") {
              $this->groupUnique = substr($param, 18, strlen($param)); }
          if ( substr($param, 0, 14)=="--group-unique" && substr($param, 0, 17)!="--group-unique-id") {
              $this->groupUnique = substr($param, 15, strlen($param)); } }
      return true;
    }

    private function findGroupId(){
      if ($this->groupId) {
        return; }
      else if ($this->groupUnique) {
        $this->groupId = $this->getGroupIdFromUnique($this->groupUnique);
        return; }
      else if ($this->groupName) {
        $this->groupId = $this->getGroupIdFromName($this->groupUnique);
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

    private function getGroupIdFromName($group_name) {
      $db = \JFactory::getDBO();
      $query = "SELECT id FROM #__gcworkflowdeploy_groups WHERE " ;
      $query .= 'group_name="'.$group_name.'" ' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

    private function performGroupPull() {
      $content = array() ;
      $content["groupid"] = $this->groupId ;
      $group = array();
      $group["groupDetails"] = $this->model->getSingleGroupDetails($content["groupid"]);
      $group["groupEntries"] = $this->model->getSingleGroupEntries($content["groupid"]);
      $content["group"] = $group;
      $outputLog = array();
        var_dump("gd", $group["groupDetails"], "ge", $group["groupEntries"])   ;
      foreach ($group["groupEntries"] as $groupEntry) {
          if ($groupEntry["entry_type"]=="group") {
              $pullGroup = new PullGroup(array('--group-name="'.$groupEntry["target"].'"'));
              $outputLog[] = $pullGroup->silentPullGroup() ; }
          else if ($groupEntry["entry_type"]=="instance") {
              $profUniqueTime = substr($groupEntry["target"], 0, strlen($groupEntry["target"])-4);
              $pullFeature = new PullFeature(array('--pull-unique-time="'.$profUniqueTime.'"'));
              $outputLog[] = $pullFeature->askWhetherToPullFeature() ; }
          else if ($groupEntry["entry_type"]=="allinprofile") {
              $allFeatureFiles = scandir($this->configs->give("feature_store_folder"));
              $affi = 0;
              foreach ($allFeatureFiles as &$availableFeatureFile) {
                $fileExt = substr($availableFeatureFile, strlen($availableFeatureFile)-4, 4);
                if ($fileExt != ".zip") { unset($allFeatureFiles[$affi]); }
                $affi++; }
              $profFeatUniqueTimes = array();
              foreach ($allFeatureFiles as $availableFeatureFile) {
                  $profile_id_only = substr($availableFeatureFile, 0, 16);
                  if ($profile_id_only == $groupEntry["target"]) {
                      $profFeatUniqueTimes[] = substr($availableFeatureFile, 0, strlen($availableFeatureFile)-4); } }
              foreach ($profFeatUniqueTimes as $profFeatUniqueTime) {
                  $instVar ='--feature-file='.$this->configs->give("feature_store_folder").DS.$profFeatUniqueTime.'.zip';
                  $installRay = array($instVar, '--config-file='.$this->joomlaConfigFile);
                  $installFeature = new InstallFeature($installRay);
                  $installFeature->askWhetherToInstallFeature();
                  $pullFeature = new PullFeature(array('--pull-unique-time='.$profFeatUniqueTime, '--config-file='.$this->joomlaConfigFile));
                  $outputLog[] = $pullFeature->askWhetherToPullFeature() ; } } }
      return $outputLog;
    }

}