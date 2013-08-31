<?php

Namespace Model\Cache;

use Model\CoreBase;

class Base extends \Model\CoreBase {

    public function __construct($params) {
        parent::__construct($params);
        $adminCompPath = dirname(parent::$joomlaConfigFile)."/administrator/components/com_user";
        $compPath = dirname(parent::$joomlaConfigFile)."/components/com_user";
        define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
        define("JPATH_COMPONENT", $compPath ) ;
    }

}
