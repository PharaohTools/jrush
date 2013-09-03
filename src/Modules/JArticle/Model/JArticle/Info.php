<?php

Namespace Model\JArticle;

class Info extends Base {

  public function __construct($params) {
    parent::__construct($params);
    $this->setCmdLineParams($params);
    $this->attemptBootstrap($params, "JArticle Info");
  }

  public function askWhetherToGetJArticleInfo() {
    $this->findJArticleId();
    return $this->getJArticleInfo($this->jarticleId);
  }

  private function getJArticleInfo($articleId) {
    $db = \JFactory::getDBO();
    $query = 'SELECT * FROM #__content WHERE id="'.$articleId.'"  LIMIT 1';
    $db->setQuery($query);
    $db->query();
    return $db->loadObject();
  }

}