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
            $this->settingsFileName = 'src'.DS.'configuration.php'; }
    }

    public function getProperty($property) {
        return $this->$property;
    }

    private function setReplacements(){
        $this->configOptions = array(
            'log_path' => $this->getLogPath(),
            'tmp_path' => $this->getTmpPath(),
            'MetaAuthor' => '1',
            'MetaDesc' => '',
            'MetaKeys' => '',
            'MetaRights' => '',
            'MetaTitle' => '1',
            'MetaVersion' => '0',
            'access' => '1',
            'cache_handler' => 'file',
            'cachetime' => '15',
            'caching' => '0',
            'captcha' => '0',
            'cookie_domain' => '',
            'cookie_path' => '',
            'dbprefix' => 'jos_',
            'dbtype' => 'mysqli',
            'debug' => '0',
            'debug_lang' => '0',
            'display_offline_message' => '1',
            'editor' => 'jce',
            'error_reporting' => 'default',
            'feed_email' => 'author',
            'feed_limit' => '10',
            'force_ssl' => '0',
            'fromname' => '',
            'ftp_enable' => '0',
            'ftp_host' => '',
            'ftp_pass' => '',
            'ftp_port' => '21',
            'ftp_root' => '',
            'ftp_user' => '',
            'gzip' => '1',
            'helpurl' => 'http://help.joomla.org/proxy/index.php?option=com_help&keyref=Help{major}{minor}:{keyref}',
            'lifetime' => '60',
            'list_limit' => '20',
            'live_site' => '',
            'mailer' => 'mail',
            'mailfrom' => '',
            'memcache_compress' => '0',
            'memcache_persist' => '1',
            'memcache_server_host' => 'localhost',
            'memcache_server_port' => '11211',
            'offline' => '0',
            'offline_image' => '',
            'offline_message' => 'This site is down for maintenance.<br /> Please check back again soon.',
            'offset' => 'Europe/London',
            'offset_user' => 'UTC',
            'robots' => '',
            'secret' => '',
            'sef' => '1',
            'sef_rewrite' => '1',
            'sef_suffix' => '0',
            'sendmail' => '/usr/sbin/sendmail',
            'session_handler' => 'database',
            'sitename' => '',
            'sitename_pagetitles' => '1',
            'smtpauth' => '0',
            'smtphost' => 'localhost',
            'smtppass' => '',
            'smtpport' => '25',
            'smtpsecure' => 'none',
            'smtpuser' => '',
            'unicodeslugs' => '0',
            'memcached_persist' => '1',
            'memcached_compress' => '0',
            'memcached_server_host' => 'localhost',
            'memcached_server_port' => '11211',
            'proxy_enable' => '0',
            'proxy_host' => '',
            'proxy_port' => '',
            'proxy_user' => '',
            'proxy_pass' => '',
            'mailonline' => '1',
            'session_memcache_server_host' => 'localhost',
            'session_memcache_server_port' => '11211',
            'session_memcached_server_host' => 'localhost',
            'session_memcached_server_port' => '11211',
            'frontediting' => '1',
            'asset_id' => '1',
            // DB Stuff
            'user' => '',
            'db' => '',
            'host' => '',
            'password' => '',
        );
    }

    private function getLogPath(){
        return $this->getJRoot().DS.'logs';
    }

    private function getTmpPath(){
        return $this->getJRoot().DS.'tmp';
    }

    private function getJRoot(){
        $this->attemptBootstrap($this->params, "Joomla 3 Configuration Data Set") ;
        if (isset($this->joomlaConfigFile)) {
            return dirname($this->joomlaConfigFile) ; }
        return null ;
    }

}
