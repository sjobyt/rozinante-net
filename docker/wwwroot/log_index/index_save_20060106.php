<?php
include("functions.php");
include("php_functions/letter_data.php");
include("php_functions/report_functions.php");
$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
$style['frontpage'] = true;
$style['letters'] = true;
print_htmlheader("Jorda rundt med Rozinante 2003-200X", $style, ""); ?>

<body>




<?php $selected = 1; include('bar.php'); ?>

<div id="wrap">

<div id="article">




<div id="articlecontent">


<div class="lefttab">

<h1>Reisebrev fra Auckland Islands</h1>


<? insert_image("graphics/forside20060103_small.jpg", "Til ankers i Waterfall Inlet, Auckland Island.",
"graphics/forside20060103.jpg", "picright", "", ""); ?>


<p>Staale har sendt reisebrev med mange bilder fra �ya <a href="http://en.wikipedia.org/wiki/Auckland_Islands">Auckland Island</a>.
Her har det skjedd mye forskjellig som du kan lese i <a href="letters.php?read=0034_auckland.xml">reisebrevet</a>.</p>
<p><a href="letters.php?read=0035_auckland.xml">Del 2</a> av reisebrevet er ogs� publisert n�</p>
<p>Husk ogs� � lese <a href="report.php">reiserapporter</a>.</p>

<p><b>Webmaster, 3. januar</b></p>

</div>

<div class="righttab">

<h2>Film fra Cape Town til Hobart</h2>

<? insert_image("graphics/video.jpg", "",
"public/DVKRSMPEG1VCD.mpg", "picright", "", ""); ?>

<p>Jeg ble til slutt ferdig med filmen fra Cape Town til Hobart, men den slutter litt raskt fordi jeg ble aldri helt ferdig med den. Filmen
er i MPEG1-format og er p� ca. 170 MB. Mer film skal jeg nok f� laget p� resten av turen.</p>
<p><b>Staale, 29. desember</b></p>
<p><a href="public/DVKRSMPEG1VCD.mpg">Last ned film</a></p>

</div>

<div class="horizline"></div>
<? insert_image("graphics/forside20051225_small.jpg", "P� vei over Tasman Sea; mye v�r og mye b�lger. <br/>25 des. kl. 08:30",
"graphics/forside20051225.jpg", "picright", "", ""); ?>


<h2>Rozinante p� vei til New Zealand</h2>

<p>Rozinante og er n� p� vei mot syd �ya av New Zealand. Vi forlot Hobart,
21. desember kl. 23 norsk tid. Vi er n� p� vei ut i Tasman Sea, og det
meste ser greit ut. I skrivende stund har vi akkurat lagt bak oss Tasman
Island som er Australias syd�stligste punkt og det betyr at nok et
kontinent er passert. Daglige oppdateringer kommer etter hvert. En av de
siste tingene som ble gjort var � sende en film av turen fra Cape Town
til Hobart pr. "snailmail" til Norge. N�r noen f�r denne vil den bli lagt
ut.</p>
<p>God Jul!</p>
<p><b>Staale, 22. desember</b></p>

<p><b>Les <a href="report.php">reiserapporter</a> for siste nytt!</b></p>


<p><a href="public/tvsor.wmv">Reportasje</a> som gikk p� TVS�r og TVNorge
i
juni. (Kvalitet er s� som s�).</p>

<div class="horizline"></div>





<div class="contentblock"></div>
<div class="lefttab">
<h2>Fotogalleri</h2>
<p>Et nytt fotogalleri er lagt ut. Oppdateringer vil komme fortl�pende de
n�rmeste ukene. S� langt inneholder galleriet ca. 350 bilder fra
Forbredelser i 2003 til Brazil i 2004. Noen av bildene er
publisert tidligere p� Rozinante.net, men mesteparten er nye
bilder. Galleriet finner du under "<a href="main.php">Fotogalleri</a>" i
menyen. Noen nye bilder er lagt til 1. november. Flere bilder kommer.</p>
</div>


<div class="righttab">

<?php insert_image("graphics/route_ills.jpg", "", "", "picright", "", "") ?>

<h2>Alene rundt Antarktis</h2>
<p>St�le og Rozinante fortsetter ferden fra Hobart, Tasmania
videre til s�renden av New Zeland og s� til Kapp Horn. Turen g�r
deretter over S�r-Atlanteren og til Cape Town for andre gang.
Rozinante og St�le har da seilt rundt Antarktis. Forventet
annkomst Cape Town er i mars 2006.</p>
</div>



<div class="contentblock"></div>

<h2>Nyeste reisebrev</h2>
<?php



$dirs = make_letter_list();

$dir_no = 0;

$data = read_letter($dirs[$dir_no]);

$info = $data[1];
$doc_files = $data[2];
$doc_titles = $data[3];
$total_docs = count($doc_files);

print("<div class=\"header\">\n");

print("<div class=\"lefttab\">\n");
    printf("<div class=\"heading\">\n<h2>%s<br/><span class=\"date\">%s</span></h2>\n</div>\n", $info[0], strftime("publisert: %a %d %B %H:%M", $data[0]));
    print("<table>\n");
    printf("<tr><th>Hvor:</th><td>%s</td></tr>\n", $info[1]);
    printf("<tr><th>N�r:</th><td>%s</td></tr>\n", strftime("%a %d %B %H:%M", strtotime($info[2])));
    printf("<tr><th>Filer:</th><td>%s</td></tr>\n", $total_docs);
    printf("<tr><th>St�rrelse:</th><td>%s</td></tr>\n", size_conv($info[3]));
    print("</table>\n");

    print("</div>");
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
<h2>Shiptrack</h2>
<p>Med tjenesten Shiptrack kan du se hvor rozinante befinner seg med
daglige oppdateringer om posisjon, fart og kurs. (I den senere tid har
imidlertid denne tjenesten vist seg � v�re up�litelig/treg).</p>
<p>Det finnes to forskjellige shiptrack-sider og den ene har to utgaver
(tre forskjellige alts�). Det er opp til den enkelte � finne ut hvilken av
de tre som er mest oppdatert. Den <a
href="http://www.shiptrak.org/index.cgi?x=&amp;y=&amp;crop_size=150&amp;callsign=LA7GZ&amp;image_scale=fit">nye
utgaven av shiptrack (www.shiptrak.org)</a> ser ut til � v�re litt ustabil. Den gamle utgaven finner du p� <a
href="http://shiptrak.regex.ca/image.cgi?x=&amp;y=&amp;crop_size=150&amp;callsign=LA7GZ&amp;image_scale=auto">shiptrak.regex.ca</a>.</p>
<p>I tillegg finnes "YOTREPS" som for det meste viser riktig. YOTREPS finner du p� <a
href="http://www.pangolin.co.nz/yotreps/index.php">http://www.pangolin.co.nz/yotreps/index.php</a>. G� direkte til <a
href="http://www.pangolin.co.nz/yotreps/tracker.php?ident=LA7GZ">Rozinantes data</a> p� YOTREPS.</p> </div>

<div class="righttab">
<h2>Generell informasjon</h2>
<p>Sommeren 2003 la tre gutter ut p� en ferd som skulle vare i et �r og ruta var melkeruta tur/retur karibien. Dette har utviklet seg til � bli en jordomseiling fra vest mot �st alene. Ferden gjennom sydishavet startet fra Cape Town i begynnelsen av februar 2005, og Rozinante vil tilbringe den sydlighalvkules vinter p� New Zealand f�r ferden fortsetter over stillehavet rundt Kapp Horn i november '05/Januar '06 f�r sirkelen sluttes i Cape Town i mars 2006. Se <a href="ruteplanen2005.jpg">utseilt og planlagt rute</a>.</p>
</div>

<div class="horizline"></div>

<div class="lefttab">
<h2>Hvordan du finner fram p� sida</h2>
<p>Siden dette prosjektet har vart en god stund og har endret seg drastisk undeveis, er det kanskje p� sin plass med aldri s� lite informasjon om hvor du finner ting. Sikkert til glede
for nye lesere som kanskje finner nettstedet uoversiktlig til � begynne med.</p>
<p>N�r Rozinante er under seil  er <a href="report.php">reiserapporter</a>
stedet du vil finne
oppdateringer. Oppdateringer kommer nesten daglig fra Rozinante og Staale. Oppdateringene
sendes via kortb�lgeradio og med den begrensede kapasiteten det gir, vil det som regel bare v�re tekst.</p>
<p>Ved st�rre "begivenheter" og mulighet for st�rre oppdateringer i land, benyttes <a href="letters.php">reisebrev</a>. Her er det gjerne mye bilder sammen med tekst.</p>
<p>N�r det gjelder eldre nyheter, finner du det under <a href="rozinante_log.php">"Eldre nyheter"</a> oppe til h�yre p� menyen. Her finner du lesestoff helt fra
prosjektets begynnelse fram til den f�rste seilasen fra Kristiansand.
Etter det er det reisebrevene som gjelder. Kan ogs� bemerke at "Eldre
nyheter" og "Reisebrev" overlapper noe.</p>
<p>Nyheter som nettstedets drift, finner du under <a href="news.php">Administrative nyheter</a>. Disse skrives av webmaster hvis det skulle v�re noe viktig ang. drifting av sidene.</p>
<p>Ellers er det bare trykke p� linkene i menyen s� vil det meste st� forklart eller v�re selforklarende.</p>
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

</div>

<div class="contentblock"></div>


<div id="sponsor">

<h2>Sponsorer</h2>
<? insert_image("sponsor/logos/marin.png", "", "sponsor.php?id=marin", "logoleft", "Safe Marin og Fr�ysland", ""); ?>
<? insert_image("sponsor/logos/song.png", "", "sponsor.php?id=song", "logoleft", "Song Networks", ""); ?>
<? insert_image("sponsor/logos/tommersto.png", "", "sponsor.php?id=tommersto", "logoleft", "ICA Sparmat T�mmerst�", ""); ?>
<? insert_image("sponsor/logos/idmusikk.png", "", "sponsor.php?id=idmusikk", "logoleft", "ID Musikk A/S", ""); ?>
<? insert_image("sponsor/logos/rio.png", "", "sponsor.php?id=rio", "logoleft", "Rio Pizza p� T�mmerst� brygge", ""); ?>
<? insert_image("sponsor/logos/snogg.png", "", "sponsor.php?id=snogg", "logoleft", "Sn�gg", ""); ?>
<? insert_image("sponsor/logos/jkmek.png", "", "sponsor.php?id=jkmek", "logoleft", "Jens Knutsen mek. verksted", ""); ?>
<h2><a href="sponsor.php?id=galeas">Galeas</a></h2>
<div class="contentblock"></div>
</div>



</div>


<?php include("right.php"); ?>

</div>




</body>
</html>
