#NoTrayIcon

#include <Array.au3>

$debug = True

$kvizInclude = FileOpen("kviz.include")
$kvizIncludeContent = FileRead($kvizInclude)
FileClose($kvizInclude)
$subor_otazky = @ScriptDir & "\otazky-" & $kvizIncludeContent & ".tsv"
$subor_odpovede = @ScriptDir & "\odpovede-" & $kvizIncludeContent & ".csv"
$subor_vyhodnotenie = @ScriptDir & "\vyhodnotenie-" & $kvizIncludeContent & ".ini"
$subor_poradie = @ScriptDir & "\poradie.html"

FileDelete($subor_vyhodnotenie)
FileDelete($subor_poradie)
FileDelete("*.tmp")

$subor_vyhodnotenie_vytvorit = FileOpen($subor_vyhodnotenie, 1)
FileClose($subor_vyhodnotenie_vytvorit)

; === OTÁZKY ===

If $debug Then ConsoleWrite("OTAZKY" & @CRLF)

$subor_otazky_pole = FileReadToArray($subor_otazky)
$subor_otazky_text = _ArrayToString($subor_otazky_pole, "@CRLF")
$subor_otazky_text_riadok = StringSplit($subor_otazky_text, "@CRLF", 1)

For $otazka = 1 To $subor_otazky_text_riadok[0]
   $subor_otazky_text_riadok_cast = StringSplit($subor_otazky_text_riadok[$otazka], Chr(9))
   IniWrite($subor_vyhodnotenie, "spravne", $otazka, $subor_otazky_text_riadok_cast[6]) ;zapíš číslo otázky a k nemu písmeno správnej odpovede
   If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $otazka & " - " & $subor_otazky_text_riadok_cast[6] & @CRLF)
Next

; === ODPOVEDE ===

If $debug Then ConsoleWrite(@CRLF & "ODPOVEDE" & @CRLF)

$subor_odpovede_pole = FileReadToArray($subor_odpovede)
$subor_odpovede_text = _ArrayToString($subor_odpovede_pole, "@CRLF")
$subor_odpovede_text_riadok = StringSplit($subor_odpovede_text, "@CRLF", 1)

For $odpoved = 1 To $subor_odpovede_text_riadok[0]
   $subor_odpovede_text_riadok_cast = StringSplit($subor_odpovede_text_riadok[$odpoved], ",")
	 $subor_odpovede_text_riadok_cast[6]
   If $subor_odpovede_text_riadok_cast[6] = IniRead($subor_vyhodnotenie, "spravne", $subor_odpovede_text_riadok_cast[5], "na-o") Then
		If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $subor_odpovede_text_riadok_cast[4] & " - " & $subor_odpovede_text_riadok_cast[5] & " - " & $subor_odpovede_text_riadok_cast[6] & " - " & IniRead($subor_vyhodnotenie, "spravne", $subor_odpovede_text_riadok_cast[5], "na-o") & " - 4 body" & @CRLF)
	  IniWrite($subor_vyhodnotenie, $subor_odpovede_text_riadok_cast[4], $subor_odpovede_text_riadok_cast[5], "4") ;zapíš 4 body za správnu odpoveď
   Else
	  IniWrite($subor_vyhodnotenie, $subor_odpovede_text_riadok_cast[4], $subor_odpovede_text_riadok_cast[5], "0") ;zapíš 0 bodov za nesprávnu odpoveď
   EndIf
Next

For $odpoved = 1 To $subor_odpovede_text_riadok[0]
   $subor_odpovede_text_riadok_cast = StringSplit($subor_odpovede_text_riadok[$odpoved], ",")
   $subor_pso_nazov = @ScriptDir & "\pso" & $subor_odpovede_text_riadok_cast[5] & ".tmp"
   If Not FileExists($subor_pso_nazov) And $subor_odpovede_text_riadok_cast[6] = IniRead($subor_vyhodnotenie, "spravne", $subor_odpovede_text_riadok_cast[5], "na-o") Then
		$hrac_pso_spolu = IniRead($subor_vyhodnotenie, $subor_odpovede_text_riadok_cast[4], "pso", "na-hrac_pso_spolu")
		If $hrac_pso_spolu = "na-hrac_pso_spolu" Then $hrac_pso_spolu = 0
		$celkovo_pso_spolu = IniRead($subor_vyhodnotenie, "pso", $subor_odpovede_text_riadok_cast[4], "na-celkovo_pso_spolu")
		If $celkovo_pso_spolu = "na-celkovo_pso_spolu" Then $celkovo_pso_spolu = 0
	  IniWrite($subor_vyhodnotenie, $subor_odpovede_text_riadok_cast[4], "pso", $hrac_pso_spolu + 1) ;pripočítaj 1 bod za prvú správnu odpoveď hráčovi
	  IniWrite($subor_vyhodnotenie, "pso", $subor_odpovede_text_riadok_cast[4], $celkovo_pso_spolu + 1) ;pripočítaj 1 bod za prvú správnu odpoveď do štatistík prvých správnych odpovedí
	  $subor_pso_zapocina = FileOpen($subor_pso_nazov, 1)
	  FileClose($subor_pso_zapocina)
   EndIf
Next

FileDelete("*.tmp")

$poradove_cislo = 1

For $odpoved = 1 To $subor_odpovede_text_riadok[0]
   $subor_odpovede_text_riadok_cast = StringSplit($subor_odpovede_text_riadok[$odpoved], ",")
   $subor_hrac_meno = @ScriptDir & "\pso" & $subor_odpovede_text_riadok_cast[4] & ".tmp"
   If Not FileExists($subor_hrac_meno) Then
	  IniWrite($subor_vyhodnotenie, "hraci", $poradove_cislo, $subor_odpovede_text_riadok_cast[4]) ;zapíš poradové číslo a meno hráča
	  $subor_hrac_zapisany = FileOpen($subor_hrac_meno, 1)
	  FileClose($subor_hrac_zapisany)
	  $poradove_cislo = $poradove_cislo + 1
   EndIf
Next

FileDelete("*.tmp")

$hrac = IniReadSection($subor_vyhodnotenie, "hraci")
$bodov_spolu = 0

For $cislo_hraca = 1 To $hrac[0][0]
   For $odpoved = 1 To $subor_odpovede_text_riadok[0] ;spočítaj všetky body hráča
		;$hrac[$cislo_hraca][1] je meno hráča
	  $bodov_spolu = $bodov_spolu + IniRead($subor_vyhodnotenie, $hrac[$cislo_hraca][1], $odpoved, "na-co")
	 Next
	 $bodov_spolu_s_pso = $bodov_spolu + IniRead($subor_vyhodnotenie, $hrac[$cislo_hraca][1], "pso", "na-co")
	 Switch StringLen($bodov_spolu_s_pso) ;zisti počet znakov v počte bodov spolu
		Case 1
			IniWrite($subor_vyhodnotenie, $hrac[$cislo_hraca][1], "spolu", "00" & $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu
			IniWrite($subor_vyhodnotenie, "body", $hrac[$cislo_hraca][1], "00" & $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu do štatistík
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $hrac[$cislo_hraca][1] & " - 00" & $bodov_spolu & @CRLF)
		Case 2
			IniWrite($subor_vyhodnotenie, $hrac[$cislo_hraca][1], "spolu", "0" & $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu
			IniWrite($subor_vyhodnotenie, "body", $hrac[$cislo_hraca][1], "0" & $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu do štatistík
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $hrac[$cislo_hraca][1] & " - 0" & $bodov_spolu & @CRLF)
		Case Else
			IniWrite($subor_vyhodnotenie, $hrac[$cislo_hraca][1], "spolu", $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu
			IniWrite($subor_vyhodnotenie, "body", $hrac[$cislo_hraca][1], $bodov_spolu_s_pso) ;zapíš hráčovi konečný počet bodov spolu do štatistík
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $hrac[$cislo_hraca][1] & " - " & $bodov_spolu & @CRLF)
	EndSwitch
   $bodov_spolu = 0
Next

$body = IniReadSection($subor_vyhodnotenie, "body")

;_ArrayDelete($body, 0)
;_ArrayDisplay($body)
_ArraySort($body, 1, 0, 0, 1)
;_ArrayDisplay($body)

If $debug Then ConsoleWrite(@CRLF & "PORADIE" & @CRLF)

For $miesto_cislo = 0 To $hrac[0][0] - 1
   ;$body[$miesto_cislo][0] je meno hráča a $body[$miesto_cislo][1] je počet bodov spolu
	 	Switch StringLen($body[$miesto_cislo][1]) ;zisti počet znakov v počte bodov spolu
		Case 1
			IniWrite($subor_vyhodnotenie, "miesta", $body[$miesto_cislo][0], "00" & $body[$miesto_cislo][1]) ;zapíš umiestnenie hráčov podľa počtu bodov
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $body[$miesto_cislo][0] & " - 00" & $body[$miesto_cislo][1] & @CRLF)
		Case 2
			IniWrite($subor_vyhodnotenie, "miesta", $body[$miesto_cislo][0], "0" & $body[$miesto_cislo][1]) ;zapíš umiestnenie hráčov podľa počtu bodov
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $body[$miesto_cislo][0] & " - 0" & $body[$miesto_cislo][1] & @CRLF)
		Case Else
			IniWrite($subor_vyhodnotenie, "miesta", $body[$miesto_cislo][0], $body[$miesto_cislo][1]) ;zapíš umiestnenie hráčov podľa počtu bodov
			If $debug Then ConsoleWrite("Debug - riadok " & @ScriptLineNumber & " - " & $body[$miesto_cislo][0] & " - " & $body[$miesto_cislo][1] & @CRLF)
	EndSwitch
Next

; === PORADIE ===

$subor_poradie_vytvorit = FileOpen($subor_poradie, 1)
FileWrite($subor_poradie_vytvorit, "<html>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "	<head>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta charset=""UTF-8"">" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta name=""viewport"" content=""width=device-width, initial-scale=1.0"">" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta http-equiv=""Cache-Control"" content=""no-store"" />" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta http-equiv=""Cache-Control"" content=""no-cache"" />" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta http-equiv=""Pragma"" content=""no-cache"" />" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<meta http-equiv=""expires"" content=""mon, 27 sep 2010 14:30:00 GMT"" />" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<link rel=""stylesheet"" type=""text/css"" href=""style.css"">" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<title>Kvíz - poradie</title>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "	</head>" & @CRLF & @CRLF)
FileWrite($subor_poradie_vytvorit, "	<body>" & @CRLF)
;~ FileWrite($subor_poradie_vytvorit, "		<h1>Poradie kvízu <?php echo str_replace("_", " ", ucfirst($kviz)) ?></h1>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<div class=""overflowXAuto"">" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		<table>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "			<tr>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "				<th>Miesto</th>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "				<th>Hráč</th>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "				<th>Body</th>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "				<th class=""visibilityHidden""></th>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "			</tr>" & @CRLF)
$miesto = IniReadSection($subor_vyhodnotenie, "miesta")
For $miesto_zoradene_cislo = 1 To $miesto[0][0]
   FileWrite($subor_poradie_vytvorit, "			<tr>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "			<tr>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "				<td class=""centrovane"">" & $miesto_zoradene_cislo & "</td>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "				<td class=""centrovane""><span class=""skryte" & $miesto_zoradene_cislo & """>" & $miesto[$miesto_zoradene_cislo][0] & "</span></td>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "				<td class=""centrovane"">" & $miesto[$miesto_zoradene_cislo][1] & "</td>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "				<td class=""centrovane""><button onclick=""document.querySelector('.skryte" & $miesto_zoradene_cislo & "').style.visibility='visible'"">Odkryť hráča</button></td>" & @CRLF)
   FileWrite($subor_poradie_vytvorit, "			</tr>" & @CRLF)
Next
FileWrite($subor_poradie_vytvorit, "		</table>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "		</div>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "	</body>" & @CRLF)
FileWrite($subor_poradie_vytvorit, "</html>")
FileClose($subor_poradie_vytvorit)