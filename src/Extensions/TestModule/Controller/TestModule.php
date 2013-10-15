<?php

Namespace Controller ;

class TestModule extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="action-one" || $action=="actionone") {
        $thisModel = new \Model\TestModule\ActionOne($extraParams);
        $this->content["result"] = $thisModel->askWhetherToDoActionOne();
        $this->content["output-format"] = $thisModel->outputFormat;
        return array ("type"=>"view", "view"=>"testModuleActionOne", "pageVars"=>$this->content); }

      if ($action=="action-two" || $action=="actiontwo") {
          $thisModel = new \Model\TestModule\ActionTwo($extraParams);
        $this->content["result"] = $thisModel->askWhetherToDoActionOne();
        $this->content["output-format"] = $thisModel->outputFormat;
        return array ("type"=>"view", "view"=>"testModuleActionTwo", "pageVars"=>$this->content); }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }
    
}
