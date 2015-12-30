<?php

Namespace Info;

class JUserInfo extends Base {

    public $hidden = false;

    public $name = "JUser - Manage a user's details";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "JUser" =>  array_merge(parent::routesAvailable(), array("info", "user", "delete", "password") ) );
    }

    public function routeAliases() {
      return array("juser"=>"JUser");
    }

    public function autoPilotVariables() {
      return array(
        "JUser" => array(
          "JUser" => array(
            "programNameMachine" => "juser", // command and app dir name
            "programNameFriendly" => "JUser",
            "programNameInstaller" => "JUser - Update to latest version",
            "programExecutorTargetPath" => 'juser/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to update JUser.

  JUser, juser

        - delete
        Deletes a user
        example: jrush juser delete

        - info
        Display the details of a user
        example: jrush juser info

        - list
        List all site users
        example: jrush juser list

        - change the password of a user
        Change a users password
        example: jrush juser password

HELPDATA;
      return $help ;
    }

}