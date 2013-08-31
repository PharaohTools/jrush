<?php

Namespace Model\Version;

class Current extends Base {

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "Version Current");
    }

    public function askWhetherToGetJoomlaVersion() {
        return $this->getJoomlaVersion();
    }

    private function getJoomlaVersion() {
        $content = array();
        $jVersion = new \JVersion();
        $content["shortVersion"] = $jVersion->getShortVersion();
        $content["longVersion"] = $jVersion->getLongVersion();
        $content["detailed"] = new \ArrayObject($jVersion);
        return $content;
    }

}