<?
  // adatok felv�tele a kapcsolathoz
  $servername = "netnote.hu";
  $username = "c1netnoteadmin";
  $password = "Szabok10";
  $dbname = "c1munka";

  // megpr�b�lunk csatlakozni a "try"-ban, ha nem siker�l, akkor elkapjuk a hib�t a "catch"-ben
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); // PDO kapcsolat l�trehoz�sa
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // hibakezel�s be�ll�t�sa
    echo "Sikeres csatlakoz�s."; // sikeres csatlakoz�s visszajelz�s
  } catch (PDOException $e) {
    echo "Sikertelen csatlakoz�s: " . $e->getMessage(); //visszajelz�s sikertelen csatlakoz�sr�l
  }
?>
