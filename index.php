<?php
ob_start();
include("fgv.php");

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
							munka();
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
ob_end_flush();
?>
