
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

<body style="margin-bottom: 0px;">




<?php $selected = 1; include('bar.php'); ?>

<div id="wrap">

<div id="article">



<div id="articlecontent">



<div class="leftcol">


<div class="contentblock">

<h1>Snart tid for avreise</h1>
<p>Det er nå tid for å forlate Norge og vende hjem til Rozinante i
Australia. Dette
har jeg sett frem til lenge og det blir fint og være på farten igjen. </p>
<p>Det skulle egentlig bli lagt ut en film fra turen, men det har det ikke
blitt tid til. Men uansett så skal den være klar før jeg reiser fra Norge
om en måneds tid. </p>
</br>
<h2>Fotogalleri</h2>
Et nytt fotogalleri er lagt ut og oppdateringer vil komme fortløpende de
nærmeste ukene. Så langt inneholder galleriet ca. 350 bilder fra
Forbredelser i 2003 til Brazil i 2004. Noen av bildene er
publisert tidligere på Rozinante.net, men mesteparten er nye
bilder. Galleriet finnes <a
href="main.php">her.</a> eller ved å trykke på "Foto Galleri" under "Nytt"
i
menyen
til høyere.</p>

<h2>Reisen videre</h2>
<p>En oversikt over ferden videre vil bli lagt ut senere, men den er i
hovedsak fra Hobart, Tasmania til South Island, New Zeland og deretter til
Kapp Horn. </p>

<b>Staale, 27. September 2005.</b></p>

</div>


<div class="contentblock"></div>
<h2></h2>
<h2></h2>
<h2></h2>
<h2>Alene rundt Antarktis</h2>

<?php insert_image("graphics/route_ills.jpg", "", "", "picright", "", "") ?>

<p>En plan er god å ha. Dette prosjektet har hatt mange planer og nå kommer det en ny. Planen er å seile rundt Antarktis alene fra Cape Town til Cape Town med stopp i Australia, New Zealand og Syd-Amerika. Den "nye" "turen" starter nå i fra Cape Town. Planen videre er tilbringe den sydligehalvkules vinter 2005 på New Zealand. Kursen settes mot Kapp Horn i November 2005 og rundes i Januar 2006. Dette er en kul plan, så får vi se hvordan det går. Avreise fra Cape Town blir i begynnelsen av februar 2005. Les mer om <a href="letters.php?read=0030_planen2005.xml">neste etappe.</a></p>
<p><b>Staale, Kristianand 28. november 2004</b></p>


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
    printf("<tr><th>Når:</th><td>%s</td></tr>\n", strftime("%a %d %B %H:%M", strtotime($info[2])));
    printf("<tr><th>Filer:</th><td>%s</td></tr>\n", $total_docs);
    printf("<tr><th>Størrelse:</th><td>%s</td></tr>\n", size_conv($info[3]));
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

    print("<div class=\"contentblock\"></div>");
    print("</div>");


?>




<div class="contentblock">



</div>

</div>






<div class="contentblock">


<h1>Siste rapport</h1>

<div class="flatbox">



<?php
$reports = get_reportlist();
$length = count($reports);
$last = end($reports);


$fp = fopen("news/reports/data/" . $last . "/received", "r");
$line = fgets($fp, 20);
fclose($fp);

$date_time = strftime("%d %b kl. %H:%M", $line);
$link = "http://www.jalla.org/rozinante/report.php?open=" . $last;


printf("<div class=\"leftcol\"><h2 style=\"font-size: 10pt; margin: 3px;\">%s</h2></div>", $date_time);
printf("<div class=\"rightcol\" style=\"text-decoration: underline; text-align: right;\"><a href=\"%s\"><h2 style=\"font-size: 10pt; margin: 3px;\">les mer: %s</h2></a></div>", $link, $last);

$txt = "news/reports/data/" . $last . "/no_msg.txt";

if(file_exists($txt)) {
	$fp = fopen($txt, "r");
	$data = fread($fp, 300);
	fclose($fp);
}


$txt = "news/reports/data/" . $last . "/en_msg.txt";

if(file_exists($txt)) {
	$fp = fopen($txt, "r");
	$data = fread($fp, 300);
	fclose($fp);
}

printf("<p style=\"clear: both;\">%s...</p>", $data);

?>


</div>





<h2>Shiptrack</h2>

<p>Med tjenesten Shiptrack kan du se hvor rozinante befinner seg med daglige oppdateringer om posisjon, fart og kurs.</p>

<p>Det finnes to forskjellige shiptrack-sider og den ene har to utgaver (tre forskjellige altså). Det er opp til den enkelte å finne ut hvilken av de tre som er mest oppdatert. Den <a href="http://www.shiptrak.org/index.cgi?x=&y=&crop_size=150&callsign=LA7GZ&image_scale=fit">nye utgaven av shiptrack (www.shiptrak.org)</a> ser ut til å være litt ustabil. Den gamle utgaven finner du på <a href="http://shiptrak.regex.ca/image.cgi?x=&y=&crop_size=150&callsign=LA7GZ&image_scale=auto">shiptrak.regex.ca</a>.</p>

</p>I tillegg finnes "YOTREPS" som for det meste viser riktig. YOTREPS finner du på <a href="http://www.pangolin.co.nz/yotreps/index.php">http://www.pangolin.co.nz/yotreps/index.php</a>. Gå direkte til <a href="http://www.pangolin.co.nz/yotreps/tracker.php?ident=LA7GZ">Rozinantes data</a> på YOTREPS.</p>

<h2>Hvordan du finner fram på sida</h2>
<p>Siden dette prosjektet har vart en god stund og har endret seg drastisk undeveis, er det kanskje på sin plass med aldri så lite informasjon om hvor du finner ting. Sikkert til glede
for nye lesere som kanskje finner nettstedet uoversiktlig til å begynne med.</p>
<p>Når Rozinante er under seil  er <a href="report.php">reiserapporter</a>
stedet du vil finne
oppdateringer. Oppdateringer kommer nesten daglig fra Rozinante og Staale. Oppdateringene
sendes via kortbølgeradio og med den begrensede kapasiteten det gir, vil det som regel bare være tekst.</p>
<p>Ved større "begivenheter" og mulighet for større oppdateringer i land, benyttes <a href="letters.php">reisebrev</a>. Her er det gjerne mye bilder sammen med tekst. Siden det er lenge siden
Rozinante har vært i land er det lenge siden siste reisebrev ble sendt.</p>
<p>Når det gjelder eldre nyheter, finner du det under <a href="rozinante_log.php">"Eldre nyheter"</a> oppe til høyre på menyen. Her finner du lesestoff helt fra
prosjektets begynnelse fram til den første seilasen fra Kristiansand. Etter det er det reisebrevene som gjelder. Kan også bemerke at "Eldre nyheter" og reisebrev overlapper noe.</p>
<p>Nyheter som nettstedets drift, finner du under <a href="news.php">Administrative nyheter</a>. Disse skrives av webmaster hvis det skulle være noe viktig ang. drifting av sidene.</p>
<p>Ellers er det bare trykke på linkene i menyen så vil det meste stå forklart eller være selforklarende.</p>


<h2>Generell informasjon</h2>
<p>Sommeren 2003 la tre gutter ut på en ferd som skulle vare i et år og ruta var melkeruta tur/retur karibien. Dette har utviklet seg til å bli en jordomseiling fra vest mot øst alene. Ferden gjennom sydishavet startet fra Cape Town i begynnelsen av februar 2005, og Rozinante vil tilbringe den sydlighalvkules vinter på New Zealand før ferden fortsetter over stillehavet rundt Kapp Horn i november '05/Januar '06 før sirkelen sluttes i Cape Town i mars 2006. Se <a href="ruteplanen2005.jpg">utseilt og planlagt rute</a>.</p>

</div>
</div>



<div class="horizline"></div>



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







<div style="height: 40px;"></div>

</div>

<div class="newslink" style="margin: 0px; border-top: 3px solid #b2af85;">
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


