<?php

Namespace Model\JUser;

class Delete extends Base {

    protected $userId;
    protected $userEmail;
    protected $userName ;

    public function __construct($params) {
      parent::__construct($params);
      $this->setCmdLineParams($params);
      $this->attemptBootstrap($params, "JUser Delete");
    }

    public function askWhetherToDeleteUser() {
        $this->findUserId();
        return $this->deleteUser();
    }

    private function deleteUser() {
        $userData = $this->doUserDeletion($this->userId);
        return $userData;
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
                $this->userName = substr($param, 12, strlen($param)); } }
        return true;
    }

    private function doUserDeletion($userId) {
        $user = \JFactory::getUser($userId);
        $userCopy = $user;
        $user->delete();
        return $userCopy;
    }

    private function deleteUserBypassingJFramework($userId) {
      $db = \JFactory::getDBO();
      $query = 'DELETE FROM #__users WHERE id="'.$userId.'" LIMIT 1';
      $db->setQuery($query);
      $db->query();
    }

}