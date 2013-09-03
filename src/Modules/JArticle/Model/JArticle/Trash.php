<?php

Namespace Model\JArticle;

class Trash extends Base {

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "JArticle Trash");
    }

    public function askWhetherToTrashJArticle() {
      $this->findJArticleId();
      return $this->trashJArticleBypassingJFramework($this->jarticleId);
    }

    private function trashJArticleBypassingJFramework($articleId) {
      $db = \JFactory::getDBO();
      $query = 'UPDATE #__content SET state="-2" WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      $query = 'SELECT * FROM #__content WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      return $db->loadObject();
    }

}