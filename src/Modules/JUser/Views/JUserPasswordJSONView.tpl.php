<?php

if ($pageVars["jUserInfoResult"]->password_clear != "") {
  $userPass = $pageVars["jUserInfoResult"]->password_clear ; }
else {
  $userPass = "NOT SET" ; }

$jsonArray = array (
  "id" => $pageVars["jUserInfoResult"]->id,
  "name" => $pageVars["jUserInfoResult"]->name,
  "username" => $pageVars["jUserInfoResult"]->username,
  "email" => $pageVars["jUserInfoResult"]->email,
  "password" => $userPass
);

echo json_encode($jsonArray)."\n";

?>