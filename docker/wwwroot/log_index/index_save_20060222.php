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






<h1>"Rozinante er på vei til de evige jaktmarker"</h1>


<p><b>For de som ikke er oppdaterte:</p></b>

<ul>
<li><a href="http://www.fedrelandsvennen.no/nyheter/article340651.ece">Fædrelandsvennen 1</a></li>
<li><a href="http://www.fedrelandsvennen.no/nyheter/article340725.ece">Fædrelandsvennen 2</a></li>
<li><a href="http://pub.tv2.no/nettavisen/friluftsliv/article560387.ece">TV2, Nettavisen</a></li>
<li><a href="http://www.aftenposten.no/nyheter/iriks/article1224276.ece">Aftenposten</a></li>
<li><a href="http://www.lun.com/modulos/catalogo/paginas/2006/02/22/LUCPRDI02LU2202.htm">www.lun.com</a></li>
<li><a href="http://www.latercera.cl/medio/articulo/0,0,3255_5666_189994330,00.html">www.latercera.cl</a></li>

</ul>

<? insert_image("graphics/auto-zoommap_small.png", "Aller siste posisjon fra Rozinante.",
"map.php", "picright", "", ""); ?>


<p><b>Tekst av <a href="ragnar.php">Ragnar</a>, tidligere
mannskap på Rozinante, 15. januar:</b></p>

<div class="reportbox">

<div class="title">
<p>Undertegnede har nå hatt en lengre samtale via satelittelefon med Staale, som befinner seg ombord på den polske lastebåten  «Masuren». Etter forholdene kunne han
nok ikke hatt det særlig mye bedre.</p>
</div>

<div class="text">
<p>Jeg fikk den første samtalen fra Staale i går kveld, mens han ennå var om bord i Rozinante. Han fortalte at roret var forsvunnet i havet, som var vanvittig opprørt.
Han hadde en vind på nærmere 50 knop, og han hadde kontaktet Hovedredningssentralen på Sola som skulle ta kontakt med sine kollegaer i Syd-Amerika. Rozinante seilte
akkurat der vinden førte henne, dvs. sydøstover med en fart på over to knop. Han fikk en værmelding av meg som fortalte at stormen skulle vare minst 48 timer til, og
han ba meg kontakte hurtigruten som har en båt de bruker til å frakte passasjerer mellom Antarktis og Argentina. Han håpet på at noen om bord der hadde noen kontakter i
Sydamerika som muligens kunne hjelpe han.</p>


<p>Vinden var som sagt kraftig, og bølgene var sikkert nærmere ti meter. Han vurderte situasjonen utover kvelden og fant ut at om han ikke ble hentet nå, ville han
havne langt øst for Kapp Horn. Uten ror i slikt vær er man rett og slett sjanseløs. Da tilbud om hjelp kom utpå natten, konkluderte han med at det eneste
fornuftige var å takke ja til tilbudet. Om han ikke hadde reist fra Rozinante, ville han rett og slett ikke kunnet gjøre annet enn å drive med vær og vind østover, og
det er ikke sikkert han hadde fått en ny mulighet til å bli reddet, eller kommet seg til land.



<p>Først var det en fiskebåt som prøvde seg, men de måtte gi opp. De klarte rett og slett ikke kjøre mot vinden. Deretter ble lastebåten satt på saken. De klarte å
lokalisere Rozinante, og på femte forsøk klarte Staale å få tak på en taustump de kastet til han. Han hadde redningsdrakten på og en liten sekk med blant annet kamera,
harddisker, videotaper og annet småpell som han fikk med seg. Han slo en løkke rundt livet, og da de to båtene var på hver sin bølgetopp i rimelig avstand til hverandre,
ropte han GO GO GO og hoppet mot det andre skipet. Han rakk ikke engang å treffe vannet før han var trukket om bord. I øyeblikket etter raste Rozinante inn i siden
på lastebåten. Mesanmasten knakk som en fyrstikk, og Rozinante traff skipssiden flere ganger før hun forsvant i mørket.</p>


<p>Staale ble hilst velkommen om bord og ble overrakt toppen av vindmåleren som sto i toppen av mesanen. Den havnet på lastebåtens dekk i sammenstøtet, og det er det
eneste han har igjen av Rozinante nå.</p>



<p>Så mens Rozinate seiler sin siste reis alene og skadeskutt, sitter altså Staale i god behold ombord i den polske båten. Han er etter forholdene fin i formen, og
hadde visst fått en øl å roe nervene på. Han ankommer San Antonio om fem dager, og reiser nok hjem til Norge så fort som mulig.</p>



<p>Han ba meg også hilse alle kjente og si at de kan slutte å bekymre seg nå, siden i alle fall en av de tre motorene om bord i lasteskipet virker ennå.</p>



<p>Drikk en øl og skål for Rozinante alle sammen, så får vi vente til Jordan kommer hjem og forteller resten selv.</p>



<p><b>Ragnar (15. januar)</b></p>

</div>
</div>


<?php
/*

<div class="righttab">

<h2>Følg Rozinante på kartet</h2>

<? insert_image("graphics/automap.jpg", "", "map.php", "picright", "", ""); ?>


<p>Undertegnede har ordnet et system som plotter posisjons -rapportene på
et kart over det aktuelle området som Rozinante befinner seg på.
Dette gjør det litt lettere å følge med på hvor båten faktisk befinner seg siden bare koordinater ikke sier folk flest noe særlig.</p>
<p>Trykk på kartet eller på <a href="map.php">vis i kart</a> oppe til høyre for å se hvor Rozinante er.</p>

<p>Legg gjerne igjen en hilsen i <a href="gbook.php">gjesteboken</a>!</p>
<p><b>Webmaster</b></p>

</div>

*/

?>

<div class="contentblock"></div>


<?php
/*
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
*/?>




<div class="horizline"></div>

<h2>Bilder sendt i sjøen etter Tasmania</h2>


<? insert_image("graphics/pacific/1_small.jpg", "Tasman Sea, 25. desember. Mye sjø.", "graphics/pacific/1.jpg",
"picleft", "", "200"); ?>
<? insert_image("graphics/pacific/2_small.jpg", "Til ankers i Waterfall Inlet, Auckland Island, 3. januar",
"graphics/pacific/2.jpg", "picleft", "", "200"); ?>
<? insert_image("graphics/pacific/3_small.jpg", "8. januar", "graphics/pacific/3.jpg", "picleft", "", "200"); ?>
<? insert_image("graphics/pacific/4_small.jpg", " 29. januar", "graphics/pacific/4.jpg", "picleft", "", "200"); ?>
<? insert_image("graphics/pacific/5_small.jpg", " 3. februar", "graphics/pacific/5.jpg", "picleft", "", "200"); ?>

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
<h2><a href="http://www.flyt.no/">Flyt</a></h2>
<div class="contentblock"></div>
</div>



</div>


<?php include("right.php"); ?>

</div>




</body>
</html>
