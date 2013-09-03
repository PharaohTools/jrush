<?php

$jsonArray = array (
  "id" => $pageVars["jJArticleInfoResult"]->id,
  "asset_id" => $pageVars["jJArticleInfoResult"]->asset_id,
  "alias" => $pageVars["jJArticleInfoResult"]->alias,
  "title" => $pageVars["jJArticleInfoResult"]->title,
  "created_by" => $pageVars["jJArticleInfoResult"]->created_by,
  "created_by_alias" => $pageVars["jJArticleInfoResult"]->created_by_alias,
  "state" => $pageVars["jJArticleInfoResult"]->state,
);

echo json_encode($jsonArray)."\n";

?>