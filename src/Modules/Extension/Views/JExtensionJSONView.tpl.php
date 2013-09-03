<?php

$jsonArray = array (
  "id" => $pageVars["jExtensionInfoResult"]->id,
  "name" => $pageVars["jExtensionInfoResult"]->name,
  "componentname" => $pageVars["jExtensionInfoResult"]->componentname,
  "email" => $pageVars["jExtensionInfoResult"]->email
);

echo json_encode($jsonArray)."\n";

?>