<?php

Namespace Model\JFeature;

class PullFeature extends Base {

  private $pullId;
  private $pullUniqueWithTime;

  public function __construct($params) {
    parent::__construct($params);
    $this->attemptBootstrap($params, "JFeature Pull Feature");
    require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
    require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
    require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
    $this->setCmdLineParams($params);
    $this->configs = new \GCWorkflowDeployerConfigClass();
    $this->model = new \GCWorkflowDeployerModelClass();
    $this->uploadDir = $this->configs->give("temp_pull_folder");
    if (substr($this->uploadDir, "-1", "1") != "/") { $this->uploadDir .= DS; }
  }

  public function askWhetherToPullFeature() {
    $this->findPullId();
    return $this->performFeaturePull();
  }

  private function setCmdLineParams($params) {
    $this->pullId = null ;
    $this->pullUniqueWithTime = null ;
    foreach ($params as $param) {
      if ( substr($param, 0, 9)=="--pull-id"){
        $this->pullId = substr($param, 10, strlen($param)); }
      if ( substr($param, 0, 18)=="--pull-unique-time"){
        $this->pullUniqueWithTime = substr($param, 19, strlen($param)); } }
    return true;
  }

  private function findPullId(){
    if ($this->pullId) {
      return; }
    else if ($this->pullUniqueWithTime) {
      $this->pullId = $this->getPullIdFromPullUniqueWithTime($this->pullUniqueWithTime);
      return; }
    $question = 'Enter a Pull ID from DB Table. To enter uninqueid_time use --pull-unique-time parameter';
    $this->pullId = self::askForInput($question, true);
  }

  private function getPullIdFromPullUniqueWithTime($pull_unique_and_time) {
      $uniqueid = substr($pull_unique_and_time, 0, 16);
      $pushtime = substr($pull_unique_and_time, 17, strlen($pull_unique_and_time));
      $db = \JFactory::getDBO();
      $query = "SELECT id FROM #__gcworkflowdeploy_pull_history WHERE " ;
      $query .= 'pull_profile_uniqueid="'.$uniqueid.'" AND push_time="'.$pushtime.'" ' ;
      $query .= 'ORDER BY pull_time DESC LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
  }

  private function performFeaturePull(){
      $content = array();
      $content["pullid"] = $this->pullId ;
      if ($content["pullid"] == null) {
        echo "No Pull ID Available. Are you sure this feature is installed?\n";
        die(); }
      require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."pullClass.php");
      $pull = new \GCWorkflowDeployerPullClass($content["pullid"]) ;
      $content["result_fileexists"] = $pull->checkFileExists();
      $pull->statusUpdate("FILEEXIST");
      $content["result_doLocalFileCopy"] = $pull->doLocalFileCopy();
      $pull->statusUpdate("LOCALCOPY");
      $content["result_doDbTableInstall"] = $pull->doTempDbTableInstall();
      $pull->statusUpdate("DBTBLINSTALL");
      $content["result_doDbTableRewrite"] = $pull->doNewDbTableRewrite();
      $pull->statusUpdate("DBTBLREWRITE");
      $content["result_doDbTableDrop"] = $pull->doTempDbTableDrop();
      $pull->statusUpdate("DBTBLDROP");
      if ( $this->configs->give("pull_backup_first")=="1" ) {
        $content["backup_first"] = 1; }
      else {
        $content["backup_first"] = 0; }
      if ( $this->configs->give("auto_pull_file_cleanup")=="1" ) {
        $content["result_cleanupFiles"] = $pull->cleanupFiles();
        $pull->statusUpdate("CLEANUPFILES"); }
        $pull->statusUpdate("COMPLETE");
      return $content;
  }

}