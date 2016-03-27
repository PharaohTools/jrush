<?php

Namespace Model;

class JConfigurationAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("Default") ;

    protected $platform;
    protected $platformVars;
    protected $settingsFileData;
    protected $configOptions ;

    public function __construct($params) {
        parent::__construct($params);
    }

    public function askWhetherToConfigureDB(){
        return $this->performDBConfiguration();
    }

    protected function performDBConfiguration(){
        if ( !$this->askForDBConfig() ) { return false; }
        // @todo $this->tryToDetectPlatform() ; try to autodetect the platform from the proj file before asking for it
        if (!$this->attemptBootstrap($this->params, "Joomla Configuration")) { return false; }
        $this->setPlatformVars();
        $this->setConfigOptions();
        $this->loadCurrentSettingsFile();
        $this->settingsFileDataChange();
        if ( !$this->checkSettingsFileOkay() ) { return false; }
        $this->removeOldSettingsFile();
        $this->createSettingsFile();
        return true;
    }

    public function getProperty($property) {
        return $this->$property;
    }

    public function setPlatformVars($platformVars = null) {
        if ($platformVars != null) {
            $this->platformVars = $platformVars; }
        else if ($this->platformVars == null) {
            $factory = new JConfiguration();
            $this->platformVars = $factory->getModel($this->params, "Joomla30Config") ; }
        return;
    }

    protected function setConfigOptions() {
        foreach ($this->platformVars->configOptions as $configOptionKey => $configOptionValue)  {
            if (isset($this->params["config_{$configOptionKey}"]) && is_string($this->params["config_{$configOptionKey}"])
                && strlen($this->params["config_{$configOptionKey}"])>0) {
                $this->configOptions[$configOptionKey] = $this->params["config_{$configOptionKey}"] ;
                continue ; }
            else if (isset($this->params["config_{$configOptionKey}"]) && isset($this->params["guess"]) && $this->params["guess"] == true) {
                $this->configOptions[$configOptionKey] = $this->platformVars->configOptions[$configOptionKey] ;
                continue ; }
            if (!isset($this->params["guess"]) || $this->params["guess"]==false) {
                $doChange = $this->askYesOrNo("Set non-default value for $configOptionKey? Default is $configOptionValue");
                if ($doChange) {
                    $this->configOptions[$configOptionKey] = $this->askForInput("What value for $configOptionKey?"); } } }
    }

    protected function askForPlatform(){
        if (isset($this->params["platform"])) { return $this->params["platform"] ; }
        $question = "Please Enter Project Platform:\n";
        $input = self::askForInput($question, true) ;
        return $input ;
    }

    protected function askForDBConfig(){
        $question = 'Do you want to configure Joomla?';
        return (isset($this->params["yes"])) ? true : self::askYesOrNo($question);
    }

    protected function askForDBConfigReset(){
        $question = 'Do you want to reset a Joomla configuration?';
        return (isset($this->params["yes"])) ? true : self::askYesOrNo($question);
    }

    protected function loadCurrentSettingsFile() {
        $this->settingsFileData = file($this->joomlaConfigFile);
    }

    protected function settingsFileDataChange(){
        $newFileLines = array() ;
        foreach($this->settingsFileData as $originalLine) {
            $lineInNewfile = $originalLine;
            foreach ($this->configOptions as $configOptionKey => $configOptionValue) {
                $lineInNewfile = $this->modifyLineIfNeeded($lineInNewfile, $configOptionKey, $configOptionValue) ; }
            $newFileLines[] = $lineInNewfile ; }
        $this->settingsFileData = implode("", $newFileLines ) ;
    }

    protected function modifyLineIfNeeded($lineInNewfile, $configOptionKey, $configOptionValue){
        $var = 'public $'.$configOptionKey ;
        $pos = strpos($lineInNewfile, $var) ;
        if ( !($pos === false) ) {
            $spaces = "" ;
            for ($i = 0; $i < 8; $i++) { $spaces .= " " ; }
            $lineInNewfile = $spaces.$var.' = '.'\''.$configOptionValue.'\''.";\n" ; }
        return $lineInNewfile ;
    }

    protected function checkSettingsFileOkay(){
        $question = 'Please check '.$this->platformVars->getProperty("friendlyName").' Settings file: '.$this->settingsFileData."\n\nIs this Okay?";
        return (isset($this->params["yes"])) ? true : self::askYesOrNo($question);
    }

    protected function createSettingsFile() {
        echo "Moving new settings file ".$this->joomlaConfigFile." in...\n" ;
        return file_put_contents($this->joomlaConfigFile, $this->settingsFileData);
    }

    protected function removeOldSettingsFile(){
        $command    = 'rm -f '.$this->joomlaConfigFile ;
        self::executeAndOutput($command, "Removing old settings file ".$this->joomlaConfigFile."...\n");
    }

}
