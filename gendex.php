<?php
$debug = 0;  // 0 - production  1 -  debug
$time_start = microtime(true);
$data = array();
$pairs = array();
require 'creds.php';
$con = new mysqli($host,$user,$pass,$db);
date_default_timezone_set("UTC");
function timeStamp(){ return date('Y-m-d H:i'); };
$srcQuery = 'SELECT DISTINCT `exchange` FROM `current`;';
$res = $con->query($srcQuery);
if ($res->num_rows > 0) { while($row = $res->fetch_assoc()) { $data[$row['exchange']] = array(); } }
$pairQuery = 'SELECT DISTINCT `pair` FROM `current` WHERE `exchange` = ';
foreach ($data as $ex => $exdata) {
  if($ex != 'indx'){
    $query = $pairQuery.'"'.$ex.'"';
    $res = $con->query($query);
    if ($res->num_rows > 0) { while($row = $res->fetch_assoc()) {
      array_push($data[$ex],$row['pair']);
      if($pairs[$row['pair']]){$pairs[$row['pair']]++;}else{ $pairs[$row['pair']] = 1; }
    } }
  }
}
$indxData = array();
foreach ($pairs as $pair => $count){ if($count > 2){ $indxData[$pair] = array(); } }
foreach($indxData as $pair => $pdata){
  echo 'Generating: '.$pair.'<br>';
  foreach ($data as $ex => $exdata) {
    if(in_array($pair,$exdata)){
      $qtemp = 'SELECT `value`,`volume` FROM `current` WHERE `exchange` = "'.$ex.'" AND `pair` = "'.$pair.'" ORDER BY `timestamp` DESC LIMIT 1';
      echo 'Running: '.$qtemp.'<br>';
      $res0 = $con->query($qtemp);
      if($res0->num_rows > 0){
        while($row = $res0->fetch_assoc()){
          echo $row['value'].'<br>';
          echo $row['volume'].'<hr>';
          if($indxData[$pair]){
            $indxData[$pair]['val'] = $indxData[$pair]['val'] + ($row['value'] * $row['volume']);
            $indxData[$pair]['vol'] = $indxData[$pair]['vol'] + $row['volume'];
          }else{
            $indxData[$pair]['val'] = $row['value'] * $row['volume'];
            $indxData[$pair]['vol'] = $row['volume'];
          }
        }
      }
    }
  }
}
echo '<hr>Generating INDX<hr>';
$indxquery = 'INSERT INTO `current` VALUES ';
$c = 0;
$ic = count($indxData);
foreach ($indxData as $pair => $pd) {
  $indxquery .= '(null,"indx","'.$pair.'",'.($pd['val']/$pd['vol']).','.$pd['vol'].', "'.timeStamp().'")';
  if($c < $ic-1){ $indxquery .=','; $c++;}
}
echo $indxquery.'<hr>';
if($con->query($indxquery) === true){ echo 'INDX INSERT Complete'; }else{ echo 'INDX INSERT Error<br>'.$con->error; }
$con->close();
