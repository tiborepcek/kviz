<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
$odpovede_subor = $_GET["subor"];
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
		<title><?php echo $odpovede_subor ?></title>
	</head>

	<body>
		<h1><?php echo $odpovede_subor ?></h1>
		<p class="centrovane">Údaje sú aktuálne k <b><?php echo date("d. m. Y, H:i:s");?></b></p>
		<p class="centrovane"><button class="button" onClick="window.location.href=window.location.href">Obnoviť údaje</button></p>
		<div class="centrovane">
		<?php
		$text = file_get_contents($_GET["subor"]);
		$text_riadok = explode("\n", $text);
		foreach ($text_riadok as $riadok) {
			echo '<p>' . $riadok . '</p>';
		}
		?>
		</div>
		<p class="centrovane"><a href="sprava.php">Späť na správu kvízov</a></p>
	</body>
</html>