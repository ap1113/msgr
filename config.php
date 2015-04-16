<?php
session_start();

$dbc = mysql_connect('localhost','root','') or  die("Cant connect :" . mysql_error());
 
mysql_select_db("msgr",$dbc) or die("Cant connect :" . mysql_error());

$mail_webmaster = 'astha.patni@uconn.edu';

$url_root = 'http://localhost/msgr';

$url_home = 'index.php';

$design = 'default';
?>