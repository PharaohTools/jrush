<?php

Namespace Info;

class JArticleInfo extends Base {

    public $hidden = false;

    public $name = "JArticle - Manage a jarticle's details";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "JArticle" =>  array_merge(parent::routesAvailable(), array("info", "publish", "pub", "unpublish", "unpub",
         "trash", "archive") ) );
    }

    public function routeAliases() {
      return array("jarticle"=>"JArticle");
    }

    public function groups() {
      // return array("group"=>"Module");
      return array();
    }

    public function dependencies() {
      // return array("dependency"=>"Module");
      // return array();
      return array("JFeature"=>"JArticle");
    }

    public function autoPilotVariables() {
      return array(
        "JArticle" => array(
          "JArticle" => array(
            "programNameMachine" => "jarticle", // command and app dir name
            "programNameFriendly" => "JArticle",
            "programNameInstaller" => "JArticle - Update to latest version",
            "programExecutorTargetPath" => 'jarticle/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command allows you to manage Joomla JArticles (Component, Module or Plugin).

  JArticle, jarticle

        - disable
        Deletes a jarticle
        example: jrush jarticle disable

        - enable
        Enables a jarticle
        example: jrush jarticle enable

        - info
        Display the details of a jarticle
        example: jrush jarticle info


HELPDATA;
      return $help ;
    }

}