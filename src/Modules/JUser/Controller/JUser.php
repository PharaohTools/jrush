<?php

Namespace Controller ;

class JUser extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="delete") {
        $jUserModel = new \Model\JUser\Delete($extraParams);
        $this->content["jUserInfoResult"] = $jUserModel->askWhetherToDeleteUser();
        $this->content["output-format"] = $jUserModel->outputFormat;
        return array ("type"=>"view", "view"=>"jUserDelete", "pageVars"=>$this->content); }

      if ($action=="info") {
        $jUserModel = new \Model\JUser\Info($extraParams);
        $this->content["jUserInfoResult"] = $jUserModel->askWhetherToGetUserInfo();
        $this->content["output-format"] = $jUserModel->outputFormat;
        return array ("type"=>"view", "view"=>"jUserInfo", "pageVars"=>$this->content); }

      if ($action=="password") {
        $jUserModel = new \Model\JUser\Password($extraParams);
        $this->content["jUserInfoResult"] = $jUserModel->askWhetherToUpdateUserPassword();
        $this->content["output-format"] = $jUserModel->outputFormat;
        return array ("type"=>"view", "view"=>"jUserPassword", "pageVars"=>$this->content); }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }
    
}
