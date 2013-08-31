JUser Password:
-------------------------

User ID: <?php echo $pageVars["jUserInfoResult"]->id ; ?>

Name: <?php echo $pageVars["jUserInfoResult"]->name ; ?>

User Name: <?php echo $pageVars["jUserInfoResult"]->username ; ?>

Email: <?php echo $pageVars["jUserInfoResult"]->email ; ?>

User Password: <?php

if ($pageVars["jUserInfoResult"]->password_clear != "") {
  echo $pageVars["jUserInfoResult"]->password_clear ; }
else {
  echo "NOT SET" ; }
?>


------------------------------
JUser Password Finished