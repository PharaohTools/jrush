<?php

Namespace Model\JArticle;

use Model\CoreBase;

class Base extends CoreBase {

    protected $jarticleId;
    protected $jarticleAssetId;
    protected $jarticleTitle;
    protected $jarticleAlias;

    public function __construct($params) {
        parent::__construct($params);
        $adminCompPath = dirname($this->joomlaConfigFile)."/administrator/components/com_content";
        $compPath = dirname($this->joomlaConfigFile)."/components/com_content";
        define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
        define("JPATH_COMPONENT", $compPath ) ;
    }

    protected function findJArticleId(){
      if ($this->jarticleId) {
        return; }
      else if ($this->jarticleAssetId) {
        $this->jarticleId = $this->getJArticleIdFromAssetId($this->jarticleAssetId);
        return; }
      else if ($this->jarticleTitle) {
        $this->jarticleId = $this->getJArticleIdFromTitle($this->jarticleTitle);
        return; }
      else if ($this->jarticleAlias) {
        $this->jarticleId = $this->getJArticleIdFromAlias($this->jarticleAlias);
        return; }
      $question = 'Enter a JArticle ID. To enter title/alias/asset-id use --jarticle-title, --jarticle-alias or --jarticle-asset-id parameters';
      $this->jarticleId = self::askForInput($question, true);
    }

    protected function setCmdLineParams($params) {
      foreach ($params as $param) {
        if ( substr($param, 0, 13)=="--jarticle-id"){
          $this->jarticleId = substr($param, 14, strlen($param)); }
        if ( substr($param, 0, 19)=="--jarticle-asset-id"){
          $this->jarticleAssetId = substr($param, 20, strlen($param)); }
        if ( substr($param, 0, 16)=="--jarticle-title"){
          $this->jarticleTitle = substr($param, 17, strlen($param)); }
        if ( substr($param, 0, 16)=="--jarticle-alias"){
          $this->jarticleAlias = substr($param, 17, strlen($param)); } }
      return true;
    }

    protected function getJArticleIdFromAssetId($assetId) {
      $db = \JFactory::getDBO();
      $query = 'SELECT id FROM #__content WHERE element="'.$assetId.'" LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

    protected  function getJArticleIdFromTitle($title) {
      $db = \JFactory::getDBO();
      $query = 'SELECT id FROM #__content WHERE title="'.$title.'" LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

    protected  function getJArticleIdFromAlias($alias) {
      $db = \JFactory::getDBO();
      $query = 'SELECT id FROM #__content WHERE alias="'.$alias.'" LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

}
