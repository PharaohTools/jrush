<?php

Namespace Model;

class CoreBase {

    protected $joomlaConfigFile ;
    public $outputFormat ;

    public function __construct($params=null) {
        $_SERVER['HTTP_HOST'] = "" ;
        $this->setBaseCmdLineParams($params);
    }

    protected function attemptBootstrap($params, $caller){
        $this->bootStrapJoomla($params);
        if (!defined( '_JEXEC' )) {
            echo "$caller requires JRush to bootstrap.\n" ;
            return false ; }
        return true ;
    }

    protected function bootStrapJoomla($params) {
        $this->loadJConfig();
        if ($this->joomlaConfigFile==null) {
            echo "No params for Joomla config found when bootstrapping. Is --config-file param correct?\n"; }
        else {
          $jConfig = $this->loadJConfig();
          if ($jConfig==false) { echo "Can't create jconfig. Is path to configuration.php correct?\n" ;  }
          $jRoot = dirname($this->joomlaConfigFile) ;
          if (!defined('_JEXEC')) { define( '_JEXEC', 1 ); }
          if (!defined('JPATH_BASE')) { define('JPATH_BASE', $jRoot ); }
          $joomla30LoaderExists = file_exists(JPATH_BASE.DIRECTORY_SEPARATOR.'libraries'.
              DIRECTORY_SEPARATOR.'import.php');
          if (!$joomla30LoaderExists) { require_once ('Loader.php'); }
          if ($joomla30LoaderExists) { require_once (JPATH_BASE .'/libraries/import.php'); }
          require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'defines.php' );
          require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'framework.php' );
          if(!defined('DS')) { define('DS',DIRECTORY_SEPARATOR); }
          $mainframe = \JFactory::getApplication('site');
          $mainframe->initialise(); }
    }

    private function loadJConfig(){
      $defaultFolderToCheck = getcwd();
        $defaultName1 = $defaultFolderToCheck.DIRECTORY_SEPARATOR.'configuration.php';
        $defaultName2 = $defaultFolderToCheck.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'configuration.php';
      if (file_exists($this->joomlaConfigFile)) {
          return true; }
      else if (file_exists($defaultName1)) {
          $this->joomlaConfigFile = $defaultName1 ;
          return true; }
      else if (file_exists($defaultName2)) {
          $this->joomlaConfigFile = $defaultName2 ;
          return true; }
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


}