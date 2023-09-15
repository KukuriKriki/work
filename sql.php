<!DOCTYPE html>
<html>
<head>
    <title>Adatbázis adatok</title>
</head>
<body>
    <h1>Adatbázis adatai</h1>

<?php
include("fgv.php");


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
