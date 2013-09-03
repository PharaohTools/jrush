<?php

Namespace Model\Extension;

class Disable extends Base {

    protected $extensionId;
    protected $extensionElement;
    protected $extensionName ;

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "Extension Disable");
    }

    public function askWhetherToDisableExtension() {
        $this->findExtensionId();
        return $this->disableExtensionBypassingJFramework($this->extensionId);
    }

    private function disableExtensionBypassingJFramework($componentId) {
      $db = \JFactory::getDBO();
      $query = 'UPDATE #__extensions SET enabled="0" WHERE extension_id="'.$componentId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      $query = 'SELECT * FROM #__extensions WHERE extension_id="'.$componentId.'"  LIMIT 1';
      $db->setQuery($query);
      $db->query();
      return $db->loadObject();
    }

}