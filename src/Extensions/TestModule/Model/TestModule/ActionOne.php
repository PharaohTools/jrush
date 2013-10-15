<?php

Namespace Model\TestModule;

class ActionOne extends Base {

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "TestModule Action One");
    }

    public function askWhetherToDoActionOne() {
        return $this->getAllArticleTitles();
    }

    private function getAllArticleTitles() {
        $db = \JFactory::getDBO();
        $query = 'SELECT title FROM #__content';
        $db->setQuery($query);
        $db->query();
        $titles = $db->loadColumn();
        return $titles ;
    }

}