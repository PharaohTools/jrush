<?php

Namespace Model\JFeature;

class Base extends \Model\CoreBase {

  public function __construct($params) {
    parent::__construct($params);
    $adminCompPath = dirname($this->joomlaConfigFile)."/administrator/components/com_gcworkflowdeploy";
    $compPath = dirname($this->joomlaConfigFile)."/components/com_gcworkflowdeploy";
    define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
    define("JPATH_COMPONENT", $compPath ) ;
  }

}
