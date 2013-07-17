<?php

Namespace Info;

class Firefox17Info extends Base {

    public $hidden = false;

    public $name = "Firefox17";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Firefox17" =>  array_merge(parent::defaultActionsAvailable(), array("install") ) );
    }

    public function routeAliases() {
      return array("ff17"=>"Firefox17", "firefox17"=>"Firefox17");
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to install Firefox17.

  Firefox17, ff17, firefox17

        - install
        Installs the latest version of Firefox 17
        example: cleopatra firefox17 install

HELPDATA;
      return $help ;
    }

}