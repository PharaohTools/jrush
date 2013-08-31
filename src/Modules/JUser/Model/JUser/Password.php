<?php

Namespace Model\JUser;

class Password extends Base {

    protected $userId;
    protected $userEmail;
    protected $userName ;
    protected $userPassword ;

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "JUser Password");
    }

    public function askWhetherToUpdateUserPassword() {
      $this->findUserId();
      $this->findPassword();
      return $this->updateUserPass();
    }

    private function updateUserPass() {
        $userData = $this->doUserPasswordUpdate($this->userId);
        return $userData;
    }

    protected function findPassword(){
        if ($this->userPassword) {
          return; }
        $question = 'Enter a new Password. To enter as parameter use --password ';
        $this->userId = self::askForInput($question, true);
    }

    private function setCmdLineParams($params) {
        foreach ($params as $param) {
            if ( substr($param, 0, 9)=="--user-id"){
                $this->userId = substr($param, 11, strlen($param)); }
            if ( substr($param, 0, 12)=="--user-email"){
                $this->userEmail = substr($param, 13, strlen($param)); }
            if ( substr($param, 0, 10)=="--username"){
                $this->userName = substr($param, 11, strlen($param)); }
            if ( substr($param, 0, 11)=="--user-name"){
                $this->userName = substr($param, 12, strlen($param)); }
            if ( substr($param, 0, 10)=="--password"){
                $this->userPassword = substr($param, 11, strlen($param)); } }
        return true;
    }

  private function doUserPasswordUpdate($userId) {
    $user = \JFactory::getUser($userId);
    $newUserArray = array(
      "password"=>$this->userPassword,
      "password2"=>$this->userPassword
    ) ;
    $user->bind($newUserArray) ;
    $this->savePasswordBypassingJFramework($userId, $user->password) ;
    $user = \JFactory::getUser($userId);
    $user->password_clear = $this->userPassword;
    return $user;
  }

  private function savePasswordBypassingJFramework($userId, $crypt) {
    $db = \JFactory::getDBO();
    $query = 'UPDATE #__users SET password="'.$crypt.'" WHERE id="'.$userId.'"';
    $db->setQuery($query);
    $db->query();
  }

}