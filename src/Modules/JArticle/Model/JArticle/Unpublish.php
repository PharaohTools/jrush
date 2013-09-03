<?php

Namespace Model\JArticle;

class Unpublish extends Base {

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "JArticle Unpublish");
    }

    public function askWhetherToUnpublishJArticle() {
        $this->findJArticleId();
        return $this->unpublishJArticleBypassingJFramework($this->jarticleId);
    }

    private function unpublishJArticleBypassingJFramework($articleId) {
      $db = \JFactory::getDBO();
      $query = 'UPDATE #__content SET state="0" WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      $query = 'SELECT * FROM #__content WHERE id="'.$articleId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      return $db->loadObject();
    }

}