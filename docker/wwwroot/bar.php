<div id="bar">

<div id="report">
<?php

setlocale(LC_TIME, "no_NO");

$directory = opendir("news/reports/data");
$pos = 0;

while (false !== ($file = readdir($directory))) {
	if($file != "") {
		$last_file = $file;
	}
}
closedir($directory);

$fp = fopen("news/reports/data/" . $last_file . "/received", 'r');
$time = fread($fp, 4096);
fclose($fp);
$rel_rap = rel_time($time);

$factor = time() - $time;
if($factor > 144000) { $factor = 144000; }

$ratio = dechex(floor(95 * $factor / 144000));

if(strlen($ratio) == 1) { $ratio = "0" . $ratio ; }

$color = "#" . $ratio . $ratio . $ratio;

if($factor < 30000) { $extra = " font-weight: bold;"; }


printf("<p style=\"color: %s;%s\">Siste rapport <a href=\"report.php?open=%s\">%s</a> - %s</p>", $color, $extra, $last_file, $last_file, $rel_rap);


?>

</div>

<div class="graphics">

<div id="tabmenu">


<ul>
<?php


$items = array('Hovedside','Reisebrev','Reiserapporter','Om nettstedet');
$links = array('index.php','letters.php','report.php','om.php');

$total = count($items);

for ($no = 0; $no < $total; $no++) {

    if ($selected == $no + 1) {
        printf("<li><a href=\"%s\" class=\"current\">%s</a></li>\n", $links[$no], $items[$no]);
    } else {
        printf("<li><a href=\"%s\">%s</a></li>\n", $links[$no], $items[$no]);
    }
}

print("<li><a href=\"info_en.html\" class=\"noborder\"><img id=\"eng\" alt=\"Infopage in English\" src=\"graphics/eng.png\"/></a></li>\n");

?>
</ul>
</div>



</div>

<div id="gridmap">


<?php


if(!($fp = fopen("news/positions/positions.txt", "r"))) {
	die("Unable to load positions.");
}

$line = fgets($fp, 4096);


$main_parts = explode("/", $line);


function rel_time($time) {

	$current_date = strftime("%H %M %S %m %d %Y", time());
	$t_split = explode(" ", $current_date);
	$midnight = mktime(0, 0, 0, $t_split[3], $t_split[4], $t_split[5]);


	$day = ($midnight - $time) / 86400;
	$day++;
	$day = floor($day);

	if($day <= 0) {
    		$rel_string = "i dag kl. ";
	} elseif($day == 1) {
    		$rel_string = "i går kl. ";
	} elseif($day >= 1 && $day <= 5) {
    		$rel_string = strftime("%A kl. ", $midnight - 86400 * $day);
	}

	if($day > 5) {
    		$rel_string = strftime("%d.%m.%Y %H:%M", $time);
	} else {
    		$rel_string .= strftime("%H:%M", $time);
	}

	return $rel_string;

}

$pos_text_y = $main_parts[1];
$pos_text_x = $main_parts[2];
$rel_string = rel_time($main_parts[0]);


printf("<div id=\"position\">\n<table>\n<caption>Siste posisjon - <a
href=\"map.php\">vis i kart</a></caption>\n");
printf("<tr><th>Når:</th><td>%s</td><th>Fart:</th><td>%s knop</td></tr>\n", $rel_string, $main_parts[3]);
printf("<tr><th rowspan=\"2\">Posisjon:</th><td>%s</td><th rowspan=\"2\">Kurs:</th><td rowspan=\"2\">%s °</td></tr>\n", $pos_text_y,$main_parts[4]);
printf("<tr><td>%s</td></tr>", $pos_text_x);
print("</table>\n</div>");

?>


</div>


</div>
