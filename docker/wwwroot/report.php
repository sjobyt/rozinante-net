<?php
include("php_functions/xml_parse.php");
include("functions.php");
include("php_functions/report_functions.php");
$style['standard'] = true;
$style['report'] = true;
$style['table'] = true;

print_htmlheader("Rapporter fra Rozinante", $style, "");
?>

<body>

<?php
$selected = 3;
include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">




<?php
setlocale ( LC_TIME, "no_NO");

$report = $_GET[open];


if($_GET[arch] == "1") {
    $report_base_real = "news/reports/data1/";
    $report_base = $report_base_real . $report;
    $archive = "arch=1&";
} else {
    $report_base_real = "news/reports/data/";
    $report_base = $report_base_real . $report;
}


if($_GET[open]) {



if(is_dir($report_base)) {


	$fp = fopen($report_base . "/received", "r");
	$line = fgets($fp, 20);
	fclose($fp);

	$date_time = strftime("%d %b kl. %H:%M", $line);

    printf("<h1>Rapport - %s</h1>", $date_time);

    $returnd = check_report($report, $report_base);
    print("\n\n\n\n");
	if($returnd[nav]) {
		print_navdata($_GET[open], $report_base);
    }

	if($returnd[en_msg]) {
	    $fp = fopen($report_base . "/en_msg.txt", "r");
 	  	$message =  htmlspecialchars (fread($fp, filesize($report_base . "/en_msg.txt")));
		$message = str_replace(chr(10), "<br/>", $message);
  		print("<div class=\"reportbox\">\n");
	    print("<div class=\"title\"><h2>Engelsk rapport</h2></div>\n");
		print("<div class=\"text\">\n");
		print("<code>\n");
	    print($message);
   		print("</code>\n");
	    print("</div>\n");
	    print("</div>\n");
	}

	if($returnd[no_msg]) {
	    $fp = fopen($report_base . "/no_msg.txt", "r");
 	  	$message =  htmlspecialchars (fread($fp, filesize($report_base . "/no_msg.txt")));
		$message = str_replace(chr(10), "<br/>", $message);
  		print("<div class=\"reportbox\">\n");
	    print("<div class=\"title\"><h2>Norsk rapport</h2></div>\n");
		print("<div class=\"text\">\n");
		print("<code>\n");
	    print($message);
  		print("</code>\n");
	    print("</div>\n");
	    print("</div>\n");
	}




if(is_dir($report_base . "/files")) {


  	print("<h2 class=\"undertitle\">Vedlegg</h2>");


	if(is_file($report_base . "/file_desc.txt")) {
		$fp = fopen($report_base . "/file_desc.txt", "r");

		while(!feof($fp)) {

			$line = fgets($fp, 4096);
			$item = explode(" ", $line, 2);
			$row[$item[0]] = $item[1];

		}

		fclose($fp);

	}

	print("<ul>");

	$directory = opendir($report_base . "/files");

	while ($file = readdir($directory)) {

		if(!($file == "." || $file == "..")) {
		    if($row[$file] == "") { $spacer = ""; } else { $spacer = " - "; }
		    printf("<li><a href=\"%s\">%s</a>%s%s</li>", $report_base . "/files/" . $file, $file, $spacer, $row[$file]);
		}

    }
    print("</ul>");
}


}

} else {




print("<h1>Rapporter fra Rozinante</h1>");

print("<ul>");
print("<li><a href=\"report.php\">Nyeste rapporter</a></li>");
print("<li><a href=\"report.php?arch=1\">Rapportarkiv</a></li>");
print("</ul>");


print("<p>Forklaring på noen av navigasjonstermene:</p>");
print("<ul>
<li><b>COG:</b> Kurs over grunnen. Dvs. vinkelen på den aksen båten beveger seg langs.</li>
<li><b>BTW:</b> Kurslinje som fører til målet. Kan avvike fra COG f.eks. pga. utnyttelse av geografisk betingede passatvinder.</li>
<li><b>SOG:</b> Fart over grunnen. Geografisk forflyttning, ikke farten gjennom vannet.</li>
<li><b>AVG:</b> Gjenommsnittlig fart det siste døgnet.</li>
<li><b>TTG:</b> Beregnet tid igjen før målet er nådd.</li>
<li><b>DMG:</b> Tilbakelagt distanse.</li>
<li><b>DTG:</b> Distanse igjen til målet.</li>
<li><b>24N:</b> Tilbakelagt distanse de siste 24 timene. (nautiske mil pr. døgn)</li>
<li><b>RAC:</b> Radiokontakter det siste døgnet.</li>
<li><b>SFC:</b> Andre båter som er sett det siste døgnet.</li>
<li><b>ATH:</b> Utgiver av data.</li>
</ul>
");


$directory = opendir($report_base_real);
$pos = 0;

while (false !== ($file = readdir($directory))) {

    if(!($file == "." || $file == "..")) {
	$report_names[$pos] = $file;
	$pos++;
    }



}

if($report_names) {
	asort($report_names);
}

if($_GET[arch]) {
    print("<h2>Rapportarkiv</h2>");
} else {
    print("<h2>Nyeste rapporter</h2>");
}
print("<table class=\"streamline\">");
print("<tr><th>ID</th><th>Sendt</th><th>Statistikk</th><th>Engelsk</th><th>Norsk</th><th>Vedlegg</th></tr>");

if($pos > 0) {

	reset($report_names);

	while ($report = current($report_names)) {

	$file_path = $report_base_real . $report;


	$fp = fopen($file_path . "/received", "r");
	$line = fgets($fp, 20);
	fclose($fp);

	$date_time = strftime("%d %b kl. %H:%M", $line);
	$link = "report.php?" . $archive . "open=" . $report;

	$nav = $no_msg = $en_msg = $att = "";

	if(is_file($file_path . "/nav.txt")) {
		$nav = "X";
	}
	if(is_file($file_path . "/no_msg.txt")) {
		$no_msg = "X";
	}
	if(is_file($file_path . "/en_msg.txt")) {
		$en_msg = "X";
	}
	if(is_dir($file_path . "/files")) {
		$att = "X";
	}
	printf("<tr><td><a href=\"%s\">%s</a></td><td>%s</td><td>%s<td>%s</td><td>%s</td><td>%s</td></tr>", $link, $report, $date_time, $nav, $en_msg, $no_msg, $att);
	    next($report_names);
	}

}

print("</table>");


}
?>







</div>

</div>


<?php include("right.php"); ?>

</div>

</body>


</html>


