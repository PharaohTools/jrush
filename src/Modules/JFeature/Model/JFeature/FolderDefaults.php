<?php

Namespace Model\JFeature;

class FolderDefaults extends Base {

  public function __construct($params) {
      parent::__construct($params);
      $this->attemptBootstrap($params, "JFeature Modify Feature Folders");
      require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'configClass.php';
      require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'modelClass.php';
      require_once JPATH_COMPONENT_ADMINISTRATOR.DS.'viewClass.php';
      $this->configs = new \GCWorkflowDeployerConfigClass();
      $this->model = new \GCWorkflowDeployerModelClass();
  }

  public function askWhetherToSetDefaultFeatureFolders() {
      return $this->setDefaultFeatureFolders();
  }

  private function setDefaultFeatureFolders(){
      $content = array();
      $folders = array( "temp_push", "temp_pull", "feature_store", "metadata_store" );
      $content["store_folders"] = array();
      include ( JPATH_COMPONENT_ADMINISTRATOR.DS."configs".DS."userconfigs.php");
      foreach ($folders as $folder) {
          $this->configs->setUserVar($folder."_folder", JPATH_COMPONENT_ADMINISTRATOR.DS.$folder);
          $content["store_folders"][$folder] = $this->configs->give($folder."_folder"); }
      return $content;
  }

}