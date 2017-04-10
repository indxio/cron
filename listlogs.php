<?php
//Move this to the logs Directory
$dir = '/home/snomofomo/public_html/indxlogs/';
if(is_dir($dir)){
  if($dh = opendir($dir)){
    while(($file = readdir($dh)) !== false){
      echo $file.'<br>';
    }
    closedir($dh);
  }
}
?>
