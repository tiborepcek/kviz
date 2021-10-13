<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"):
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
	exit();
endif;
include("ochrana.php");
$kviz = str_replace("_", " ", ucfirst(file_get_contents("./kviz.include")));
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
		<title>Správa kvízov</title>
		<script>
		function validateForm() {
		  var x = document.forms["nahravanie"]["subor"].value;
		  if (x == "") {
			alert("Vyber súbor, ktorý chceš nahrať.");
			return false;
		  }
		}
		</script>
	</head>

	<body>
		<h1>Správa kvízov</h1>
		<p class="centrovane">Údaje sú aktuálne k <b><?php echo date("d. m. Y, H:i:s");?></b></p>
		<p class="centrovane"><button class="button" onClick="window.location.href=window.location.href">Obnoviť údaje</button></p>
		<p class="centrovane"><a href="ochrana.php?logout" class="obycajnyHover">Odhlásiť sa</a></p>
		<div class="centrovane borderTopBottom paddingBottom paddingTop marginBottom marginTop">
		<h2>Aktívny kvíz</h2>
		<p><?php echo $kviz ?> - <a href="kviz.include" class="obycajnyHover">kviz.include</a></p>
		<p class="lineHeight2"><a href="popis.php" class="obycajnyHover">popis</a> - <a href="index.php" class="obycajnyHover">index</a> - <a href="moderator.php?otazka=1" class="obycajnyHover">moderovať</a></p>
		</div>
		<div class="centrovane borderTopBottom paddingTop">
		<h2>Pridať súbor tsv, jpg, png, mp3, mp4 alebo html</h2>
		<form name="nahravanie" action="nahraj_subor.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
			<label for="subor">Vyber súbor, ktorý chceš nahrať. Existujúci súbor sa bez upozornenia prepíše.</label><br>
			<input type="file" name="subor" id="subor" required>
			<input type="submit" value="Nahraj súbor">
		</form>
		</div>
		<div class="centrovane vysokeRiadky borderTopBottom marginTop marginBottom">
		<h2>Otázky</h2>
		<?php
			$poradove_cislo = 1;
			foreach (glob("*.tsv") as $nazov_suboru) {
				$velkost = filesize($nazov_suboru);
				$pocet_riadkov = count(file($nazov_suboru));
			    $posledna_zmena = date ('d. m. Y H:i:s', filemtime($nazov_suboru));
			    $nazov_kvizu = rtrim(ltrim($nazov_suboru, "otazky-"), ".tsv");
				echo '<p>'. $poradove_cislo . '. <a href="' . $nazov_suboru . '" class="obycajnyHover">' . $nazov_suboru . '</a> - otázok: ' . $pocet_riadkov . ' - zmenené ' . $posledna_zmena . ' - <a href="zapis_nazov_kvizu.php?kviz=' . $nazov_kvizu . '" class="obycajnyHover">použiť</a> - <a href="uprav_subor.php?subor=' . $nazov_suboru . '" class="obycajnyHover">upraviť</a></p>';
				$poradove_cislo++;
			}
		?>
		</div>
		<div class="centrovane vysokeRiadky borderTopBottom marginTop marginBottom">
		<h2>Odpovede</h2>
		<?php
			$poradove_cislo = 1;
			foreach (glob("*.csv") as $nazov_suboru) {
				$velkost = filesize($nazov_suboru);
				$pocet_riadkov = count(file($nazov_suboru));
			    $posledna_zmena = date ('d. m. Y H:i:s', filemtime($nazov_suboru));
				echo '<p>'. $poradove_cislo . '. <a href="' . $nazov_suboru . '" class="obycajnyHover">' . $nazov_suboru . '</a> - riadkov: ' . $pocet_riadkov . ' - zmenené ' . $posledna_zmena . ' - <a href="zobraz_odpovede.php?subor=' . $nazov_suboru . '" class="obycajnyHover">zobraziť</a> - <a href="vymaz_subor.php?subor=' . $nazov_suboru . '" class="obycajnyHover">vymazať</a></p>';
				$poradove_cislo++;
			}
		?>
		</div>
	</body>
</html>
