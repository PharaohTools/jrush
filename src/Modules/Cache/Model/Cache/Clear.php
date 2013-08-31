<?php

Namespace Model\Cache;

class Clear extends Base {

    public function __construct($params) {
        parent::__construct($params);
        $this->attemptBootstrap($params, "Cache Clear");
    }

    public function askWhetherToClearSiteCache() {
        return $this->clearSiteCache();
    }

    public function askWhetherToClearAdminCache() {
        return $this->clearAdminCache();
    }

    private function clearSiteCache() {
        $content = array();
        $content["site_cache_clear"] = "Site Cache Clearing";
        $allCachedFiles = array();
        $allFilesInCacheFolder = scandir(JPATH_BASE.DS."cache");
        foreach ($allFilesInCacheFolder as $oneFileInCacheFolder) {
            if (!in_array($oneFileInCacheFolder,array(".", "..", ".gitignore", "index.html"))) {
              $allCachedFiles[] = $oneFileInCacheFolder ;
              shell_exec("rm -rf ".JPATH_BASE.DS."cache".DS.$oneFileInCacheFolder); } }
        $content["site_cache_clear_result"] = $allCachedFiles ;
        return $content;
    }

    private function clearAdminCache() {
      $content = array();
      $content["admin_cache_clear"] = "Admin Cache Clearing";
      $allCachedFiles = array();
      $allFilesInCacheFolder = scandir(JPATH_BASE.DS."administrator".DS."cache");
      foreach ($allFilesInCacheFolder as $oneFileInCacheFolder) {
        if (!in_array($oneFileInCacheFolder,array(".", "..", ".gitignore", "index.html"))) {
          $allCachedFiles[] = $oneFileInCacheFolder ;
          shell_exec("rm -rf ".JPATH_BASE.DS."administrator".DS."cache".DS.$oneFileInCacheFolder); } }
      $content["admin_cache_clear_result"] = $allCachedFiles ;
      return $content;
    }

}