<?php

Namespace Model\JFeature;

class Base extends \Model\CoreBase {

  public function __construct($params) {
    parent::__construct($params);
    $adminCompPath = dirname($this->joomlaConfigFile)."/administrator/components/com_user";
    $compPath = dirname($this->joomlaConfigFile)."/components/com_user";
    define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
    define("JPATH_COMPONENT", $compPath ) ;
  }

}
