<?php


function parse_stats($filename) {

    $fp = fopen($filename, "r");
    $line = trim(fgets($fp, 4096));



    while(!feof($fp)) {

		$line = trim(fgets($fp, 4096));

		$item = explode(": ", $line, 2);


		switch($item[0]) {
		    case "DATE":
			// $tree['date'] = parse_date($item[1]);
			break;
		    case "LATITUDE":
			$fields = explode(" ", $item[1]);
			$tree['latitude'] = $fields[0] . "° " . $fields[1] . "' " . $fields[2];
			break;
		    case "LONGITUDE":
			$fields = explode(" ", $item[1]);
			$tree['longitude'] = $fields[0] . "° " . $fields[1] . "' " . $fields[2];
			break;
		    case "COG":
			$tree['cog'] = $item[1] . " °";
			break;
		    case "BTW":
			$tree['btw'] = $item[1] . " °";
			break;
		    case "SOG":
			$tree['sog'] = $item[1] . " kts";
			break;
		    case "ETA":
			// $tree['eta'] = parse_date($item[1]);
			break;
		    case "DTG":
			$tree['dtg'] = $item[1] . " nm";
			break;
		    case "DMG":
			$tree['dmg'] = $item[1] . " nm";
			break;
		    case "LOG":
			$tree['log'] = $item[1] . " nm";
			break;
		    case "24N":
			$tree['24n'] = $item[1] . " nm";
			break;
		    case "AVG":
			$tree['avg'] = $item[1] . " kts";
			break;
		}
	}

    return $tree;


}

function parse_stretch($filename) {
    $fp = fopen($filename, "r");

	$line = trim(fgets($fp, 4096));
	$section = substr ($line, 1 , strlen($line) - 2);

    while(!feof($fp)) {

	$line = trim(fgets($fp, 4096));

	if(ereg("^\[", $line)) {
	    $section = substr ($line, 1 , strlen($line) - 2);
	} elseif (ereg(":", $line)) {
	    list($item,$data) = split(":", $line);
	    $tree[$section][$item] = $data;
	}

    }

    fclose($fp);

    return $tree;
}

function parse_date($text_date) {
    return(strftime("%d %b kl. %H:%M",strtotime($text_date)));
}


function print_navdata($report) {

setlocale ( LC_TIME, "no_NO");
$source = parse_stats("news/reports/data/" . $report . "/nav.txt");

print("<div class=\"statsbox\">");
print("<div class=\"heading\">");
printf("<h2>Navigasjon - %s</h2>", $source['date']);
print("</div>");
print("<div class=\"lefttab\">");
print("<table class=\"navdata\">");

printf("<tr><th>Posisjon</th><td><span class=\"position\">%s<br/>%s</span></td></tr>", $source['latitude'], $source['longitude']);

print("</table>");




while($item = each($source)) {
    if(strlen($item[0]) == 3) {
		$navacro[strtoupper($item[0])] = $item[1];
    }
}

$elements = count($navacro);
$first_table = floor($each_table = $elements / 2);

$item_no = 0;


if(is_array($navacro)) {

	print("<div class=\"content\">");
	print("<div class=\"lefttab\">");
	print("<table class=\"navdata\">");


	while($item_no <= $first_table) {
 		$item = each($navacro);
	    printf("<tr><th>%s</th><td>%s</td></tr>", $item[0], $item[1]);
	    $item_no++;
	}

	print("</table>");
	print("</div>");


	print("<div class=\"righttab\">");
	print("<table class=\"navdata\">");

while($item = each($navacro)) {
    printf("<tr><th>%s</th><td>%s</td></tr>", $item[0], $item[1]);
}


print("</table>");
print("</div>");
print("<div class=\"contentblock\"></div>");
print("</div>");

}
print("</div>");

print("<div class=\"righttab\">");


print("</div>");



print("<div class=\"contentblock\"></div>");

print("</div>");

}


function check_report($report) {


    if(is_file("news/reports/data/" . $report . "/en_msg.txt")) {
		$returnd[en_msg] = true;
    }

    if(is_file("news/reports/data/" . $report . "/no_msg.txt")) {
		$returnd[no_msg] = true;
    }

    if(is_file("news/reports/data/" . $report . "/nav.txt")) {
		$returnd[nav] = true;
    }

    if(is_file("news/reports/data/" . $report . "/file_desc.txt")) {
		$returnd[file_desc] = true;
    }



    return $returnd;
}

?>