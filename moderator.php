<?php
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
include("ochrana.php");
$kviz = file_get_contents("./kviz.include");
$otazky = "otazky-".$kviz.".tsv";
$otazok_spolu = count(file($otazky));
$subor_otazok = file_get_contents($otazky, true);
$subor_otazok_riadok = explode("\n", $subor_otazok);
?>

<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title>Kvíz <?php echo str_replace("_", " ", ucfirst($kviz)) ?> - moderátor</title>
   </head>

   <body>
        <?php
            zobraz($_GET['otazka']);

    function zobraz($otazka) {
        global $kviz, $otazok_spolu, $subor_otazok, $subor_otazok_riadok;
        $dalsia_otazka = $otazka + 1;
        $predosla_otazka = $otazka - 1;
                echo "<h1>";
                if ($otazka > 1) {
                    echo ' <a href="?otazka=' . $predosla_otazka . '">&lt;</a> ';
                }
                echo "Kvíz " . str_replace("_", " ", ucfirst($kviz)) . ", otázka " . $otazka . " / ". $otazok_spolu;
                if ($dalsia_otazka <= $otazok_spolu) {
                    echo ' <a href="?otazka=' . $dalsia_otazka . '">&gt;</a>';
                }
                echo "</h1>
                ";
                $subor_otazok_riadok_cast = explode("\t", $subor_otazok_riadok[$predosla_otazka]);
                echo '<div class="stlpce">
                <div class="vlavo">
                <h2 class="otazka">' . $subor_otazok_riadok_cast[0] . '</h2>
                ';
                if ($otazka == $otazok_spolu) {
                echo '<h3 class="dolezite centrovane">Toto je posledná otázka kvízu. Počkajte na výsledky, ktoré oznámi moderátor.</h3>
                    ';
				echo '<h4 class="centrovane"><a href="?otazka=1">Späť na prvú otázku</a></h4>
					';
                    }
                echo '</div><!-- koniec časti vlavo -->
                <div class="vpravo">
                ';
                echo '<div class="odpovede">
                ';
                echo '<h3 id="odpovedA"><span class="pismenoOtazky">A</span> ' . $subor_otazok_riadok_cast[1] . '</h3>
                ';
                echo '<h3 id="odpovedB"><span class="pismenoOtazky">B</span> ' . $subor_otazok_riadok_cast[2] . '</h3>
                ';
                echo '<h3 id="odpovedC"><span class="pismenoOtazky">C</span> ' . $subor_otazok_riadok_cast[3] . '</h3>
                ';
                echo '<h3 id="odpovedD"><span class="pismenoOtazky">D</span> ' . $subor_otazok_riadok_cast[4] . '</h3>
                ';
                if (file_exists("otazka".$otazka.".blok") or file_exists("kviz.blok")) {
                    echo "<h3 class=\"dolezite\">Táto otázka je zablokovaná.</h3>
                    ";
                    echo '<div><form action="odblokuj_otazku.php" method="post"> 
                    ';
                    echo '  <input type="hidden" name="kviz" value="' . $kviz . '" />
                    ';
                    echo '  <input type="hidden" name="otazka" value="' . $otazka . '" />
                    ';
                    echo '  <input type="hidden" name="otazokSpolu" value="' . $otazok_spolu . '" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="Odblokovať otázku" />
                    ';
                    echo '</form>
                    </div><!-- koniec časti odblokuj_otazku -->
                    ';
                    echo '<div><form action="odblokuj_vsetky_otazky.php" method="post"> 
                    ';
                    echo '  <input type="hidden" name="kviz" value="' . $kviz . '" />
                    ';
                    echo '  <input type="hidden" name="otazka" value="' . $otazka . '" />
                    ';
                    echo '  <input type="hidden" name="otazokSpolu" value="' . $otazok_spolu . '" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="Odblokovať všetky otázky" />
                    ';
                    echo '</form>
                    </div><!-- koniec časti odblokuj_vsetky_otazky -->
                    ';
                }
                else {
                    echo '<div><form action="zablokuj_otazku.php" method="post"> 
                    ';
                    echo '  <input type="hidden" name="kviz" value="' . $kviz . '" />
                    ';
                    echo '  <input type="hidden" name="otazka" value="' . $otazka . '" />
                    ';
                    echo '  <input type="hidden" name="otazokSpolu" value="' . $otazok_spolu . '" />
                    ';
                    echo '  <input type="submit" name="odpoved" value="Zablokovať otázku" />
                    ';
                    echo '</form>
                    </div><!-- koniec časti zablokuj_otazku -->
                    ';
                }
                echo "<div><button type=\"button\"
onclick=\"document.getElementById('odpoved" . trim($subor_otazok_riadok_cast[5]) . "').style.backgroundColor = 'green'\">
Označiť správnu odpoveď</button></div><!-- koniec časti oznacit_spravnu_odpoved -->
                ";
                echo "</div><!-- koniec časti odpovede -->
                ";
                echo "</div><!-- koniec časti vpravo -->
                </div><!-- koniec časti stlpce -->
                ";
    }
        ?>
   
   </body>
</html>
