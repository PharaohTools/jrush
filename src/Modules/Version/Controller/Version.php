<?php

Namespace Controller ;

class Version extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="current") {
        $jFeatureModel = new \Model\Version\Current($extraParams);
        $this->content["jVersionResult"] = $jFeatureModel->askWhetherToGetJoomlaVersion();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"VersionJoomla", "pageVars"=>$this->content); }

      if ($action=="available") {
        $jFeatureModel = new \Model\Version\Available($extraParams);
        $this->content["jVersionResult"] = $jFeatureModel->askWhetherToListJoomlaVersions();
        $this->content["output-format"] = $jFeatureModel->outputFormat;
        return array ("type"=>"view", "view"=>"VersionJoomla", "pageVars"=>$this->content); }

      else {
            $this->content["genErrors"]="No Action"; }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"view", "view"=>"index", "pageVars"=>$this->content);

    }
    
}
