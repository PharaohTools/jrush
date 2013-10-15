<?php

Namespace Info;

class TestModuleInfo extends Base {

    public $hidden = false;

    public $name = "TestModule - Example of Module Development";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "TestModule" =>  array_merge(parent::routesAvailable(), array("action-one", "actionone",
          "action-two", "actiontwo") ) );
    }

    public function routeAliases() {
      return array("testmodule"=>"TestModule", "test-module"=>"TestModule");
    }

    public function autoPilotVariables() {
      return array(
        "TestModule" => array(
          "TestModule" => array(
            "programNameMachine" => "testmodule", // command and app dir name
            "programNameFriendly" => "TestModule",
            "programNameInstaller" => "TestModule - Update to latest version",
            "programExecutorTargetPath" => 'jrush/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to update TestModule.

  TestModule, testmodule, test-module

        - action-one
        An example action. Currently, we get all titles of articles
        example: jrush test-module action-one

        - action-two
        An example action. Currently, we get all titles of articles
        example: jrush test-module action-two

HELPDATA;
      return $help ;
    }

}