<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"):
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
	exit();
endif;

$kviz = file_get_contents("./kviz.include");
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-store" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="expires" content="mon, 27 sep 2010 14:30:00 GMT" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Kvíz <?php echo str_replace("_", " ", ucfirst($kviz)) ?> - úvod</title>
	</head>

	<body>
		<h1>Zadaj meno a e-mail a ťukni na tlačidlo HRAŤ.</h1>
		<div class="centrovane">
			<form action="hrac.php" method="get" autocomplete="on">
				<input type="text" name="meno" size="20" maxlength="20" placeholder="Meno hráča kvízu <?php echo str_replace("_", " ", ucfirst($kviz)) ?>" required />
				<input type="email" name="email" size="20" placeholder="E-mail hráča kvízu <?php echo str_replace("_", " ", ucfirst($kviz)) ?>" required />
				<input type="hidden" name="otazka" value="1" />
				<input type="submit" value="HRAŤ" />
			</form>
		</div>
		    <p class="centrovane"><?php include('phpqrcode.php'); QRcode::png('https://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']), 'url.png', QR_ECLEVEL_L, 10);  ?><img src="url.png" alt="URL"></p>
		    <p class="centrovane"><?php echo $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) ?></p>
		    <p class="centrovane"><?php echo "(".str_replace("_", " ", ucfirst($kviz)).")" ?></p>
	</body>
</html>