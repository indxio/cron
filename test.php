<?php
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
date_default_timezone_set("UTC");
$timeStamp = date('Y-m-d H:i:s');
$tables = [];
$query0 = 'show tables';
$res0 = $con->query($query0);
if ($res0->num_rows > 0) {
  while ($row = $res0->fetch_assoc()) {
    if ($row["Tables_in_indxio_sources"] != 'indxio') {
      $tables[] = $row["Tables_in_indxio_sources"];
    }
  }
}
foreach ($tables as $key => $src) {
  echo $src.'<hr>';
}
 ?>
