<?php

Namespace Model\Extension;

class Enable extends Base {

  protected $extensionId;
  protected $extensionElement;
  protected $extensionName ;

  public function __construct($params) {
    parent::__construct($params);
    $this->setCmdLineParams($params);
    $this->attemptBootstrap($params, "Extension Enable");
  }

  public function askWhetherToEnableExtension() {
    $this->findExtensionId();
    return $this->enableExtensionBypassingJFramework($this->extensionId);
  }

  private function enableExtensionBypassingJFramework($componentId) {
    $db = \JFactory::getDBO();
    $query = 'UPDATE #__extensions SET enabled="1" WHERE extension_id="'.$componentId.'"  LIMIT 1';
    $db->setQuery($query);
    $db->query();
    $query = 'SELECT * FROM #__extensions WHERE extension_id="'.$componentId.'"  LIMIT 1';
    $db->setQuery($query);
    $db->query();
    return $db->loadObject();
  }

}