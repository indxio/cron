<?php
//Move this to the logs Directory
$dir = '/home/snomofomo/public_html/indxlogs/';
if(is_dir($dir)){
  if($dh = opendir($dir)){
    while(($file = readdir($dh)) !== false){
      $nsp = explode("_",$file);
      if($nsp[0] == '00'){
        $tsp = explode('.',$nsp[4]);
        $fname = $nsp[1].' : '.$nsp[3].' '.$tsp[0];
      }else{
        $tsp = explode('.',$nsp[3]);
        $fname = $nsp[0].' : '.$nsp[2].' '.$tsp[0];
      }
      echo '<a href="'$file.'" target="_blank">'.$fname.'</a><br>';
    }
    closedir($dh);
  }
}
?>
