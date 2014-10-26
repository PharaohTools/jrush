<?php

Namespace Model;

class JConfigurationDataJoomla3 extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Joomla30Config") ;

    private $friendlyName = 'Joomla 3.x Series';
    private $shortName = 'Joomla30';
    private $settingsFileLocation = ''; // no trail slash, empty for root
    private $settingsFileName = 'configuration.php';

    public $configOptions ;

    public function __construct($params){
        parent::__construct($params) ;
        $this->setProperties();
        $this->setReplacements();
    }

    protected function setProperties() {
        $prefix = (isset($this->params["parent-path"])) ? $this->params["parent-path"] : "" ;
        if (strlen($prefix) > 0) {
            $this->settingsFileLocation = $prefix; }
        else {
            $this->settingsFileName = 'src/configuration.php'; }
    }

    public function getProperty($property) {
        return $this->$property;
    }

    public function __call($var1, $var2){
        return "" ; // @todo what even is this
    }

    private function setReplacements(){
        $this->configOptions = array(
            'log_path' => $this->getLogPath(),
            'tmp_path' => $this->getTmpPath(),
        );
    }

    private function getLogPath(){
        return $this->getJRoot().DS.'logs';
    }

    private function getTmpPath(){
        return $this->getJRoot().DS.'tmp';
    }

    private function getJRoot(){
        return dirname($this->params["config-file"]) ;
    }

}
