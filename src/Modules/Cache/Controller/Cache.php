<?php

Namespace Controller ;

class Cache extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="site-clear") {
        $cacheClearModel = new \Model\Cache\Clear($extraParams);
        $this->content["SiteCacheClearResult"] = $cacheClearModel->askWhetherToClearSiteCache();
        return array ("type"=>"view", "view"=>"CacheClear", "pageVars"=>$this->content); }

      if ($action=="admin-clear") {
        $cacheClearModel = new \Model\Cache\Clear($extraParams);
        $this->content["AdminCacheClearResult"] = $cacheClearModel->askWhetherToClearAdminCache();
        return array ("type"=>"view", "view"=>"CacheClear", "pageVars"=>$this->content); }

      else {
            $this->content["genErrors"]="No Action"; }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"view", "view"=>"index", "pageVars"=>$this->content);

    }
    
}
