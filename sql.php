<!DOCTYPE html>
<html>
<head>
    <title>Adatbázis adatok</title>
</head>
<body>
    <h1>Adatbázis adatai</h1>

<?php
include("fgv.php");
include("dbconn.php");
if(isset($_GET["ev"])){ $ev = $_GET["ev"]; }
if(isset($_GET["ho"])){ $ho = $_GET["ho"]; }
if(isset($_GET["munka_datum"])){ $munka_datum = $_GET["munka_datum"]; }
if(isset($_GET["munka_nev"])){ $munka_nev = $_GET["munka_nev"]; }
if(isset($_GET["munka_start"])){ $munka_start = $_GET["munka_start"]; }
if(isset($_GET["munka_stop"])){ $munka_stop = $_GET["munka_stop"]; }
if(isset($_GET["munka_etkezes"])){ $munka_etkezes = $_GET["munka_etkezes"]; }
$ertek_1=NULL;
$ertek_2=1;
$ertek_3=$munka_nev;
$ertek_4="2023-09-20 07:00:00";
$ertek_5="2023-09-20 15:30:00";
$ertek_6=$munka_etkezes;
$ertek_7=8;
$ertek_8=time();
	try
	{
		$beszur=$conn->prepare("INSERT INTO worktime (user_id, work_id, start, stop, pause, work_time) VALUES (:ertek2, :ertek3, :ertek4, :ertek5, :ertek6, :ertek7)");
		$beszur->bindParam(':ertek2', $ertek_2);
		$beszur->bindParam(':ertek3', $ertek_3);
		$beszur->bindParam(':ertek4', $ertek_4);
		$beszur->bindParam(':ertek5', $ertek_5);
		$beszur->bindParam(':ertek6', $ertek_6);
		$beszur->bindParam(':ertek7', $ertek_7);
	$beszur->execute();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
$conn = null; // lezárjuk az adatbázis-kapcsolatot
?>

</body>
</html>
