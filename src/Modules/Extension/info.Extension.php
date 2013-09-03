<?php

Namespace Info;

class ExtensionInfo extends Base {

    public $hidden = false;

    public $name = "Extension - Manage a extension's details";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "Extension" =>  array_merge(parent::routesAvailable(), array("info", "disable", "enable") ) );
    }

    public function routeAliases() {
      return array("extension"=>"Extension");
    }

    public function groups() {
      // return array("group"=>"Module");
      return array();
    }

    public function dependencies() {
      // return array("dependency"=>"Module");
      return array();
    }

    public function autoPilotVariables() {
      return array(
        "Extension" => array(
          "Extension" => array(
            "programNameMachine" => "extension", // command and app dir name
            "programNameFriendly" => "Extension",
            "programNameInstaller" => "Extension - Update to latest version",
            "programExecutorTargetPath" => 'extension/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to manage Joomla Extensions (Component, Module or Plugin).

  Extension, extension

        - disable
        Deletes a extension
        example: jrush extension disable

        - enable
        Enables a extension
        example: jrush extension enable

        - info
        Display the details of a extension
        example: jrush extension info


HELPDATA;
      return $help ;
    }

}