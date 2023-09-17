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
//Leírás: A felhasználóhoz való fejécet írja ki.
//Bemenő adatok: User id
//kimenő adat: PHP kód ami kiírja az oldal fejlécét.
//----------------------------------
function munka_fejlec($id,$ev,$ho)
{
	echo "<div class='fejlec_nev'>";
	echo user_keres($id);
	echo "</div>";
	echo "<div class='fejlec_datum'>";
	echo $ev." ".honap($ho)." óra összeírás";
	echo "</div>";	
}
//----------------------------------
//Leírás: A user munkáit kiírja.
//Bemenő adatok: -
//kimenő adat: -
//----------------------------------
function munka($id,$ev,$ho)
{
	include("dbconn.php");
	try
	{
		$hoand=$ho+1;
		$sql = "SELECT * FROM `worktime` WHERE `user_id`=1 AND `start`>\"$ev-$ho-01\" AND `stop`<\"$ev-$hoand-01\"";
		echo $sql;
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
			$nap=het_napja($user["start"]);
			$datum=ev_honap_nap($user["start"]);
			print("<tr class='adatsor'><td class='id'>$nap</td> <td class='user_id'>$datum</td> <td class='work_id'>".munkanev_keres($user["work_id"])."</td> <td class='start'>".ora_perc($user["start"])."</td> <td class='stop'>".ora_perc($user["stop"])."</td> <td class='pause'>$user[pause]</td> <td class='work_time'>$user[work_time]</td><td class='ido'>$user[time]</td></tr>");
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
//Leírás: Egy adott user nevét adja vissza.
//Bemenő adatok: User id száma.
//kimenő adat: A user neve.
//----------------------------------
function user_keres($id)
{
include("dbconn.php");
	try
	{
		$sql = "SELECT * FROM user WHERE id=$id"; // ez csak egy string, még nem hajtódik végre
		$res = $conn->query($sql); // az utasítás csak most fut le
		$adat = $res->fetch();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return ($adat["vezetek_nev"]." ".$adat["kereszt_nev"]);
}
//Leírás: Egy adott worktime id sorának a ledolgozott idejét adja vissza.
//Bemenő adatok: worktime id száma.
//kimenő adat: A ledolgozott idő órában.
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


//Leírás: Egy adott worktime id sorának a ledolgozott idejét adja vissza.
//Bemenő adatok: User id száma, év, hó.
//kimenő adat: A ledolgozott idő órában.
//----------------------------------
function ledolgozott_ido_havi($id,$ev,$ho)
{
$hoplus=$ho+1;	
include("dbconn.php");
	try
	{
	$sql = "SELECT SUM(work_time) FROM `worktime` WHERE `user_id`=$id AND `start`>\"$ev-$ho-01\" AND `stop`<\"$ev-$hoplus-01\"";
		$res = $conn->query($sql); // az utasítás csak most fut le
		$adat = $res->fetch();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $adat[0];
}


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
//----------------------------------
//Leírás: Dátumot nap formátumra szűkít..
//Bemenő Teljes dátum.
//kimenő adat: Szöveg ami a rövid dátum formátumot tartalmazza..
//----------------------------------
function nap($ido)
{
	$datum=strtotime($ido);
	$rovid=date("d",$datum);
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
//Leírás: Dátumot hétnapja formátumra szűkít..
//Bemenő Teljes dátum.
//kimenő adat: Szöveg ami a hét napját tartalmazza..
//----------------------------------
function het_napja($ido)
{
	$datum=strtotime($ido);
	$rovid=date("N",$datum);
	if(!$datum)
	{
		return "";
	}
	else
	{
		switch ($rovid) {
		case 1:
			return "Hétfő";
			break;
		case 2:
			return "Kedd";
			break;
		case 3:
			return "Szerda";
			break;
		case 4:
			return "Csütörtök";
			break;
		case 5:
			return "Péntek";
			break;
		case 6:
			return "Szombat";
			break;
		case 7:
			return "Vasárnap";
			break;				
		default:
			echo "Your favorite color is neither red, blue, nor green!";
		}	
		return $rovid;
	}
}
//----------------------------------
//Leírás: Hónap nevét adja vissza a sorszám alapján
//Bemenő Hónap sorszáma.
//kimenő adat: Hónap neve.
//----------------------------------
function honap($honap)
{
	switch ($honap) {
		case 1:
			return "Január";
			break;
		case 2:
			return "Február";
			break;
		case 3:
			return "Március";
			break;
		case 4:
			return "Április";
			break;
		case 5:
			return "Május";
			break;
		case 6:
			return "Június";
			break;
		case 7:
			return "Július";
			break;
		case 8:
			return "Augusztus";
			break;
		case 9:
			return "Szeptember";
			break;
		case 10:
			return "Október";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "December";
			break;
		default:
			echo "Nem jó formátum a hónap kiíráshoz";
		}	
}
//----------------------------------
//Leírás: Hónapok felsorolása választásra
//Bemenő -
//kimenő adat: Hónap neveinek listája linkel.
//----------------------------------
function honap_lista($ev,$ho)
{
	$elozo=$ev-1;
	$kovetkezo=$ev+1;
	echo "<div>";
	echo "<table>";
	echo "<tr><th><<</th><th>Év</th><th>>></th></tr>";
	echo "<tr><td><a href='/index.php?ev=$elozo&ho=$ho'>$elozo</a></td><td>$ev</a></td><td><a href='/index.php?ev=$kovetkezo&ho=$ho'>$kovetkezo</a></td></tr>";
	echo "</table>";
	echo "</div>";
	
	echo "<div>";
	echo "<table>";
	echo "<tr><th>Hónapok</th><th>rekordok</th><th>órák</th></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=1'>Január</a></td><td>".ledolgozott_ido_havi(1,$ev,1)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=2'>Február</a></td><td>".ledolgozott_ido_havi(1,$ev,2)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=3'>Március</a></td><td>".ledolgozott_ido_havi(1,$ev,3)."</td><td></td></tr>";	
	echo "<tr><td><a href='/index.php?ev=$ev&ho=4'>Április</a></td><td>".ledolgozott_ido_havi(1,$ev,4)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=5'>Május</a></td><td>".ledolgozott_ido_havi(1,$ev,5)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=6'>Június</a></td><td>".ledolgozott_ido_havi(1,$ev,6)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=7'>Július</a></td><td>".ledolgozott_ido_havi(1,$ev,7)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=8'>Augusztus</a></td><td>".ledolgozott_ido_havi(1,$ev,8)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=9'>Szeptember</a></td><td>".ledolgozott_ido_havi(1,$ev,9)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=10'>Október</a></td><td>".ledolgozott_ido_havi(1,$ev,10)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=11'>November</a></td><td>".ledolgozott_ido_havi(1,$ev,11)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=12'>December</a></td><td>".ledolgozott_ido_havi(1,$ev,12)."</td><td></td></tr>";	
	echo "</table>";
	echo "</div>";
	
}
?>