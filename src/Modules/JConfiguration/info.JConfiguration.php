<?php

Namespace Info;

class JConfigurationInfo extends Base {

    public $hidden = false;

    public $name = "Configuration File Options";

    public function _construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "JConfiguration" => array_merge(
          parent::routesAvailable(),
          array("configure", "config", "conf", "reset"),
          $this->getExtraRoutes()
      ) );
    }

    public function routeAliases() {
      return array("jconfiguration"=>"JConfiguration", "jconfigure"=>"JConfiguration", "jconf"=>"JConfiguration");
    }

    public function helpDefinition() {
        $extraHelp = $this->getExtraHelpDefinitions() ;
        $help = 'This command is part of Default Modules and handles your Joomla Configuration file settings.

  JConfiguration, jconfigure, jconfiguration, jconf

      - configure, conf
      Change any value of your Joomla configuration file
      example: '.PHARAOH_APP.' jconf conf joomla
      example: '.PHARAOH_APP.' jconf conf --yes --platform=joomla30 --mysql-host=127.0.0.1 --mysql-admin-user=""

      - reset
      reset current db to generic values so '.PHARAOH_APP.' can write them. may need to be run before db conf.
      example: '.PHARAOH_APP.' jconf reset drupal
      example: '.PHARAOH_APP.' jconf reset --yes --platform=joomla30

      '.$extraHelp;
      return $help ;
    }


    protected function getExtraHelpDefinitions() {
        $extraDefsText = "" ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        foreach ($infos as $info) {
            if (method_exists($info, "helpDefinitions")) {
                $defNames = array_keys($info->helpDefinitions());
                if (in_array("JConfiguration", $defNames)) {
                    $defs = $info->helpDefinitions() ;
                    $thisDef = $defs["JConfiguration"] ;
                    $extraDefsText .= $thisDef ; } } }
        return $extraDefsText ;
    }

    protected function getExtraRoutes() {
        $extraActions = array() ;
        $infos = \Core\AutoLoader::getInfoObjects() ;
        foreach ($infos as $info) {
            if (method_exists($info, "cmsConfigureActions")) {
                $extraActions = array_merge($extraActions, $info->cmsConfigureActions()); } }
        return $extraActions ;
    }


}