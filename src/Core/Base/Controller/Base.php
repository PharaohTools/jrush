<?php

Namespace Controller ;

class Base {

  public $content;
  protected $registeredModels = array();
  protected $dependencies = array();

  public function __construct() {
    $this->content = array();
    $this->loadDependencies();
    $this->checkDependencies(); }

  public function checkForHelp($pageVars) {
    $this->content["route"] = $pageVars["route"];
    $this->content["messages"] = $pageVars["messages"];
    $action = $pageVars["route"]["action"];
    if ($action=="help") {
      $helpModel = new \Model\Help();
      $this->content["helpData"] = $helpModel->getHelpData($pageVars["route"]["control"]);
      return array ("type"=>"view", "view"=>"help", "pageVars"=>$this->content); }
    return false;
  }

  protected function loadDependencies() {
    $moduleName = substr(get_class($this), 11) ;
    $this->dependencies = \Core\AutoLoader::getDependencies($moduleName);
  }

  protected function checkDependencies() {
    foreach ($this->dependencies as $moduleName) {
      $fullClassName = '\Info\\'.$moduleName.'Info';
      if ( !class_exists($fullClassName) ) {
        $thisModuleName = substr(get_class($this), 11) ;
        echo "Module ".$thisModuleName." Expects Module ".$moduleName." as a dependency. \n";
        die() ; } }
  }

  protected function checkForRegisteredModels() {
    foreach ($this->registeredModels as $modelClassNameOrArray) {
      if ( is_array($modelClassNameOrArray) ) {
        $currentKeys = array_keys($modelClassNameOrArray) ;
        $currentKey = $currentKeys[0] ;
        $fullClassName = '\Model\\'.$currentKey;
        if ( !class_exists($fullClassName) ) {
          echo "Expected Model not found: ".$fullClassName."\n";
          return ; } }
      else {
        $fullClassName = '\Model\\'.$modelClassNameOrArray;
        if ( !class_exists($fullClassName) ) {
          echo "Expected Model not found: ".$fullClassName."\n";
          return ; } } }
    echo "All expected Models found"."\n\n";
  }

  protected function executeMyRegisteredModels() {
    foreach ($this->registeredModels as $modelClassNameOrArray) {
      if ( is_array($modelClassNameOrArray) ) {
        $currentKeys = array_keys($modelClassNameOrArray) ;
        $currentKey = $currentKeys[0] ;
        $fullClassName = '\Model\\'.$currentKey;
        $currentModel = new $fullClassName();
        $miniRay = array();
        $miniRay["appName"] = $currentModel->programNameInstaller;
        $miniRay["installResult"] = $currentModel->askInstall();
        $this->content["results"][] = $miniRay ;}
      else {
        $fullClassName = '\Model\\'.$modelClassNameOrArray;
        $currentModel = new $fullClassName();
        $miniRay = array();
        $miniRay["appName"] = $currentModel->programNameInstaller;
        $miniRay["installResult"] = $currentModel->askInstall();
        $this->content["results"][] = $miniRay ; } }
  }

  protected function executeMyRegisteredModelsAutopilot($autoPilot) {
    foreach ($autoPilot->steps as $modelArray) {
      $currentKeys = array_keys($modelArray) ;
      $currentKey = $currentKeys[0] ;
      $fullClassName = '\Model\\'.$currentKey;
      $currentModel = new $fullClassName();
      $miniRay = array();
      $miniRay["appName"] = $currentModel->programNameInstaller;
      $miniRay["installResult"] = $currentModel->runAutoPilotInstall($modelArray);
      $this->content["results"][] = $miniRay ; }
  }

}