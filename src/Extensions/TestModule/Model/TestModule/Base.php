<?php

Namespace Model\TestModule;

use Model\CoreBase;

class Base extends CoreBase {

    public function __construct($params) {
        parent::__construct($params);
//        If you need JPATH_COMPONENT or JPATH_COMPONENT_ADMINISTRATOR then uncomment and configure these
//        $adminCompPath = dirname($this->joomlaConfigFile)."/administrator/components/com_user";
//        $compPath = dirname($this->joomlaConfigFile)."/components/com_user";
//        define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
//        define("JPATH_COMPONENT", $compPath ) ;
    }

}
