<div>
<center><br>
<?php 
/**
* Shoutcast Molok - A Joomla 1.0.8 shoutcast module
* @version 1.0
* @package mod_shoutcastextended.zip
* @copyright (C) 2005 by Molok - All rights reserved!
*/

# Don't allow direct acces to the file
 defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
  
$radioname = $params->get( 'radioname', 'FungKur.FM' );
$host = $params->get( 'host', 'fungkurfm.mine.nu' );
$port = $params->get( 'port', '8000' );
$listener = $params->get( 'listener', 'Listener' );
$from = $params->get( 'from', 'from' );
$peakmenu = $params->get( 'peakmenu', 'Peak' );
$serverstatus = $params->get( 'serverstatus', 'Server Status' );
$currentsong = $params->get( 'currentsong', 'Current Song' );

$fp=@fsockopen($host,$port,&$errno,&$errstr,10); 
if (!$fp) { 
echo "Connection Putus"; 
} else { 

fputs($fp,"GET /7 HTTP/1.1\nUser-Agent:Mozilla\n\n"); 

for($i=0; $i<1; $i++) { 
if(feof($fp)) break; 
$fp_data=fread($fp,31337); 
usleep(500000); 
} 

$fp_data=ereg_replace("^.*<body>","",$fp_data); 
$fp_data=ereg_replace("</body>.*","",$fp_data); 

list($current,$status,$peak,$max,$reported,$bit,$song) = explode(",", $fp_data, 7); 

if ($status == "1") { 

echo "<a href=http://$host:$port/listen.pls><img src=modules/mod_shoutcastextended/winamp.gif border=0 alt=listen with Winamp></a>&nbsp;<a href=modules/mod_shoutcastextended/listen.asx><img src=modules/mod_shoutcastextended/wmplayer.gif border=0 alt=listen with Window Media Player></a>&nbsp;";
echo "<a href=modules/mod_shoutcastextended/listen.ram><img src=modules/mod_shoutcastextended/realplayer.gif border=0 alt=listen with RealPlayer></a>&nbsp<a href=modules/mod_shoutcastextended/listen.m3u><img src=modules/mod_shoutcastextended/itunes.gif border=0 alt=listen with iTunes></a><br>";
echo "<font face='verdana' size='2' color='#800000'><b> $radioname </b></font><br><br> "; 
echo "<font face=verdana size=1> <b>$listener</b>: $current $from $max ($reported Unique)<br> <b>$peakmenu</b>: $peak<br> <b>$serverstatus</b>: <font face='verdana' size='2' color='#009900'><b> Online</b></font><br> <b>Bitrate</b>: $bit Kbps<br> <b>$currentsong</b>: $song </font><br>"; 

} else { 
echo "<font face='verdana' size='2' color='#000000'><b> $radioname </b></font><br><font face='verdana' size='2' color='#FF0000'><b> Offline </b></font>"; 
} } 
?>  </center> <br>
</div>