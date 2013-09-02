<?php

Namespace Controller ;

class JFeature extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="feature-install") {
        $jFeatureModel = new \Model\JFeature\InstallFeature($extraParams);
        $this->content["jFeatureFeatureInstallResult"] = $jFeatureModel->askWhetherToInstallFeature();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureFeatureInstall", "pageVars"=>$this->content); }

      if ($action=="feature-pull") {
        $jFeatureModel = new \Model\JFeature\PullFeature($extraParams);
        $this->content["jFeatureFeaturePullResult"] = $jFeatureModel->askWhetherToPullFeature();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureFeaturePull", "pageVars"=>$this->content); }

      if ($action=="feature-push") {
        $jFeatureModel = new \Model\JFeature\PushFeature($extraParams);
        $this->content["jFeatureFeaturePushResult"] = $jFeatureModel->askWhetherToPushFeature();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureFeaturePush", "pageVars"=>$this->content); }

      if ($action=="group-install") {
        $jFeatureModel = new \Model\JFeature\InstallGroup($extraParams);
        $this->content["jFeatureGroupInstallResult"] = $jFeatureModel->askWhetherToInstallGroup();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureGroupInstall", "pageVars"=>$this->content); }

      if ($action=="group-pull") {
        $jFeatureModel = new \Model\JFeature\PullGroup($extraParams);
        $this->content["jFeatureGroupPullResult"] = $jFeatureModel->askWhetherToPullGroup();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureGroupPull", "pageVars"=>$this->content); }

      if ($action=="group-push") {
        $jFeatureModel = new \Model\JFeature\PushGroup($extraParams);
        $this->content["jFeatureGroupPushResult"] = $jFeatureModel->askWhetherToPushGroup();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureGroupPush", "pageVars"=>$this->content); }

      if ($action=="folder-defaults") {
        $jFeatureModel = new \Model\JFeature\FolderDefaults($extraParams);
        $this->content["jFeatureFolderDefaultsResult"] = $jFeatureModel->askWhetherToSetDefaultFeatureFolders();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"jFeatureFolderDefaults", "pageVars"=>$this->content); }

      else {
            $this->content["genErrors"]="No Action"; }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"view", "view"=>"index", "pageVars"=>$this->content);

    }
    
}
