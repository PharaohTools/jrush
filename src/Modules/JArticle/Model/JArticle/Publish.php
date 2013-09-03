<?php

Namespace Model\JArticle;

class Publish extends Base {

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "JArticle Publish");
    }

    public function askWhetherToPublishJArticle() {
      $this->findJArticleId();
      return $this->publishJArticleBypassingJFramework($this->jarticleId);
    }

    private function publishJArticleBypassingJFramework($articleId) {
      $db = \JFactory::getDBO();
      $query = 'UPDATE #__content SET state="1" WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      $query = 'SELECT * FROM #__content WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      return $db->loadObject();
    }

}