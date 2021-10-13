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
		<h1>Moderovaný online kvíz</h1>
		<h2 >Čo potrebujete</h2>
		<ul class="lineHeight2">
			<li>Zariadenie s väčším displejom alebo monitorom, na ktorom budete čítať otázky a odpovede prezentované moderátorom cez niečo ako Zoom.</li>
			<li>Mobil, na ktorom budete vyberať písmeno správnej odpovede.</li>
			<li>Wifi iba pre tie 2 zariadenia (ostatné odpojte), ideálne kábel pre prvé zariadenie a mobilné dáta pre mobil.</li>
		</ul>
		<h2>Ako to funguje</h2>
		<ul class="lineHeight2">
			<li>Na mobile hráč vyberá písmeno správnej odpovede a riadi sa jednoduchými pokynmi.</li>
			<li>Prvá správna odpoveď = 5 bodov. Správna odpoveď (nie prvá) = 4 body. Vždy je iba jedna odpoveď správna. V prípade rovnakého počtu bodov bude rozstrelová otázka.</li>
			<li>Moderátor zobrazuje otázky so správnymi odpoveďami a určuje počet sekúnd/minút, počas ktorých môžu hráči odpovedať.</li>
			<li>Zadajte e-mail, pod ktorým chcete vystupovať v kvíze a zvolte tlačidlo "HRAŤ":</li>
		</ul>
		<h2>Začnite hrať</h2>
			<p>Jednoducho <a href="index.php">prejdite na registračnú stránku pre hráča</a>, na ktorej nájdete všetky potrebné pokyny.</p>
	</body>
</html>
