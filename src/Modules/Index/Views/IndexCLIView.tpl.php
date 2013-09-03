JRush by Golden Contact Computing
-------------------

About:
-----------------
This is the Joomla Command Line shell tool. This tool is for controlling the functions of a Joomla website through the
command line, so that actions can be performed on the website using scripts. Its very useful in automated deployment
or continuous delivery systems among others.

By using the command line to control the website, complex scripts for deployment and management of sites can be
generated. This can also be used for quickly creating API's into the website's functionality.

-------------------------------------------------------------

Available Commands:
---------------------------------------

<?php
foreach ($pageVars["modulesInfo"] as $moduleInfo) {
  if ($moduleInfo["hidden"] != true) {
    echo $moduleInfo["command"].' - '.$moduleInfo["name"]."\n";
  }
}

?>