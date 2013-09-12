<?php

Namespace Info;

class PostInputInfo extends Base {

    public $hidden = false;

    public $name = "HTTP Post Input Interface";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "PostInput" =>  array_merge(parent::routesAvailable() ) );
    }

    public function routeAliases() {
      return array();
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This module provides no commands, and Allows jrush to be executed by HTTP Post or Get variables.


HELPDATA;
      return $help ;
    }

}