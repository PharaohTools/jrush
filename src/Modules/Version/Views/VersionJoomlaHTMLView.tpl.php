<html>

  <head>
    <title>
      GC JRush
    </title>
  </head>

  <body>

  <h3>
    Joomla Version Info:  <br />
    --------------------------------------------
  </h3>

  <p>Version: <?php

    // var_dump($pageVars["jVersionResult"]) ;

    $lines = $pageVars["jVersionResult"] ;
    foreach ($lines as $line_key => $line_value) {
      if (is_string($line_value)) {
        echo "<p>$line_key: $line_value</p>"; }
      else if (is_object($line_value) && $line_value instanceof \ArrayObject)  {
        foreach ($line_value as $line_key_2 => $line_value_2) {
          echo "<p>$line_key_2: $line_value_2</p>"; } }
    }

    ?>
  </p>

  <h3>
    ------------------------------<br />
    Joomla Version Info Finished
  </h3>

  </body>

</html>