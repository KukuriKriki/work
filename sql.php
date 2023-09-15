<!DOCTYPE html>
<html>
<head>
    <title>Adatbázis adatok</title>
</head>
<body>
    <h1>Adatbázis adatai</h1>

<?php
  // adatok felvétele a kapcsolathoz
  $servername = "netnote.hu";
  $username = "c1netnoteadmin";
  $password = "Szabok10";
  $dbname = "c1munka";

  // megpróbálunk csatlakozni a "try"-ban, ha nem sikerül, akkor elkapjuk a hibát a "catch"-ben
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); // PDO kapcsolat létrehozása
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // hibakezelés beállítása
    echo "Sikeres csatlakozás."; // sikeres csatlakozás visszajelzés
  } catch (PDOException $e) {
    echo "Sikertelen csatlakozás: " . $e->getMessage(); //visszajelzés sikertelen csatlakozásról
  }


$sql = "SELECT id FROM user"; // ez csak egy string, még nem hajtódik végre

$res = $conn->query($sql); // az utasítás csak most fut le

// html táblázatként íratjuk ki;
echo '<table border=1>';
echo '<tr>'; // táblázat fejléce
echo '<th>ID</th>';
echo '</tr>';

// a táblázat sorai
foreach ( $res as $current_row) { // most asszociatív tömbként kezeljük a sorokat
   echo '<tr>';
   echo '<td>' . $current_row["id"] . '</td>';
   echo '</tr>';
}
echo '</table>';

$conn = null; // lezárjuk az adatbázis-kapcsolatot

?>

</body>
</html>
