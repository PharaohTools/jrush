JUser Listing:
-------------------------

<?php

foreach ($pageVars["result"]["users"] as $row) {
    echo $row->id.'|'.$row->username.'|'.$row->email;
}
?>

------------------------------
JUser Listing Finished