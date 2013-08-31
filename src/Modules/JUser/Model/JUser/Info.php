<?php

Namespace Model\JUser;

class Info extends Base {

    protected $userId;
    protected $userEmail;
    protected $userName ;

    public function __construct($params) {
        parent::__construct($params);
        $this->setCmdLineParams($params);
        $this->attemptBootstrap($params, "JUser Info");
    }

    public function askWhetherToGetUserInfo() {
        $this->findUserId();
        return $this->getUserInfo();
    }

    private function getUserInfo() {
        $user = \JFactory::getUser($this->userId);
        return $user;
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

}