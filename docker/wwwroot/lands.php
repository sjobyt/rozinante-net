<?php
include("functions.php");
$style['standard'] = true;
$style['landinfo'] = true;
$style['image'] = true;
print_htmlheader("Landinfo by Paul", $style, "");
?>

<body>



<?php include('bar.php'); ?>

<div id="wrap">

<div id="display" style="background-color: #415060; padding-top: 0px;">

<div style="padding: 10px; margin-top: 0px; background: #2a4456; border-bottom: 1px solid #586878;">

<center>

<div style="margin: auto;">

<?php
$cont = $_GET['cont'];

print("
<map name=\"eur\">
<area title=\"England\" shape=\"poly\" coords=\"64,152,79,152,91,183,86,197,57,200,70,181\" href=\"lands.php?code=en&cont=eur\"/>\n
<area title=\"Frankrike\" shape=\"poly\" coords=\"57,214,74,213,89,212,100,200,126,220,115,241,124,256,100,266,94,276,67,262,70,253,57,221\" href=\"lands.php?code=fr&cont=eur\" />\n
<area title=\"Spania\" shape=\"poly\" coords=\"17,263,28,252,70,264,96,277,70,297,58,316,40,320,27,322,17,307,31,271,31,268\" href=\"lands.php?code=es&cont=eur\" />\n
<area title=\"Portugal\" shape=\"poly\" coords=\"17,262,30,256,32,274,23,291,20,305,16,309,8,305,8,284,17,270\" href=\"lands.php?code=pt&cont=eur\" />
</map>");

print("
<map name=\"na\">
<area title=\"USA\" shape=\"poly\" coords=\"16,163,5,203,13,213,27,243,68,250,90,271,143,249,160,264,163,220,160,200,175,164\" href=\"lands.php?code=us&cont=na\" />\n
<area title=\"Canada\" shape=\"poly\" coords=\"0,50,18,170,150,180,186,129,89,40,41,82\" href=\"lands.php?code=ca&cont=na\" />
</map>\n");

print("
<map name=\"af\">
<area title=\"Senegal\" shape=\"poly\" coords=\"53,176,68,180,75,191,77,204,55,201,47,202,43,189,48,178\" href=\"lands.php?code=sn&cont=af\" />
</map>\n");

print("
<map name=\"sa\">
<area title=\"Fransk Guiana\" shape=\"poly\" coords=\"328,100,319,114,307,117,301,110,304,102,301,93,304,86,321,92\" href=\"lands.php?code=gf&cont=sa\" />
<area title=\"Surinam\" shape=\"poly\" coords=\"277,81,268,100,275,107,284,118,300,114,305,107,304,91,305,86,288,80\" href=\"lands.php?code=sr&cont=sa\" />
<area title=\"Guiana\" shape=\"poly\" coords=\"247,62,241,86,253,98,253,117,260,124,277,119,288,113,270,96,240,89,276,81,261,65\" href=\"lands.php?code=gy&cont=sa\" />
<area title=\"Venezuela\" shape=\"poly\" coords=\"145,30,130,54,140,74,164,79,176,82,179,102,182,113,192,126,212,121,220,114,208,100,231,98,239,83,244,67,248,60,240,48,212,40,220,43,173,41,151,37,142,40,142,26\" href=\"lands.php?code=ve&cont=sa\" />
<area title=\"Brasil\" shape=\"poly\" coords=\"182,112,191,126,219,114,207,98,246,90,253,97,258,112,288,119,314,117,325,114,330,100,341,126,350,136,351,237,204,238,200,220,171,236,155,232,156,233,133,220,128,200,144,178,160,170,160,137,162,129,164,119,178,114\" href=\"lands.php?code=br&cont=sa\" />
</map>\n");

if($cont == "eur") {
    full_map($cont);
} else {
    printf("<a href=\"lands.php?cont=eur\"><img src=\"%s\" alt=\"Europa\" title=\"Europa\" class=\"continent\"></a>\n", "landinfo/continents/europe_small.png");
}

if($cont == "af") {
    full_map($cont);
} else {
    printf("<a href=\"lands.php?cont=af\"><img src=\"%s\" alt=\"Afrika\" title=\"Afrika\" class=\"continent\"></a>\n", "landinfo/continents/africa_small.png");
}

if($cont == "na") {
    full_map($cont);
} else {
    printf("<a href=\"lands.php?cont=na\"><img src=\"%s\" alt=\"Nord-Amerika\" class=\"continent\" title=\"Nord-Amerika\"></a>\n", "landinfo/continents/north_america_small.png");
}

if($cont == "sa") {
    full_map($cont);
} else {
    printf("<a href=\"lands.php?cont=sa\"><img src=\"%s\" alt=\"Sør-Amerika\" class=\"continent\" title=\"Sør-Amerika\"></a>\n", "landinfo/continents/south_america_small.png");
}



function full_map($cont) {
    switch($cont) {
        case "eur":
            printf("<img src=\"%s\" alt=\"\" class=\"continent\" usemap=\"#eur\">\n", "landinfo/continents/europe.png");
            break;

        case "na":
            printf("<img src=\"%s\" alt=\"Nord-Amerika\" class=\"continent\" usemap=\"#na\">", "landinfo/continents/north_america.png");
            break;

        case "af":
            printf("<img src=\"%s\" alt=\"Afrika\" class=\"continent\" usemap=\"#af\">", "landinfo/continents/africa.png");
            break;
        case "sa":
            printf("<img src=\"%s\" alt=\"Sør-Amerika\" class=\"continent\" usemap=\"#sa\">", "landinfo/continents/south_america.png");
            break;
    }
}






?>


</div>
</center>
</div>

<div id="displaycontent" style="background-color: #f4f3be; margin: 10px;">



<?php

function special_handler($data,$type) {

    switch($type) {
        case "timezone":
            switch($data) {
                case "CET":
		    $formatted = "Central European Time";
		    break;
		case "GMT":
		    $formatted = "Greenwich Mean Time";
		    break;
	    }
            break;
        case "area":
            $formatted = $data . " km²";
            return $formatted;
            break;
        case "number":
            if($data > 1000000) {
                $formatted = $data/1000000 . " millioner";
	    } else {
	        $formatted = $data;
	    }
    }

    return $formatted;

}

function get_name($isocode) {

    $fp = fopen ("landinfo/countrydata/names.list", "r");
    do {
	$buffer = fgets($fp, 4096);
        $columns = explode(",", $buffer);
    } while ( ($columns[0] != $isocode) && (!feof($fp)) );


    if($columns[0] == $isocode) {
	return($columns[1]);
    } else {
    	return "\"" . $isocode . "\"";
    }

fclose ($fp);

}


$nesting = array();
$current;



$file = "landinfo/countrydata/" . $_GET['code'] . ".xml";

function startElement($parser, $name, $attrs) {
    global $nesting;
    global $current;
    global $table;
    global $section;
    global $link;
    global $handler;
    global $eval;



    array_push($nesting, $name);
    $current = $name;

    if($table == true) {

        switch($current) {
     	    case "caption":
		print "<caption>";
		break;
	    case "tr":
		print "<tr>";
		break;
	    case "th":
		print "<th>";
		break;
	    case "td":
		print "<td>";
		break;
	}

    } else {

	switch ($current) {
 	    case "table":
		printf("<table>");
		$table = true;
		break;
	    case "country":
	        $lang_code = $attrs['code'];
	        $name = get_name($lang_code);
      	        printf("<img src=\"landinfo/maps/%s-map.png\" class=\"map\">", $lang_code);
       	        printf("<img src=\"landinfo/flags/%s-flag.png\" class=\"flag\">", $lang_code);
	        printf("<h1 style=\"clear: none;\">%s</h1>", $name);

	        break;
	    case "data":
		print("<div class=\"data\">");
		$data = true;
		break;
	    case "eval":
	        print "<div class=\"eval\">";
	        $eval = true;
	        break;
	}

	if($eval) {
	    switch ($current) {
	        case "head":
	            print "<h2>";
	            break;
	        case "p":
	            print "<p>";
	            break;
	    }
	}

    }

    switch($current)  {
	case "href":
	    $link = true;
	    break;
	case "br":
	    print "<br/>";
	    break;
	case "trans":
	    $handler = $attrs['type'];
	    break;
	case "list":
	    print "<ul>";
	    break;
	case "li":
	    print "<li>";
	    break;
	case "link":
	    printf("<a href=\"%s\">", $attrs['href']);
	    break;
        case "title";
	    print "<h2>";
	    break;
    }



}

function characterData($parser, $data) {
    global $nesting;
    global $current;
    global $link;
    global $handler;


    if($link == true) {
        $new_data = "<a href=\"$data\">$data";
        print $new_data;
    } elseif ($handler) {
	printf("%s\n", special_handler($data,$handler));
    } else {
	print $data;
    }
}




function endElement($parser, $name) {
    global $nesting;
    global $current;
    global $table;
    global $link;
    global $handler;
    global $eval;


    if($table == true) {

        switch($current) {
	    case "caption":
		print "</caption>";
		break;
	    case "tr":
		print "</tr>";
		break;
	    case "th":
		print "</th>";
		break;
	    case "td":
		print "</td>";
		break;
	    case "table":
		print "</table>";
		$table = false;
		break;
	}

    } else {

	switch ($name) {
	    case "data":
	        print "</div>";
       		$data = false;
	        break;
	    case "eval":
	        print "</div>";
	        $eval = false;
	        break;
	}

	if($eval) {
	    switch ($name) {
	        case "head":
	            print "</h2>";
	            break;
	        case "p":
	            print "</p>";
	            break;
	    }
	}

    }

    switch($name) {
	case "href":
	    print "</a>";
	    $link = false;
	    break;
	case "trans":
	    $handler = false;
	    break;
	case "li":
	    print "</li>";
	    break;
	case "list":
	    print "</ul>";
	    break;
	case "link":
	    print "</a>";
	    break;
        case "title";
	    print "</h2>";
	    break;
    }


    array_pop($nesting);
    $current = end($nesting);
}


if(is_file($file)) {


$fp = fopen ($file,"r");
do {
    $char = fgetc ( $fp );
    $data = $data . $char;
} while (!feof ($fp));
fclose ($fp);


$parser = xml_parser_create("ISO-8859-1");
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");


xml_parse($parser, $data);



print(xml_error_string (xml_get_error_code ($parser)));



xml_parser_free ($parser);
} elseif ($_GET['page'] != "forbehold") {

print("<h1>Reiserute</h1><p>Oversikten fungerer på pek og trykk prinsippet. Først velger du verdensdel, så kan du trykke på et bestemt land. Da vil informasjonen om dette landet komme frem. Hvis du er usikker på hvilket land du peker på, kan du holde pekeren stille så vil det komme en liten tekst med navnet på landet.</p>

<p>Landinformasjonen er ikke på noen måte komplett, og endringer vil nok sje fra tid til annen.
Spesielt blir avgang og ankomst datoene fort utdatert. Se <a href=\"med.php\">\"Lyst å være med?\"</a> for den mest oppdaterte oversikten.
Før du bruker eller stoler på noe av denne informasjonen, les våre forbehold!</p>

<p><b>Vi gjør oppmerksom på at landinfoen ble laget når det fortsatt var meningen å seile nordatlanteren rundt og eventuell feilaktig informasjon dette vil medføre.
</b></p>
<p><a href=\"paul.php\">Paul</a></p>");

insert_image("graphics/ruteplanen2005_small.jpg", "", "ruteplanen2005.jpg", "logoneutral", "", "");

print "<div class=\"contentblock\"></div>";

}

?>

<?php if ($_GET['page'] == "forbehold"): ?>

<h1>Forbehold</h1>
<p>Generelt er all landinformasjonen vi har lagt ut her fritt skrevet av undertegnede (med god hjelp av <a href="visitors.php?id=christina">Christina</a>). Jeg garanterer ikke for at noe av informasjonen er riktig eller nøyaktig. Kildene er stort sett de som er oppgitt på bunnen. I tillegg kommer mine ville drømmer om det fremtidige opphold på stedet..</p>

<h2>Punktene i skjemaet</h2>

<h3>Visum</h3>
<p>Når vi skriver at det ikke er nødvendig med visum for nordmenn, så er det fordi det heter seg at det er visum fritt. Men visumfriheten innebærer som oftest at visse betingelser må oppfylles osv.
Feks i USA er det "visum" fritt for nordmenn. MEN, dette gjelder bare hvis du lander på en flyplass med et vanlig rutefly. Ankommer du på noe annet vis eller et annet sted en en internasjonal flyplass må du ha visum!</p>

<h3>Utstrekning</h3>
<p>Har har vi fritt rundet av i kantene på antall kvadratkilometer.</p>

<p>Det samme gjelder befolkning, religion og språk. Vi har tatt med det som vi mente passet. Se kildene for mer nøyaktig informasjon.</p>

<h3>Valuta-delen</h3>
<p>Her har vi fritt antatt hvordan det er utifra hvordan kildene våre har beskrevet stedet. Eventuelt hvis vi har hørt noe om det selv.</p>

<h3>Sikkerhet</h3>
<p>Sykdommer er tatt fra Lonely Planet og Ferieguiden. Noen steder har vi nevnt at det er viktig med visse vaksiner. Det betyr ikke at man ikke trenger vaksiner andre steder. Hør med ditt lokale vaksinasjonskontor om hva hva som er aktuelt av vaksiner for der du skal reise.
Naturkatastrofene og farene har vi sett på TV og raskt tatt ut i fra CIA`s World Fact Book. Det hele kommer selvfølgelig veldig ann på hva man selv finner på.</p>

<h3>Attraksjoner</h3>
<p>Disse var mer eller mindre tilfeldige personlige valg. Det finnes nok LANGT mere og andre ting å se for den som ønsker det!</p>

<?php endif; ?>




</div>

</div>

<div id="menu">

<div id="menucontent">

<div class="menublock" class="nopadding">

<dl>
<dt>Land:</dt>

<dt class="cont">Europa:</dt>

<dd><a href="lands.php?code=en&cont=eur">» England</a></dd>
<dd><a href="lands.php?code=fr&cont=eur">» Frankrike</a></dd>
<dd><a href="lands.php?code=gl&cont=eur">» Grønnland</a></dd>
<dd><a href="lands.php?code=nl&cont=eur">» Nederland</a></dd>
<dd><a href="lands.php?code=pt&cont=eur">» Portugal</a></dd>
<dd><a href="lands.php?code=es&cont=eur">» Spania</a></dd>
<dd><a href="lands.php?code=canary">» Kanariøyene</a></dd>


<dt class="cont">Afrika:</dt>

<dd><a href="lands.php?code=sn&cont=af">» Senegal</a></dd>
<dd><a href="lands.php?code=cv">» Kapp Verde</a></dd>

<dt class="cont">Sør-Amerika:</dt>
<dd><a href="lands.php?code=gf&cont=sa">» Fransk Guiana</a></dd>
<dd><a href="lands.php?code=gy&cont=sa">» Guiana</a></dd>
<dd><a href="lands.php?code=br&cont=sa">» Brasil</a></dd>
<dd><a href="lands.php?code=sr&cont=sa">» Surinam</a></dd>
<dd><a href="lands.php?code=ve&cont=sa">» Venezuela</a></dd>


<dt class="cont">Nord-Amerika:</dt>
<dd><a href="lands.php?code=us&cont=na">» USA - New York</a></dd>
<dd><a href="lands.php?code=ca&cont=na">» Canada</a></dd>



</dl>
</div>

<div class="menublock">
<dl>
<dt>Generelt:</dt>
<dd><a href="lands.php">» Generell info</a></dd>
<dd><a href="lands.php?page=forbehold">» Forbehold</a></dd>
</dl>
</div>


<p style="text-align: center; font-style: italic;">Alle kart er hentet fra <a href="http://www.cia.gov/cia/publications/factbook/index.html">CIA's "World Factbook"</a></p>
</div>

</div>


</div>
</body>
</html>



