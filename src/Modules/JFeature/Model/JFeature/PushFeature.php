<?php

Namespace Model\JFeature;

class PushFeature extends Base {

    private $pushUnique ;
    private $pushType ;

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "JFeature Push Feature");
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
        require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
        $this->setCmdLineParams($params);
        $this->configs = new \GCWorkflowDeployerConfigClass();
        $this->model = new \GCWorkflowDeployerModelClass();
        $this->uploadDir = $this->configs->give("temp_pull_folder");
        if (substr($this->uploadDir, "-1", "1") != "/") { $this->uploadDir .= DS; }
    }

    public function askWhetherToPushFeature() {
        $this->findPushUnique();
        $this->findPushType();
        return $this->performFeaturePush();
    }

    private function setCmdLineParams($params) {
        foreach ($params as $param) {
            if ( substr($param, 0, 16)=="--profile-unique") {
              $this->pushUnique = substr($param, 17, strlen($param)-1); }
            if ( substr($param, 0, 11)=="--push-type") {
              $this->pushType = substr($param, 12, strlen($param)-1); } }
        return true;
    }

    private function findPushUnique() {
      if ($this->pushUnique) { return; }
      $question = 'Enter a Profile Unique ID. Alternatively use --profile-unique parameter' ;
      $this->pushUnique = self::askForInput($question, true) ;
    }

    private function findPushType() {
      if ($this->pushType && in_array($this->pushType, array("remote", "local")) ) { return; }
      else if ($this->pushType && !in_array($this->pushType, array("remote", "local")) ) {
        $question = 'Push Type MUST be remote or local. Please enter a push type' ;
        $this->pushType = self::askForInput($question, true);
        $this->findPushType(); }
      else {
        $question = 'Enter a Push Type. Alternatively use --push-type parameter.' ;
        $this->pushType = self::askForInput($question, true) ;
        $this->findPushType(); }
    }

    private function performFeaturePush() {
        $content = array();
        if ( count($this->messages)>0 ) {
          $content["messages"] = $this->messages ; }
        $content["pushid"] = $this->model->setNewPushID() ;
        $profile = $this->model->getSingleProfileDetailsFromUnique($this->pushUnique);
        $this->model->setUpdatePush($content["pushid"], "push_profile_title", $profile["profile_title"] );
        $this->model->setUpdatePush($content["pushid"], "push_profile_uniqueid", $profile["profile_uniqueid"] );
        $this->model->setUpdatePush($content["pushid"], "push_profile_description", $profile["profile_description"] );
        $this->model->setUpdatePush($content["pushid"], "push_time", time() );
        $this->model->setUpdatePush($content["pushid"], "push_status", "START" );
        require_once(JPATH_COMPONENT_ADMINISTRATOR.DS."pushClass.php");
        $pushdetails = $this->model->getSinglePushDetails($content["pushid"]);
        $content["target_url"] = $pushdetails["push_serv_website_url"];
        $push = new \GCWorkflowDeployerPushClass($content["pushid"]) ;
        $content["result_spacecreation"] = $push->doSpaceCreate();
        $push->statusUpdate("SPACECREATE");
        $content["result_doLocalFileCopy"] = $push->doLocalFileCopy();
        $push->statusUpdate("LOCALCOPY");
        $content["result_doTableDump"] = $push->doTableDump();
        $push->statusUpdate("TABLEDUMP");
        $content["result_createArchive"] = $push->createArchive();
        $push->statusUpdate("ZIPPED");
        $content["result_getArchiveSize"] = $push->getArchiveSize();
        $push->statusUpdate("LOCALZIPSIZE");
        $content["result_doFileMove"] = $push->doFileMove();
        $push->statusUpdate("FILEMOVED");
        $content["result_getRemoteArchiveSize"] = $push->getRemoteArchiveSize($content["result_doFileSend"]);
        if ( is_int($content["result_getRemoteArchiveSize"]) ) {
          $content["result_getRemoteArchiveSize"] = '	OK - '.$content["result_getRemoteArchiveSize"].' Bytes'; }
        else {
          $content["result_getRemoteArchiveSize"] = '	FAILED - '.$content["result_getRemoteArchiveSize"]; }
        $push->statusUpdate("REMOTEFILESIZE");
        if ( $this->configs->give("auto_push_file_cleanup")=="1" ) {
          $content["result_cleanupFiles"] = $push->cleanupFiles(); //done
          $push->statusUpdate("CLEANUPFILES"); }
        $push->statusUpdate("COMPLETE");
        return $content;
    }

}
