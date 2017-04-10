<?php
//Move this to the logs Directory
$dir = '/home/snomofomo/public_html/indxlogs/';
if(is_dir($dir)){
  if($dh = opendir($dir)){
    while(($file = readdir($dh)) !== false){
      $tnsp = explode(".",$file);
      $nsp = explode("_",$tnsp);
      if($nsp[0] == '00'){
        $fname = $nsp[1].' : '.$nsp[3].' '.$tsp[4];
      }else{
        $fname = $nsp[0].' : '.$nsp[2].' '.$tsp[3];
      }
      echo '<a href="'$file.'" target="_blank">'.$fname.'</a><br>';
    }
    closedir($dh);
  }
}
?>
