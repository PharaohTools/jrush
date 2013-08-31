<?php

Namespace Model\JUser;

use Model\CoreBase;

class Base extends CoreBase {

    public function __construct($params) {
        parent::__construct($params);
        $adminCompPath = dirname(parent::$joomlaConfigFile)."/administrator/components/com_user";
        $compPath = dirname(parent::$joomlaConfigFile)."/components/com_user";
        define("JPATH_COMPONENT_ADMINISTRATOR", $adminCompPath ) ;
        define("JPATH_COMPONENT", $compPath ) ;
    }

    protected function findUserId(){
        if ($this->userId) {
            return; }
        else if ($this->userEmail) {
            $this->userId = $this->getUserIdFromUserEmail($this->userEmail);
            return; }
        else if ($this->userName) {
            $this->userId = $this->getUserIdFromUserName($this->userName);
            return; }
        $question = 'Enter a JUser ID. To enter email/username use --user-email or --username parameters';
        $this->userId = self::askForInput($question, true);
    }

    protected function getUserIdFromUserEmail($email) {
        $db = \JFactory::getDBO();
        $query = 'SELECT id FROM #__users WHERE email="'.$email.'" LIMIT 1' ;
        $db->setQuery($query);
        $db->query();
        $result = $db->loadResult();
        return $result;
    }

    protected  function getUserIdFromUserName($userName) {
        $db = \JFactory::getDBO();
        $query = 'SELECT id FROM #__users WHERE username="'.$userName.'" LIMIT 1' ;
        $db->setQuery($query);
        $db->query();
        $result = $db->loadResult();
        return $result;
    }

}
