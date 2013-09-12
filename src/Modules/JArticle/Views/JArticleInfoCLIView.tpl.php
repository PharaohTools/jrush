JArticle Information:
-------------------------
<?php
$disp = "";
if (is_array($pageVars["messages"]) && count($pageVars["messages"]) > 0) { $disp .= 'Messages: '; }
foreach ($pageVars["messages"] as $message) { $disp .= $message."\n"; }
echo $disp ;
?>

Article ID: <?php echo $pageVars["jJArticleInfoResult"]->id ; ?>

Asset ID: <?php echo $pageVars["jJArticleInfoResult"]->asset_id ; ?>

Alias: <?php echo $pageVars["jJArticleInfoResult"]->alias ; ?>

Title: <?php echo $pageVars["jJArticleInfoResult"]->title ; ?>

Created By: <?php echo $pageVars["jJArticleInfoResult"]->created_by ; ?>

Created By Alias: <?php echo $pageVars["jJArticleInfoResult"]->created_by_alias ; ?>

State: <?php echo $pageVars["jJArticleInfoResult"]->state ; ?>

------------------------------
JArticle Manage Finished