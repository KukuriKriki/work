<?
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
?>
