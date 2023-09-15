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
	$adat="Net Note";
	return $adat;
}
//----------------------------------
//Leírás: Az összes felhasználó nevét kiírja.
//Bemenő adatok: -
//kimenő adat: -
//----------------------------------
function user_kiir()
{
	$parancs = (" SELECT * FROM `user` ")or die(mysql_error());
	$eredmeny = mysql_query($parancs);
	if (!$parancs)
	{
		die("Érvénytelen lekérdezés: " . mysql_error());
	}
	
	while($sor=mysql_fetch_array($eredmeny))
		{
			printf("				
			<table>
				<tr>
					<td width=\"100\">
						<span class=\"login\">
							%d
						</span>
						</td>
						<td style=\"text-align: right;\"width=\"65\">
							<span class=\"login\">
								%s
							</span>
						</td>
					</tr>
			</table>
	",$sor["id"],$sor["user"]);
		}
	}
?>