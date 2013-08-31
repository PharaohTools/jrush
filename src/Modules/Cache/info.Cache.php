<?php

Namespace Info;

class CacheInfo extends Base {

    public $hidden = false;

    public $name = "Cache - Clear the website cache";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Cache" =>  array_merge(parent::routesAvailable(), array("site-clear", "admin-clear") ) );
    }

    public function routeAliases() {
      return array("cache"=>"Cache");
    }

    public function autoPilotVariables() {
      return array(
        "Cache" => array(
          "Cache" => array(
            "programNameMachine" => "cache", // command and app dir name
            "programNameFriendly" => "Cache",
            "programNameInstaller" => "Cache - Update to latest version",
            "programExecutorTargetPath" => 'juser/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to clear Cache.

  Cache, cache

        - site-clear
        Deletes a user
        example: jrush cache site-clear

        - admin-clear
        Clear the administrator cache
        example: jrush cache admin-clear

HELPDATA;
      return $help ;
    }

}