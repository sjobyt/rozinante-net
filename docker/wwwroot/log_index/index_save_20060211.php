<?php
include("functions.php");
include("php_functions/letter_data.php");
include("php_functions/report_functions.php");
$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
$style['table'] = true;
$style['frontpage'] = true;
$style['letters'] = true;
$style['report'] = true;
print_htmlheader("Jorda rundt med Rozinante 2003-200X", $style, ""); ?>

<body>




<?php $selected = 1; include('bar.php'); ?>

<div id="wrap">

<div id="article">




<div id="articlecontent">
<br/>

<h1>På vei mot Kapp Horn</h1>


<? insert_image("graphics/forside20060203_small.jpg", "Staale, fredag 3.
februar, 105° 06.72' W/55° 10.24' S, 5.3 knots, heading 77°.",
"graphics/forside20060203.jpg", "picleft", "", ""); ?>



<div class="lefttab">


<?php
$fp = fopen("news/reports/data/" . $last_file . "/no_msg.txt", 'r') or exit();

$counter = 0;
$text = "";
do {
	$char = fgetc($fp);
	$text .= $char;
	$counter++;

} while(!($char == chr(10) && $counter > 200));

fclose($fp);
printf("<div class=\"reportbox\"><div class=\"title\"><p>Siste rapport - %s</p></div><div
class=\"text\"><p><code>%s</code><br/><a href=\"report.php?open=%s\">Les
mer</a></p></div></div>", $rel_rap, $text, $last_file);
?>

<p>Rozinante er nå på vei over det sydlige stillehavet mot Kapp Horn og er snart fremme i Sør Amerika. Staale har vært vekke
fra sivilsasjonen i over 45 dager. Det meste ombord styres av været: fremdriften,
sikkerheten, kommunikasjonen, bevegelsene, lydene og
ikke minst humøret. Rozinante og Staale nærmer seg Sør-Amerika for alvor. Les <a
href="report.php?open=<?=$last_file ?>">siste reiserapport</a> for å høre hvordan det går.</p>



</div>



<div class="righttab">

<h2>Følg Rozinante på kartet</h2>

<? insert_image("graphics/automap.jpg", "", "map.php", "picright", "", ""); ?>


<p>Undertegnede har ordnet et system som plotter posisjons -rapportene på
et kart over det aktuelle området som Rozinante befinner seg på.
Dette gjør det litt lettere å følge med på hvor båten faktisk befinner seg siden bare koordinater ikke sier folk flest noe særlig.</p>
<p>Trykk på kartet eller på <a href="map.php">posisjon</a> oppe til høyre for å se hvor Rozinante er.</p>

<p>Legg gjerne igjen en hilsen i <a href="gbook.php">gjesteboken</a>!</p>
<p><b>Webmaster</b></p>

</div>

<div class="horizline"></div>

<div class="lefttab">

<h2>Film fra Cape Town til Hobart</h2>

<? insert_image("graphics/video.jpg", "",
"public/DVKRSMPEG1VCD.mpg", "picright", "", ""); ?>

<p>Jeg ble til slutt ferdig med filmen fra Cape Town til Hobart, men den slutter litt raskt fordi jeg ble aldri helt ferdig med den. Filmen
er i MPEG1-format og er på ca. 170 MB. Mer film skal jeg nok få laget på resten av turen.</p>
<p><b>Staale, 29. desember</b></p>
<p><a href="public/DVKRSMPEG1VCD.mpg">Last ned film</a></p>
<p>I tillegg kan du se en <a href="public/tvsor.wmv">reportasje</a> som gikk på TVSør og TVNorge i juni. (Kvalitet er så som så).</p>


</div>

<div class="righttab">



<h2>Reisebrev fra Auckland Islands</h2>


<? insert_image("graphics/forside20060103_small.jpg", "Til ankers i Waterfall Inlet, Auckland Island.",
"graphics/forside20060103.jpg", "picright", "", ""); ?>


<p>Staale har sendt reisebrev med mange bilder fra øya <a href="http://en.wikipedia.org/wiki/Auckland_Islands">Auckland Island</a>.
Her har det skjedd mye forskjellig som du kan lese i <a href="letters.php?read=0034_auckland.xml">reisebrevet</a>.</p>

<p>Husk også å lese <a href="report.php">reiserapporter</a>.</p>

<p><b>Webmaster, 3. januar</b></p>


</div>



<div class="horizline"></div>






<div class="contentblock"></div>






<h2>Nyeste reisebrev</h2>
<?php



$dirs = make_letter_list();

$data = read_letter($dirs[0]);

$info = $data[1];
$doc_files = $data[2];
$doc_titles = $data[3];
$total_docs = count($doc_files);

print("<div class=\"header\">\n");
print("<div class=\"lefttab\">\n");
printf("<div class=\"heading\">\n<h2>%s<br/><span class=\"date\">%s</span></h2>\n</div>\n", $info[0], strftime("publisert: %a %d %B %Y %H:%M", $data[0]));
print("<table class=\"header\">\n");
printf("<tr><th>Hvor:</th><td>%s</td></tr>\n", $info[1]);
printf("<tr><th>Når:</th><td>%s</td></tr>\n", strftime("%a %d %B %H:%M", strtotime($info[2])));
print("</table>\n");
print("<table class=\"header\">\n");
printf("<tr><th>Tekster:</th><td>%s</td></tr>\n", $total_docs);
printf("<tr><th>Størrelse:</th><td>%s</td></tr>\n", size_conv($info[3]));
print("</table>\n");

$desc_filename = $letters . $dirs[$letternum] . "/" . "desc.txt";

print("</div>\n");
print("<div class=\"righttab\">\n");
print("<table class=\"list\">\n");


$current_no = 1;

while($current_no < $total_docs + 1) {

if($color == "light") {
	$color = "dark";
} else {
	$color = "light";
}

printf("<tr><th class=\"%s\"><img src=\"graphics/article_icon_%s.png\" alt=\"Tekst\"/></th><td class=\"%s\"><a href=\"letters.php?read=%s\">%s</a></td></tr>\n", $color, $color, $color, $dirs[$dir_no] . "_" . $doc_files[$current_no], $doc_titles[$current_no]);

$current_no++;
}

print("</table>\n");
print("</div>\n");

if($data[4]) {
	printf("<div class=\"summary\">\n<p>%s</p></div>\n", $data[4]);
}

print("<div class=\"contentblock\"></div>\n");
print("</div>");

?>








<div class="lefttab">



<h2>Alene rundt Antarktis</h2>
<?php insert_image("graphics/route_ills.jpg", "", "", "picright", "", "") ?>

<p>Ståle og Rozinante fortsetter ferden fra Hobart, Tasmania
videre til sørenden av New Zeland og så til Kapp Horn. Turen går
deretter over Sør-Atlanteren og til Cape Town for andre gang.
Rozinante og Ståle har da seilt rundt Antarktis. Forventet
ankomst Cape Town er i mars 2006.</p>



</div>

<div class="righttab">

<h2>Administrative nyheter</h2>

<?php
include("news_functions.php");

$dirname = "nyheter/";
$dir = opendir($dirname);

while (false !== ($file = readdir($dir))) {
    if($file > $newest_file) {
        $newest_file = $file;
    }
}

print_news($newest_file);
?>

</div>

<div class="horizline"></div>

<div class="righttab">


<h2>Generell informasjon</h2>
<p>Sommeren 2003 la tre gutter ut på en ferd som skulle vare i et år og ruta var melkeruta tur/retur karibien. Dette har utviklet seg til å bli en jordomseiling fra vest mot øst alene. Ferden gjennom sydishavet startet fra Cape Town i begynnelsen av februar 2005, og Rozinante vil tilbringe den sydlighalvkules vinter på New Zealand før ferden fortsetter over stillehavet rundt Kapp Horn i november '05/Januar '06 før sirkelen sluttes i Cape Town i mars 2006. Se <a href="ruteplanen2005.jpg">utseilt og planlagt rute</a>.</p>


</div>


<h2>Hvordan du finner fram på sida</h2>
<p>Siden dette prosjektet har vart en god stund og har endret seg drastisk undeveis, er det kanskje på sin plass med aldri så lite informasjon om hvor du finner ting. Sikkert til glede
for nye lesere som kanskje finner nettstedet uoversiktlig til å begynne med.</p>
<p>Når Rozinante er under seil  er <a href="report.php">reiserapporter</a>
stedet du vil finne
oppdateringer. Oppdateringer kommer nesten daglig fra Rozinante og Staale. Oppdateringene
sendes via kortbølgeradio og med den begrensede kapasiteten det gir, vil det som regel bare være tekst.</p>
<p>Ved større "begivenheter" og mulighet for større oppdateringer i land, benyttes <a href="letters.php">reisebrev</a>. Her er det gjerne mye bilder sammen med tekst.</p>
<p>Når det gjelder eldre nyheter, finner du det under <a href="rozinante_log.php">"Eldre nyheter"</a> oppe til høyre på menyen. Her finner du lesestoff helt fra
prosjektets begynnelse fram til den første seilasen fra Kristiansand.
Etter det er det reisebrevene som gjelder. Kan også bemerke at "Eldre
nyheter" og "Reisebrev" overlapper noe.</p>
<p>Nyheter som nettstedets drift, finner du under <a href="news.php">Administrative nyheter</a>. Disse skrives av webmaster hvis det skulle være noe viktig ang. drifting av sidene.</p>
<p>Ellers er det bare trykke på linkene i menyen så vil det meste stå forklart eller være selforklarende.</p>


</div>

<div class="contentblock"></div>


<div id="sponsor">

<h2>Sponsorer</h2>
<? insert_image("sponsor/logos/marin.png", "", "sponsor.php?id=marin", "logoleft", "Safe Marin og Frøysland", ""); ?>
<? insert_image("sponsor/logos/song.png", "", "sponsor.php?id=song", "logoleft", "Song Networks", ""); ?>
<? insert_image("sponsor/logos/tommersto.png", "", "sponsor.php?id=tommersto", "logoleft", "ICA Sparmat Tømmerstø", ""); ?>
<? insert_image("sponsor/logos/idmusikk.png", "", "sponsor.php?id=idmusikk", "logoleft", "ID Musikk A/S", ""); ?>
<? insert_image("sponsor/logos/rio.png", "", "sponsor.php?id=rio", "logoleft", "Rio Pizza på Tømmerstø brygge", ""); ?>
<? insert_image("sponsor/logos/snogg.png", "", "sponsor.php?id=snogg", "logoleft", "Snøgg", ""); ?>
<? insert_image("sponsor/logos/jkmek.png", "", "sponsor.php?id=jkmek", "logoleft", "Jens Knutsen mek. verksted", ""); ?>
<h2><a href="sponsor.php?id=galeas">Galeas</a></h2>
<div class="contentblock"></div>
</div>



</div>


<?php include("right.php"); ?>

</div>




</body>
</html>
