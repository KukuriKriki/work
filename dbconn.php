<?
$adatbazisnev="c1munka";
$kapcsolat = mysql_connect("netnote.hu","c1netnoteadmin","Szabok10");
mysql_query("SET NAMES utf8", $kapcsolat) or die ("Hiba a lek�rdez�s k�zben! A hiba oka:"."".mysql_error().""); 
mysql_select_db("$adatbazisnev", $kapcsolat) or die ("Hiba a lek�rdez�s k�zben! A hiba oka:"."".mysql_error().""); 
?>
