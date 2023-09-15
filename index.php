<?php
ob_start();
//include("fgv.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="style.css" />
		<body>
			<div id="head">
			<a href="http://84.21.7.19/sql.php" target="_blank">
				<button type="button">sql.php megnyitása</button>
			</a>

			</div>
			<div id="tartalom">
				<?php 
				$adatbazisnev="c1munka";
				echo"Tartalom 1";				
				$kapcsolat = mysql_connect("netnote.hu","c1netnoteadmin","Szabok10");
				echo"Tartalom 2";				
				mysql_query("SET NAMES utf8", $kapcsolat) or die ("Hiba a lekérdezés közben! A hiba oka:"."".mysql_error().""); 
				echo"Tartalom 3";
				mysql_select_db("$adatbazisnev", $kapcsolat) or die ("Hiba a lekérdezés közben! A hiba oka:"."".mysql_error()."");
				echo"Tartalom 4";
					$parancs = (" SELECT * FROM `user` ")or die(mysql_error());
					$eredmeny = mysql_query($parancs);
				echo"<br>Eddig jó<br>";
					if (!$parancs)
					{
						die("Érvénytelen lekérdezés: " . mysql_error());
					}
					echo"<br>Eddig jó<br>";
					echo $parancs;

					while($sor=mysql_fetch_array($eredmeny))
						{
							echo($sor["id"]);
							echo($sor["user"]);
						}
						
					
				echo"<br>Valami "; ?>
			</div>
			<div id="foot">
				<?php echo"Lábrész";?>
			</div>
			
		</body>
	</html>
<?php
ob_end_flush();
?>
