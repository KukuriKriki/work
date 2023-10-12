<?php
ob_start();
include("fgv.php");
$user=1;
$ev=date("Y");
$ho=date("m");
if(isset($_GET["ev"])){ $ev = $_GET["ev"]; }
if(isset($_GET["ho"])){ $ho = $_GET["ho"]; }
if(isset($_GET["worktime_id"])){ $worktime_id = $_GET["worktime_id"]; }
munka_uj_feldolgoz($user);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<link rel="stylesheet" type="text/css" href="style.css" />
		<body>
			<div id="head">
			<?=nev();?>
			<a href="http://84.21.7.19/sql.php" target="_blank">
				<button type="button">sql.php megnyitása</button>
			</a>

			</div>
			<div id='balcsik'>
				<?php
					honap_lista($user,$ev,$ho);
				?>
			</div>
			<div id='jobbcsik'>
			</div>
			<div id='kozepso'>
				<div class="tavtarto2">
				</div>
				<div>
					<div class="tabla_fej">
					</div>
					<div class="tabla_kozep">
						<?php
							
							munka_fejlec($user,$ev,$ho);
							munka($user,$ev,$ho,0);
							munka_uj($user);
							$m_dij=5000;
							echo munkanev_keres(9)." ".ledolgozott_ido_munka($user,9)." óra";
							echo "<br>Munkadíj:".$m_dij."  összesen=".ledolgozott_ido_munka($user,9)*$m_dij."Ft/Fő";
							echo "<br>Teljes munkadíj két főre:".ledolgozott_ido_munka($user,9)*$m_dij*2 ."Ft<br><br>";
							
							echo munkanev_keres(10)." ".ledolgozott_ido_munka($user,10)." óra";
							echo "<br>Munkadíj:". 4500 ."  összesen=".ledolgozott_ido_munka($user,10)*4500 ."Ft/Fő";
							echo "<br>Teljes munkadíj két főre:".ledolgozott_ido_munka($user,10)*4500*2 ."Ft<br><br>";
							
							echo munkanev_keres(11)." ".ledolgozott_ido_munka($user,11)." óra";
							echo "<br>Munkadíj:".$m_dij."  összesen=".ledolgozott_ido_munka($user,11)*$m_dij."Ft/Fő";
							echo "<br>Teljes munkadíj két főre:".ledolgozott_ido_munka($user,11)*$m_dij*2 ."Ft<br><br>";
							
						?>
					</div>
				</div>
			</div>	
			<div id="foot">
				<?php echo"Lábrész";?>
			</div>
			
		</body>
	</html>
<?php
if($worktime_id)
{
	alert_delete($user,$worktime_id);
}
ob_end_flush();
?>
