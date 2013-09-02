<?php

if (isset($pageVars["SiteCacheClearResult"])) {
  echo json_encode($pageVars["SiteCacheClearResult"])."\n" ; }

if (isset($pageVars["AdminCacheClearResult"])) {
  echo json_encode($pageVars["AdminCacheClearResult"])."\n" ; }

?>