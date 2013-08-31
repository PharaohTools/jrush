<?php

Namespace Info;

class VersionInfo extends Base {

    public $hidden = false;

    public $name = "Version - Joomla Version Information";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Version" =>  array_merge(parent::routesAvailable(), array("available", "current") ) );
    }

    public function routeAliases() {
      return array("version"=>"Version");
    }

    public function autoPilotVariables() {
      return array(
        "Version" => array(
          "Version" => array(
            "programNameMachine" => "cache", // command and app dir name
            "programNameFriendly" => "Version",
            "programNameInstaller" => "Version - Update to latest version",
            "programExecutorTargetPath" => 'juser/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command Joomls Version information.

  Version, version

        - available
        Returns available Joomla Versions
        example: jrush version available

        - current
        Returns the current Joomla Version
        example: jrush version current

HELPDATA;
      return $help ;
    }

}