<?php

Namespace Model\JUser;

class Listing extends Base {

    protected $userId;
    protected $userEmail;
    protected $userName ;

    public function __construct($params) {
        parent::__construct($params);
        $this->setCmdLineParams($params);
        $this->attemptBootstrap($params, "JUser Listing");
    }

    public function askWhetherToGetUserList() {
//        $this->findUserId();
        $ray = array() ;
        return $ray["users"] = $this->getUserListing();
    }

    private function getUserListing() {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__users" ;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return $rows;
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