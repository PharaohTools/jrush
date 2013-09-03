<?php

Namespace Model;

class CoreBase {

    protected $joomlaConfigFile ;
    public $outputFormat ;

    public function __construct($params=null) {
        $this->setBaseCmdLineParams($params);
    }

    protected function attemptBootstrap($params, $caller){
      $this->bootStrapJoomla($params);
      if (!defined( '_JEXEC' )) {
        echo "$caller requires JRush to bootstrap.\n" ; }
    }

    protected function bootStrapJoomla($params) {
        if ($params==null) { echo "No params for Joomla when bootstrapping. Is --config-file param correct?\n"; }
        else {
          $jConfig = $this->loadJConfig();
          if ($jConfig==false) { echo "Can't create jconfig. Is path to configuration.php correct?\n" ;  }
          /* if (!is_object($jConfig)) { die("Can't create jconfig. Is path to configuration.php correct?\n");  } */
          $jRoot = dirname($this->joomlaConfigFile) ;
          if (!defined('_JEXEC')) { define( '_JEXEC', 1 ); }
          if (!defined('JPATH_BASE')) { define('JPATH_BASE', $jRoot ); }
          $joomla30LoaderExists = file_exists(JPATH_BASE .'/libraries/import.php');
          if (!$joomla30LoaderExists) { require_once ('Loader.php'); }
          if ($joomla30LoaderExists) { require_once (JPATH_BASE .'/libraries/import.php'); }
          require_once ( JPATH_BASE .'/includes/defines.php' );
          require_once ( JPATH_BASE .'/includes/framework.php' );
          if(!defined('DS')) { define('DS',DIRECTORY_SEPARATOR); }
          $mainframe = \JFactory::getApplication('site');
          $mainframe->initialise(); }
    }

    protected function executeAndOutput($command, $message=null) {
        $outputArray = array();
        exec($command, $outputArray);
        $outputText = "";
        foreach ($outputArray as $outputValue) {
            $outputText .= "$outputValue\n"; }
        if ($message !== null) {
            $outputText .= "$message\n"; }
        print $outputText;
        return true;
    }

    protected function executeAndLoad($command) {
        $outputArray = array();
        exec($command, $outputArray);
        $outputText = "";
        foreach ($outputArray as $outputValue) {
            $outputText .= "$outputValue\n"; }
        return $outputText;
    }

    protected function askYesOrNo($question) {
        print "$question (Y/N) \n";
        $fp = fopen('php://stdin', 'r');
        $last_line = false;
        while (!$last_line) {
            $inputChar = fgetc($fp);
            $yesOrNo = ($inputChar=="y"||$inputChar=="Y") ? true : false;
            $last_line = true; }
        return $yesOrNo;
    }

    protected function areYouSure($question) {
        print "!! Sure? $question (Y/N) !!\n";
        $fp = fopen('php://stdin', 'r');
        $last_line = false;
        while (!$last_line) {
            $inputChar = fgetc($fp);
            $yesOrNo = ($inputChar=="y"||$inputChar=="Y") ? true : false;
            $last_line = true; }
        return $yesOrNo;
    }

    protected function askForDigit($question) {
        $fp = fopen('php://stdin', 'r');
        $last_line = false;
        $i = 0;
        while ($last_line == false ) {
            print "$question\n";
            $inputChar = fgetc($fp);
            if (in_array($inputChar, array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9")) ) {
              $last_line = true; }
            else {
              echo "You must enter a single digit. Please try again\n";
              continue; }
        $i++; }
        return $inputChar;
    }

    protected function askForInput($question, $required=null) {
        $fp = fopen('php://stdin', 'r');
        $last_line = false;
        while (!$last_line) {
            print "$question\n";
            $inputLine = fgets($fp, 1024);
            if ($required && strlen($inputLine)==0 ) {
                print "You must enter a value. Please try again.\n"; }
            else {$last_line = true;} }
        $inputLine = $this->stripNewLines($inputLine);
        return $inputLine;
    }

    protected function askForArrayOption($question, $options, $required=null) {
        $fp = fopen('php://stdin', 'r');
        $last_line = false;
        while ($last_line == false) {
            print "$question\n";
            for ( $i=0 ; $i<count($options) ; $i++) { print "($i) $options[$i] \n"; }
            $inputLine = fgets($fp, 1024);
            if ($required && strlen($inputLine)==0 ) {
                print "You must enter a value. Please try again.\n"; }
            elseif ( is_int($inputLine) && ($inputLine>=0) && ($inputLine<=count($options) ) ) {
                print "Enter one of the given options. Please try again.\n"; }
            else {$last_line = true; } }
        $inputLine = $this->stripNewLines($inputLine);
        return $options[$inputLine];
    }

    protected function stripNewLines($inputLine) {
        $inputLine = str_replace("\n", "", $inputLine);
        $inputLine = str_replace("\r", "", $inputLine);
        return $inputLine;
    }

    private function loadJConfig(){
        $defaultFolderToCheck = getcwd();
        $defaultName = $defaultFolderToCheck.'/configuration.php';
      /*
       *
        if (file_exists($defaultName)) {
            require_once($defaultName); }
        else if (file_exists(self::$joomlaConfigFile)) {
            require_once(self::$joomlaConfigFile); }
        $jConfig = (class_exists('jConfig')) ? new \jConfig() : null ;
        return $jConfig;
      */
      if (file_exists($defaultName)) { return true; }
      else if (file_exists($this->joomlaConfigFile)) { return true; }
      return false;
    }

    private function recursiveLoad($dirToRecurse) {
        $arrayOfFiles = scandir($dirToRecurse);
        foreach ($arrayOfFiles as $fileOrFolder) {
            if (is_dir($fileOrFolder)) {
                $this->recursiveLoad($fileOrFolder); }
            else if (is_file($fileOrFolder)) {
                if ($this->isPhpFile($fileOrFolder) ) { $this->loadFile($fileOrFolder); } } }
    }

    private function loadFile($fileToLoad) {
        require_once($fileToLoad);
    }

    private function isPhpFile($file) {
        $isPhpExt = (substr($file, 4, -1)==".php") ? true : false ;
        if (is_file($file) && $isPhpExt) { return true; }
        return false;
    }

    private function setBaseCmdLineParams($params) {
        if (is_array($params) && count($params)>0) {
          foreach ($params as $param) {
            if ( substr($param, 0, 13)=="--config-file"){
              $this->joomlaConfigFile = substr($param, 14, strlen($param)-1); }
            if ( substr($param, 0, 15)=="--output-format"){
              $this->outputFormat = substr($param, 16, strlen($param)-1); } } }
    }

}