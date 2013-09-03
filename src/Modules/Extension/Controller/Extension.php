<?php

Namespace Controller ;

class Extension extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="disable") {
        $jExtensionModel = new \Model\Extension\Disable($extraParams);
        $this->content["jExtensionInfoResult"] = $jExtensionModel->askWhetherToDisableExtension();
        $this->content["output-format"] = $jExtensionModel->outputFormat;
        return array ("type"=>"view", "view"=>"jExtension", "pageVars"=>$this->content); }

      if ($action=="enable") {
        $jExtensionModel = new \Model\Extension\Enable($extraParams);
        $this->content["jExtensionInfoResult"] = $jExtensionModel->askWhetherToEnableExtension();
        $this->content["output-format"] = $jExtensionModel->outputFormat;
        return array ("type"=>"view", "view"=>"jExtension", "pageVars"=>$this->content); }

      if ($action=="info") {
        $jExtensionModel = new \Model\Extension\Info($extraParams);
        $this->content["jExtensionInfoResult"] = $jExtensionModel->askWhetherToGetExtensionInfo();
        $this->content["output-format"] = $jExtensionModel->outputFormat;
        return array ("type"=>"view", "view"=>"jExtension", "pageVars"=>$this->content); }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }
    
}
