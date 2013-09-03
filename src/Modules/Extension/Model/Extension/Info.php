<?php

Namespace Model\Extension;

class Info extends Base {

  protected $extensionId;
  protected $extensionElement;
  protected $extensionName ;

  public function __construct($params) {
    parent::__construct($params);
    $this->setCmdLineParams($params);
    $this->attemptBootstrap($params, "Extension Info");
  }

  public function askWhetherToGetExtensionInfo() {
    $this->findExtensionId();
    return $this->getExtensionInfo($this->extensionId);
  }

  private function getExtensionInfo($componentId) {
    $db = \JFactory::getDBO();
    $query = 'SELECT * FROM #__extensions WHERE extension_id="'.$componentId.'"  LIMIT 1';
    $db->setQuery($query);
    $db->query();
    return $db->loadObject();
  }

}