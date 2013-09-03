<?php

$jsonArray = array (
  "extension_id" => $pageVars["jExtensionInfoResult"]->extension_id,
  "name" => $pageVars["jExtensionInfoResult"]->name,
  "element" => $pageVars["jExtensionInfoResult"]->element,
  "enabled" => $pageVars["jExtensionInfoResult"]->enabled
);

echo json_encode($jsonArray)."\n";

?>