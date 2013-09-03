<?php

Namespace Model\Extension;

use Model\CoreBase;

class Base extends CoreBase {

    public function __construct($params) {
        parent::__construct($params);
        $adminCompPath = dirname($this->joomlaConfigFile)."/administrator/components/com_component";
        $compPath = dirname($this->joomlaConfigFile)."/components/com_component";
        define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
        define("JPATH_COMPONENT", $compPath ) ;
    }

    protected function findExtensionId(){
      if ($this->extensionId) {
        return; }
      else if ($this->extensionElement) {
        $this->extensionId = $this->getExtensionIdFromElement($this->extensionElement);
        return; }
      else if ($this->extensionName) {
        $this->extensionId = $this->getExtensionIdFromName($this->extensionName);
        return; }
      $question = 'Enter a Extension ID. To enter element/extension name use --extension-element or --extension-name parameters';
      $this->extensionId = self::askForInput($question, true);
    }

    protected function setCmdLineParams($params) {
      foreach ($params as $param) {
        if ( substr($param, 0, 14)=="--extension-id"){
          $this->extensionId = substr($param, 15, strlen($param)); }
        if ( substr($param, 0, 19)=="--extension-element"){
          $this->extensionElement = substr($param, 20, strlen($param)); }
        if ( substr($param, 0, 16)=="--extension-name"){
          $this->extensionName = substr($param, 17, strlen($param)); } }
      return true;
    }

    protected function getExtensionIdFromElement($element) {
      $db = \JFactory::getDBO();
      $query = 'SELECT extension_id FROM #__extensions WHERE element="'.$element.'" LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

    protected  function getExtensionIdFromName($componentName) {
      $db = \JFactory::getDBO();
      $query = 'SELECT extension_id FROM #__extensions WHERE name="'.$componentName.'" LIMIT 1' ;
      $db->setQuery($query);
      $db->query();
      $result = $db->loadResult();
      return $result;
    }

}
