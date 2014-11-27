<?php

Namespace Info;

class JFeatureInfo extends Base {

    public $hidden = false;

    public $name = "JFeature - Joomla JFeature Component Management";

    public function __construct() {
      parent::__construct();
    }

    public function routesAvailable() {
      return array( "JFeature" =>  array_merge(parent::routesAvailable(), array("folder-defaults", "feature-install",
        "feature-pull", "feature-push", "group-install", "group-pull", "group-push" ) ) );
    }

    public function routeAliases() {
      return array("jfeature"=>"JFeature");
    }

    public function autoPilotVariables() {
      return array(
        "JFeature" => array(
          "JFeature" => array(
            "programNameMachine" => "cache", // command and app dir name
            "programNameFriendly" => "JFeature",
            "programNameInstaller" => "JFeature - Update to latest version",
            "programExecutorTargetPath" => 'juser/src/Bootstrap.php',
          )
        )
      );
    }

    public function helpDefinition() {
      $help = <<<"HELPDATA"
  This command manages the JFeature Component for Stage Migration.

  JFeature, jfeature

        - folder-defaults
          Reset the feature file storage folders being used to the default
          example jrush jfeature folder-defaults --config-file="/var/www/website/configuration.php"

        - feature-install
          Install the metadata for a database migration, fileset, or both from the GC Features component
          example jrush jfeature feature-install --feature-file="/var/www/website/XXX_XXX.zip" --config-file="/var/www/website/configuration.php"

        - feature-pull
          perform a pull on an installed feature so it is integrated into the site, db and file changes executed.
          example jrush jfeature feature-pull --pull-unique-time="XXX_XXX" --config-file="/var/www/website/configuration.php"
          example jrush jfeature feature-pull --pull-id="XX" --config-file="/var/www/website/configuration.php"

        - feature-push
          perform a push on an installed feature so it is saved locally.
          example jrush jfeature feature-push --profile-unique="XXX" --config-file="/var/www/website/configuration.php" --push-type="local"

        - group-install
          Install the metadata for a database migration, fileset, or both from the GC Features component
          example jrush jfeature group-install --group-file="/var/www/website/XXXX.group" --config-file="/var/www/website/configuration.php"

        - group-push
          perform a push of a group profile into a locally saved file.
          example jrush jfeature group-push --group-unique="XXXXXXXXXXXXXXXX" --config-file="/var/www/website/configuration.php"

        - group-pull
          perform a pull on all installed features in the specified group so they are integrated into the site, db and
          file changes executed.
          example jrush jfeature group-pull --group-id="XX" --config-file="/var/www/website/configuration.php"
          example jrush jfeature group-pull --group-name="my group" --config-file="/var/www/website/configuration.php"
          example jrush jfeature group-pull --group-unique="XX1234" --config-file="/var/www/website/configuration.php"

HELPDATA;
      return $help ;
    }

}