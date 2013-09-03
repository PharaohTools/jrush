<?php

Namespace Controller ;

class JArticle extends Base {

    public function execute($pageVars) {
      $isHelp = parent::checkForHelp($pageVars) ;
      if ( is_array($isHelp) ) {
        return $isHelp; }
      $action = $pageVars["route"]["action"];
      $extraParams = $pageVars["route"]["extraParams"];

      if ($action=="publish" || $action=="pub") {
        $jJArticleModel = new \Model\JArticle\Publish($extraParams);
        $this->content["jJArticleInfoResult"] = $jJArticleModel->askWhetherToPublishJArticle();
        $this->content["output-format"] = $jJArticleModel->outputFormat;
        return array ("type"=>"view", "view"=>"jArticle", "pageVars"=>$this->content); }

      if ($action=="unpublish" || $action=="unpub") {
        $jJArticleModel = new \Model\JArticle\Unpublish($extraParams);
        $this->content["jJArticleInfoResult"] = $jJArticleModel->askWhetherToUnpublishJArticle();
        $this->content["output-format"] = $jJArticleModel->outputFormat;
        return array ("type"=>"view", "view"=>"jArticle", "pageVars"=>$this->content); }

      if ($action=="archive") {
        $jJArticleModel = new \Model\JArticle\Archive($extraParams);
        $this->content["jJArticleInfoResult"] = $jJArticleModel->askWhetherToArchiveJArticle();
        $this->content["output-format"] = $jJArticleModel->outputFormat;
        return array ("type"=>"view", "view"=>"jArticle", "pageVars"=>$this->content); }

      if ($action=="trash") {
        $jJArticleModel = new \Model\JArticle\Trash($extraParams);
        $this->content["jJArticleInfoResult"] = $jJArticleModel->askWhetherToTrashJArticle();
        $this->content["output-format"] = $jJArticleModel->outputFormat;
        return array ("type"=>"view", "view"=>"jArticle", "pageVars"=>$this->content); }

      if ($action=="info") {
        $jJArticleModel = new \Model\JArticle\Info($extraParams);
        $this->content["jJArticleInfoResult"] = $jJArticleModel->askWhetherToGetJArticleInfo();
        $this->content["output-format"] = $jJArticleModel->outputFormat;
        return array ("type"=>"view", "view"=>"jArticle", "pageVars"=>$this->content); }

      $this->content["messages"][] = "Invalid Action";
      return array ("type"=>"control", "control"=>"index", "pageVars"=>$this->content);

    }
    
}
