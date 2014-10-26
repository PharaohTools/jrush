<?php

Namespace Info;

class JRushRequiredInfo extends Base {

    public $hidden = true;

    public $name = "JRush Required Models";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "JRushRequired" =>  array_merge(parent::routesAvailable() ) );
    }

    public function routeAliases() {
      return array();
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module provides no commands, but is required for JRush. It provides Models which are required for JRush.

HELPDATA;
      return $help ;
    }

}