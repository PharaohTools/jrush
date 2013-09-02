<?php

$jsonArray = array (
  "id" => $pageVars["jUserInfoResult"]->id,
  "name" => $pageVars["jUserInfoResult"]->name,
  "username" => $pageVars["jUserInfoResult"]->username,
  "email" => $pageVars["jUserInfoResult"]->email
);

echo json_encode($jsonArray)."\n";

?>