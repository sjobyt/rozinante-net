<?php


function parse_stats($filename) {

    $fp = fopen($filename, "r");


    while(!feof($fp)) {

		$line = trim(fgets($fp, 4096));


		if(ereg("^\[", $line)) {
	 	   $section = substr ($line, 1 , strlen($line) - 2);

		} elseif (ereg(":", $line)) {
		    list($item,$data) = split(": ", $line);

		    if($section == "META") {

		    	switch($item) {
				    case "DATE":
					$tree['meta']['date'] = parse_date($data);
					break;
				    case "LAT":
					$fields = explode(" ", $data);
					$tree['meta']['latitude'] = $fields[0] . "° " . $fields[1] . "' " . $fields[2];
					break;
				    case "LON":
					$fields = explode(" ", $data);
					$tree['meta']['longitude'] = $fields[0] . "° " . $fields[1] . "' " . $fields[2];
					break;
				    case "LOCATION":
					$tree['meta']['location'] = $data;
					break;
		    	}

		    } elseif($section == "NAV") {

		    	switch($item) {
				    case "COG":
					$tree['nav']['cog'] = $data . " °";
					break;
				    case "BTW":
					$tree['nav']['btw'] = $data . " °";
					break;
				    case "SOG":
					$tree['nav']['sog'] = $data . " kts";
					break;
				    case "ETA":
					$tree['eta'] = parse_date($data);
					break;
				    case "DTG":
					$tree['nav']['dtg'] = $data . " nm";
					break;
				    case "DMG":
					$tree['nav']['dmg'] = $data . " nm";
					break;
				    case "LOG":
					$tree['nav']['log'] = $data . " nm";
					break;
				    case "24N":
					$tree['nav']['24n'] = $data . " nm";
					break;
				    case "AVG":
					$tree['nav']['avg'] = $data . " kts";
					break;
				}
			} elseif($section == "WEATHER") {

		    	switch($item) {
				    case "RAINFALL":
					$tree['weather']['RAINFALL'] = $data;
					break;
				    case "WIND-D":
					$tree['weather']['WIND'] = $data;
					break;
				    case "WIND-S":
					$tree['weather']['WINDSPEED'] = $data . " kts";
					break;
					case "CLOUD":
					$tree['weather']['CLOUD'] = $data . " %";
					break;
					case "BARO":
					$tree['weather']['BAROMETER'] = $data . " mb";
					break;
					case "AIRTEMP":
					$tree['weather']['AIRTEMP'] = $data . " °C";
					break;
					case "SEATEMP":
					$tree['weather']['SEATEMP'] = $data . " °C";
					break;
				}
			}

		}

    }

    fclose($fp);


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
    $parts = explode(" ", $text_date);
    $date = explode(".", $parts[0]);
    $clock = explode(":", $parts[1]);



    $unix = gmmktime ($clock[0], $clock[1], $clock[2], $date[1], $date[0], $date[2], 0);

    $timezone = substr($parts[2], 0, 3);

	$unix -= 3600 * $timezone;

    $string_time = strftime("%d %b kl. %H:%M", $unix);

    return $string_time;
}


function print_navdata($report, $report_base) {

setlocale ( LC_TIME, "no_NO");
$tree = parse_stats($report_base . "/nav.txt");
$source = $tree['nav'];
$weather = $tree['weather'];

print("<div class=\"statsbox\">\n");
print("<div class=\"heading\">\n");
printf("<h2>Stats - %s</h2>\n", $tree['meta']['date']);
print("</div>\n");
print("<div class=\"lefttab\">\n");
print("<table class=\"navdata\">\n");

printf("<tr><th>Position</th>\n<td><span class=\"position\">%s<br/>%s</span></td></tr>\n", $tree['meta']['latitude'], $tree['meta']['longitude']);
printf("<tr><th>Location</th>\n<td><span class=\"location\">%s</span></td></tr>", $tree['meta']['location']);


print("</table>");



if($source) {

	while($item = each($source)) {
		$navacro[strtoupper($item[0])] = $item[1];
	}


	$elements = count($navacro);
	$first_table = floor($each_table = $elements / 2);

	$item_no = 0;


	print("<div class=\"content\">\n");
	print("<div class=\"lefttab\">\n");
	print("<table class=\"navdata\">\n");


	while($item_no <= $first_table) {
 		$item = each($navacro);
	    printf("<tr><th>%s</th><td>%s</td></tr>\n", $item[0], $item[1]);
	    $item_no++;
	}

	print("</table>\n");
	print("</div>\n");


	print("<div class=\"righttab\">\n");
	print("<table class=\"navdata\">\n");

	while($item = each($navacro)) {
 	   printf("<tr><th>%s</th><td>%s</td></tr>\n", $item[0], $item[1]);
	}


	print("</table>\n");
	print("</div>\n");
	print("<div class=\"contentblock\"></div>\n");
	print("</div>\n");

}

print("</div>\n");

print("<div class=\"righttab\">\n");





if($weather) {

	print("<table class=\"navdata\">\n");
	print("<caption>Weather</caption>");

	while($item = each($weather)) {
		$weather_list[strtoupper($item[0])] = $item[1];
		printf("<tr><th>%s</th><td>%s</td></tr>\n", $item[0], $item[1]);
	}

	print("</table>\n");
} else {
	print("<p><b>No weather data</b></p>");
}




print("</div>\n");



print("<div class=\"contentblock\"></div>\n");

print("</div>\n");

}


function check_report($report, $report_base) {
    if(is_file($report_base . "/en_msg.txt")) {
		$returnd[en_msg] = true;
    }

    if(is_file($report_base . "/no_msg.txt")) {
		$returnd[no_msg] = true;
    }

    if(is_file($report_base . "/nav.txt")) {
		$returnd[nav] = true;
    }

    if(is_dir($report_base . "/files")) {
		$returnd[file_desc] = true;
    }



    return $returnd;
}


function get_reportlist($report_base_real) {

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

	return $report_names;

}
?>
