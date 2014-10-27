<?php

Namespace Controller ;

class JConfiguration extends Base {

    public function execute($pageVars) {

        $action = $pageVars["route"]["action"];

        $thisModel = $this->getModelAndCheckDependencies(substr(get_class($this), 11), $pageVars) ;
        // if we don't have an object, its an array of errors
        if (is_array($thisModel)) { return $this->failDependencies($pageVars, $this->content, $thisModel) ; }
        $isDefaultAction = self::checkDefaultActions($pageVars, array(), $thisModel) ;
        if ( is_array($isDefaultAction) ) { return $isDefaultAction; }

        if ($action=="configure" || $action== "config" || $action== "conf") {
            $this->content["result"] = $thisModel->askWhetherToConfigureDB();
            return array ("type"=>"view", "view"=>"jConfiguration", "pageVars"=>$this->content); }

        $this->content["messages"][] = "Invalid DB Configure Action";
        return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);
    }

}