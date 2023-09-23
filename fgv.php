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
		$sql = "SELECT * FROM `worktime` WHERE `user_id`=$id AND `start`>\"$ev-$ho-01\" AND `stop`<\"$ev-$hoand-01\"ORDER BY `start`";
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
			if(felvett_munka_ellenorzes($id,$user["work_id"]))
			{
			$delete_link="munka_torol.php?worktime_id=$user[id]";
			print("<tr class='adatsor'><td class='id'>$nap</td> <td class='user_id'>$datum</td> <td class='work_id'>".munkanev_keres($user["work_id"])."</td> <td class='start'>".ora_perc($user["start"])."</td> <td class='stop'>".ora_perc($user["stop"])."</td> <td class='pause'>$user[pause]</td> <td class='work_time'>$user[work_time]</td><td class='ido'>$user[time]</td><td><div class'record_delet'><a href=$delete_link><img src='./image/1x15.png'></a></div></td></tr>");
			}
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
function honap_lista($user,$ev,$ho)
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
	echo "<tr><td><a href='/index.php?ev=$ev&ho=1'>Január</a></td><td>".ledolgozott_ido_havi($user,$ev,1)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=2'>Február</a></td><td>".ledolgozott_ido_havi($user,$ev,2)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=3'>Március</a></td><td>".ledolgozott_ido_havi($user,$ev,3)."</td><td></td></tr>";	
	echo "<tr><td><a href='/index.php?ev=$ev&ho=4'>Április</a></td><td>".ledolgozott_ido_havi($user,$ev,4)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=5'>Május</a></td><td>".ledolgozott_ido_havi($user,$ev,5)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=6'>Június</a></td><td>".ledolgozott_ido_havi($user,$ev,6)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=7'>Július</a></td><td>".ledolgozott_ido_havi($user,$ev,7)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=8'>Augusztus</a></td><td>".ledolgozott_ido_havi($user,$ev,8)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=9'>Szeptember</a></td><td>".ledolgozott_ido_havi($user,$ev,9)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=10'>Október</a></td><td>".ledolgozott_ido_havi($user,$ev,10)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=11'>November</a></td><td>".ledolgozott_ido_havi($user,$ev,11)."</td><td></td></tr>";
	echo "<tr><td><a href='/index.php?ev=$ev&ho=12'>December</a></td><td>".ledolgozott_ido_havi($user,$ev,12)."</td><td></td></tr>";	
	echo "</table>";
	echo "</div>";
	
}
//Leírás: Új rekord felvétele a work táblába
//Bemenő adatok: user_id,work_id,start,stop,pause,work_time.
//kimenő adat: -
//----------------------------------
function munka_uj($user)
{
	include("dbconn.php");
	$datum=date("Y-m-d");
	echo "<div>";
	echo '<form action="index.php" method="post">';
	echo '<table>';
		echo "<tr>";
		echo "<th class='id'>Id</th>";
		echo "<th class='user_id'>Dátum</th>";
		echo "<th class='work_id'>Munka neve</th>";	
		echo "<th class='start'>Kezdés</th>";
		echo "<th class='stop'>Befejezés</th>";
		echo "<th class='pause'>Étkezési idő</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='id'>Id</td>";
		echo "<td class=\"user_id\"><input type=\"text\" name=\"munka_datum\" value=$datum /></td>";
		echo "<td class=\"work_id\"><select name=\"munka_nev\" >"; 
		
		$sql = "SELECT * FROM `work` WHERE 1";
		$sql = "SELECT id, user_id, work.work_id, work_name FROM felvett_munka LEFT JOIN work ON felvett_munka.work_id=work.work_id WHERE user_id=$user";
		$res = $conn->query($sql); // az utasítás csak most fut le
		try
		{	
			while ($adat = $res->fetch())
			{
				$adat1=$adat["work_id"];
				$adat2=$adat["work_name"];
				echo "<option value=\"$adat1\">$adat2</option>";
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		echo "</select></td>";	
		echo "<td class=\"start\"><select name=\"munka_start\" >";
		echo "<option value=\"6:00\">6:00</option>";		
		echo "<option value=\"6:30\">6:30</option>";		
		echo "<option value=\"7:00\">7:00</option>";
		echo "<option value=\"7:30\">7:30</option>";
		echo "<option value=\"8:00\">8:00</option>";
		echo "<option value=\"8:30\">8:30</option>";		
		echo "<option value=\"9:00\">9:00</option>";
		echo "<option value=\"9:30\">9:30</option>";
		echo "<option value=\"10:00\">10:00</option>";
		echo "<option value=\"10:30\">10:30</option>";
		echo "<option value=\"11:00\">11:00</option>";
		echo "<option value=\"11:30\">11:30</option>";
		echo "<option value=\"12:00\">12:00</option>";
		echo "<option value=\"12:30\">12:30</option>";
		echo "<option value=\"13:00\">13:00</option>";
		echo "<option value=\"13:30\">13:30</option>";
		echo "<option value=\"14:00\">14:00</option>";
		echo "<option value=\"14:30\">14:30</option>";		
		echo "<option value=\"15:00\">15:00</option>";
		echo "<option value=\"15:30\">15:30</option>";
		echo "<option value=\"16:00\">16:00</option>";
		echo "<option value=\"16:30\">16:30</option>";
		echo "<option value=\"17:00\">17:00</option>";
		echo "<option value=\"17:30\">17:30</option>";
		echo "<option value=\"18:00\">18:00</option>";
		echo "<option value=\"18:30\">18:30</option>";
		echo "<option value=\"19:00\">19:00</option>";
		echo "<option value=\"19:30\">19:30</option>";
		echo "<option value=\"20:00\">20:00</option>";
		echo "<option value=\"20:30\">20:30</option>";
		echo "<option value=\"21:00\">21:00</option>";		
		echo "</select></td>";
		echo "</select></td>";	
		echo "<td class=\"stop\"><select name=\"munka_stop\" >";
		echo "<option value=\"6:00\">6:00</option>";		
		echo "<option value=\"6:30\">6:30</option>";		
		echo "<option value=\"7:00\">7:00</option>";
		echo "<option value=\"7:30\">7:30</option>";
		echo "<option value=\"8:00\">8:00</option>";
		echo "<option value=\"8:30\">8:30</option>";		
		echo "<option value=\"9:00\">9:00</option>";
		echo "<option value=\"9:30\">9:30</option>";
		echo "<option value=\"10:00\">10:00</option>";
		echo "<option value=\"10:30\">10:30</option>";			
		echo "<option value=\"11:00\">11:00</option>";
		echo "<option value=\"11:30\">11:30</option>";
		echo "<option value=\"12:00\">12:00</option>";
		echo "<option value=\"12:30\">12:30</option>";
		echo "<option value=\"13:00\">13:00</option>";
		echo "<option value=\"13:30\">13:30</option>";
		echo "<option value=\"14:00\">14:00</option>";
		echo "<option value=\"14:30\">14:30</option>";		
		echo "<option value=\"15:00\">15:00</option>";
		echo "<option value=\"15:30\">15:30</option>";
		echo "<option value=\"16:00\">16:00</option>";
		echo "<option value=\"16:30\">16:30</option>";
		echo "<option value=\"17:00\">17:00</option>";
		echo "<option value=\"17:30\">17:30</option>";
		echo "<option value=\"18:00\">18:00</option>";
		echo "<option value=\"18:30\">18:30</option>";
		echo "<option value=\"19:00\">19:00</option>";
		echo "<option value=\"19:30\">19:30</option>";
		echo "<option value=\"20:00\">20:00</option>";
		echo "<option value=\"20:30\">20:30</option>";
		echo "<option value=\"21:00\">21:00</option>";		
		echo "</select></td>";	
		echo "<td class=\"pause\"><select name=\"munka_etkezes\" >";
		echo "<option value=\"0\">0:00</option>";		
		echo "<option value=\"30\">0:30</option>";
		echo "<option value=\"45\">0:45</option>";
		echo "<option value=\"60\">1:00</option>";
		echo "</select></td>";	
		echo '<td><input type="submit" value="Rögzít"</td>';
		echo '</tr>';		
	echo '</table>';
	echo '</form>';
	echo "</div>";	

}
//Leírás: Az oldal nevének a beállítása.
//Bemenő adatok: -
//kimenő adat: Az oldal neve.
//----------------------------------
function munka_uj_feldolgoz($user)
{
	include("dbconn.php");
	if(isset($_POST["ev"])){ $ev = $_POST["ev"]; }
	if(isset($_POST["ho"])){ $ho = $_POST["ho"]; }
	if(isset($_POST["munka_datum"])){ $munka_datum = $_POST["munka_datum"]; }
	if(isset($_POST["munka_nev"])){ $munka_nev = $_POST["munka_nev"]; }
	if(isset($_POST["munka_start"])){ $munka_start = $_POST["munka_start"]; }
	if(isset($_POST["munka_stop"])){ $munka_stop = $_POST["munka_stop"]; }
	if(isset($_POST["munka_etkezes"])){ $munka_etkezes = $_POST["munka_etkezes"]; }
	if($munka_nev)
	{	
		$ertek_1=NULL;
		$ertek_2=$user;
		$ertek_3=$munka_nev;
		$ertek_4=$munka_datum." ".$munka_start.":00";
		$ertek_5=$munka_datum." ".$munka_stop.":00";
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
	header("Location:index.php");
	}


}
//----------------------------------
//Leírás: Egy szöveget átalakít ékezet nélküli szöveggé és  kis betűvé.
//Bemenő adatok: - Bármilyen ékezetes szöveg
//kimenő adat: - Angol ABC betűkkel helyettesített ékezetes karakterek. Minden betűről leveszi az ékezetet. Csak kis betűk lesznek.
//----------------------------------
function angolabc($nev)
{
$mit = array("\"A\", \"B\", \"C\", \"D\", \"E\", \"F\", \"G\", \"H\", \"I\", \"J\", \"K\", \"L\", \"M\", \"N\", \"O\", \"P\", \"Q\", \"R\", \"S\", \"T\", \"U\", \"V\", \"W\", \"X\", \"Y\", \"Z\", \"Á\", \"É\", \"Í\", \"Ó\", \"Ő\", \"Ö\", \"Ú\", \"Ű\", \"á\", \"é\", \"í\", \"ó\", \"ő\", \"ö\", \"ú\", \"ű\", \"Ü\", \"ü\", \"");
$mire = array("\"a\", \"b\", \"c\", \"d\", \"e\", \"f\", \"g\", \"h\", \"i\", \"j\", \"k\", \"l\", \"m\", \"n\", \"o\", \"p\", \"q\", \"r\", \"s\", \"t\", \"u\", \"v\", \"w\", \"x\", \"y\", \"z\", \"a\", \"e\", \"i\", \"o\", \"o\", \"o\", \"u\", \"u\", \"a\", \"e\", \"i\", \"o\", \"o\", \"o\", \"u\", \"u\", \"u\", \"u\", \"");
$nevjo  = str_replace($mit, $mire, $nev, $count);
return $nevjo;
}
//----------------------------------
//Leírás: Egy felhasználó jogosultságát ellenőrzi egy felvett munkához.
//Bemenő adatok: - user_id, work_id 
//kimenő adat: - Rögzítést tartalmazó rekord id száma. Ha van!
//----------------------------------
function felvett_munka_ellenorzes($user_id,$work_id)
{
	include("dbconn.php");
	try
	{
		$sql = "SELECT * FROM `felvett_munka` WHERE `user_id`=$user_id AND `work_id`=$work_id";
		$res = $conn->query($sql); // az utasítás csak most fut le
		$adat = $res->fetch();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	return $adat[0];	
}
//Leírás: Egy adat törlése a worktime táblából.
//Bemenő adatok: User id száma, worktime_id.
//kimenő adat: -
//----------------------------------
function worktime_delet($user_id,$worktime_id)
{
	include("dbconn.php");
	$sql = "DELETE FROM `worktime` WHERE `worktime`.`id` = $worktime_id";
	try
	{
		$res = $conn->query($sql); // az utasítás csak most fut le
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}


?>