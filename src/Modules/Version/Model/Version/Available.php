<?php

Namespace Model\Version;

class Available extends Base {

    public function __construct($params) {
      parent::__construct($params);
      $this->attemptBootstrap($params);
      if (!defined( '_JEXEC' ) ) {
        echo( "Version Available requires Jrush to bootstrap.\n" ); }
    }

    public function askWhetherToListJoomlaVersions() {
        return $this->listJoomlaVersions();
    }

    private function listJoomlaVersions() {
        $content = array();
        $content["availableVersions"][] = "1.5.0";
        $content["availableVersions"][] = "1.5.26";
        return $content;
    }

}