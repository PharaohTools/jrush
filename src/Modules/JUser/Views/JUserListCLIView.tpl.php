JUser Listing:
-------------------------

<?php

foreach ($pageVars["result"]["users"] as $row) {
    echo $row->id.' | '.$row->username.' | '.$row->email."\n";
}
?>

------------------------------
JUser Listing Finished