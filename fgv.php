<?php
//Többször használt függvények és program részek beillesztése.
//----------------

//Minden függvény előtt kötelező megadni a következő infókat!
//----------------------------------
//Leírás:
//Bemenő adatok:-
//kimenő adat:-
//----------------------------------


//---------incude beolvasások.------
include("dbconn.php");

//---------Függvények leírása-------
//----------------------------------
//Leírás: Az oldal nevének a beállítása.
//Bemenő adatok: -
//kimenő adat: Az oldal neve.
//----------------------------------
function nev()
{
	$adat="Work";
	return $adat;
}
//----------------------------------
//Leírás: A user munkáit kiírja.
//Bemenő adatok: -
//kimenő adat: -
//----------------------------------
function munka()
{
	include("dbconn.php");
	try
	{
		$sql = "SELECT * FROM worktime"; // ez csak egy string, még nem hajtódik végre
		$res = $conn->query($sql); // az utasítás csak most fut le
		
		// a táblázat sorai
		echo "<table>";
		echo "<tr>";
		echo "<th class='id'>Id</th>";
		echo "<th class='user_id'>user_id</th>";
		echo "<th class='work_id'>work_id</th>";	
		echo "<th class='start'>Start</th>";
		echo "<th class='stop'>Stop</th>";
		echo "<th class='pause'>Pause</th>";
		echo "<th class='work_time'>Ledolgozott iő</th>";		
		echo "<th class='ido'>idő</th>";		
		echo "</tr>";
		while ($user = $res->fetch())
		{
			$ledolgozott=ledolgozott_ido($user["id"]);
			print("<tr class='adatsor'><td class='id'>$user[id]</td> <td class='user_id'>$user[user_id]</td> <td class='work_id'>".munkanev_keres($user["work_id"])."</td> <td class='start'>".ora_perc($user["start"])."</td> <td class='stop'>".ora_perc($user["stop"])."</td> <td class='pause'>$user[pause]</td> <td class='work_time'>".$ledolgozott."</td><td class='ido'>$user[time]</td></tr>");
		}
		echo "</table><br>";
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
//Leírás: Egy adott munka nevét adja vissza.
//Bemenő adatok: Munka work_id száma.
//kimenő adat: A munka neve.
//----------------------------------
function munkanev_keres($id)
{
include("dbconn.php");
	try
	{
		$sql = "SELECT * FROM work WHERE work_id=$id"; // ez csak egy string, még nem hajtódik végre
		$res = $conn->query($sql); // az utasítás csak most fut le
		$adat = $res->fetch();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $adat["work_name"];
}
//Leírás: Egy adott munka nevét adja vissza.
//Bemenő adatok: Munka work_id száma.
//kimenő adat: A munka neve.
//----------------------------------
function ledolgozott_ido($id)
{
include("dbconn.php");
	try
	{
		$sql = "SELECT ROUND(((`stop`-`start`)/10000 -(`pause`/60)),1) FROM `worktime` WHERE `id`=$id";// ez csak egy string, még nem hajtódik végre
		$res = $conn->query($sql); // az utasítás csak most fut le
		$adat = $res->fetch();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $adat[0];
}
//Leírás: Az oldal nevének a beállítása.
//Bemenő adatok: -
//kimenő adat: Az oldal neve.
//----------------------------------
function teszt()
{
	$adat="Work";
	print("Ez egy próba szöveg".nev()."<br>".user_kiir());
}
//----------------------------------
//Leírás: Dátumot év.ho.nap formátumra szűkít..
//Bemenő Teljes dátum.
//kimenő adat: Szöveg ami a rövid dátum formátumot tartalmazza..
//----------------------------------
function ev_honap_nap($ido)
{
	$datum=strtotime($ido);
	$rovid=date("Y.m.d",$datum);
	if(!$datum)
	{
		return "";
	}
	else
	{
		return $rovid;
	}
}
//----------------------------------
//Leírás: Dátumot óra.perc. formátumra szűkít..
//Bemenő Teljes dátum.
//kimenő adat: Szöveg ami a rövid dátum formátumot tartalmazza..
// https://www.w3schools.com/php/func_date_date_format.asp
//----------------------------------
function ora_perc($ido)
{
	$datum=strtotime($ido);
	$rovid=date("G:i",$datum);
	if(!$datum)
	{
		return "";
	}
	else
	{
		return $rovid;
	}
}
?>