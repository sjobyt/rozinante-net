<?php
include('Mail/mimeDecode.php');

?>
<html>
<head>
<title>read-email.php</title>
</head>
<body>
<pre>
<?php

print("<h1>Load and parse messages</h1><br/>");


printf("<p>Current time  is: %s</p>", strftime("%d %b %y  %H:%M:%S %Z", time()));

$inbox = "/var/mail/zoretad";
$num = 0;
if(!$mbox = fopen($inbox, 'r')) {
	die("<span style=\"color: red\">Unrecoverable error.<span>");
}


printf("<b>Opening mailbox file: %s</b><br/>", $inbox);

do {


	if($test == "From ") {

		do {

			$messages[$num] .= $line;
			$line = fgets ($mbox, 4096);
	        	$test = substr($line, 0, 5);

			$source_mail .= $line;


			if($test == "Subje") {

				$subjects[$num] = trim(substr($line, 9));

			} elseif ($test == "Date:") {

				$dates[$num] = trim(substr($line, 6));

			}

		} while (($test != "From ") && !feof($mbox));

        	$num++;


	} else {



        	$line = fgets ($mbox, 4096);
	        $test = substr($line, 0, 5);

		$source_mail .= $line;


	}



} while(!feof($mbox));








$number = count($messages);


if($number > 0) {

	printf("<b>Found and loaded %s message(s) with the following subjects:</b><br/>", $number);
	$num = 0;
	print("<b>No.	Size		Date					Subject</b><br/>");
    	while ($subj = each($subjects)) {
		$msg = current($messages);
		next($messages);
		$size = strlen($msg);
		printf("%s 	%s B		%s		%s<br/>", $subj[0] + 1, $size, $dates[$num], $subj[1]);
		$num++;
	}

	print("<br/>");

	parse_msg($messages, $subjects);

} else {

	printf("<b>Found %s new messages.</b><br/>", $number);

}


$zoremail = "/home/rozinante/mbox";

printf("<p>Moving loaded messages to %s...</p>", $zoremail);
$mbox = fopen($zoremail, 'a');
fwrite($mbox, $source_mail);
fclose($mbox);

$mbox = fopen($inbox, 'w');
fwrite($mbox, "", 0);
fclose($mbox);




function parse_msg($messages, $subjects) {



while($subj = each($subjects)) {

	$msg = each($messages);


	printf("<span style=\"font-size: 16pt; font-weight: bold; color: green\">%s</span> ", $subj[0] + 1);
	$title = explode("_", $subj[1]);
	$title[1] = (integer) $title[1];

	while(strlen($title[1]) < 4) {
		$title[1] = "0" . $title[1];
	}



	if ($title[0] == "ROZUPDT") {


		$fp = fopen("news/reports/archive/" . $title[1], "w");
	        fwrite ($fp, $msg[1]);
		fclose($fp);


		$params['include_bodies'] = true;
		$params['decode_bodies'] = true;
		$params['decode_headers'] = true;
		$params['input'] = $msg[1];

		printf("<b>Discovered message: \"%s\"</b>, evaluated to be a report.\n", $subj[1]);
		print("Decoding...");
		$structure = Mail_mimeDecode::decode($params);
		print("done\n");




		$report_dir = "news/reports/data/" . $title[1];

		if (file_exists ($report_dir)) {

			print("<span style=\"color: red\">Report already exists. Overwriting/Updating files.</span></br>");

		} else {

			mkdir($report_dir, 0755);

		}


		$fp = fopen("news/reports/data/" . $title[1] . "/received", "w+");
	    	fwrite ($fp, strtotime($structure->headers['date']));
	    	fclose($fp);


		while($msg_part = current($structure->parts)) {


			$part_type = $msg_part->ctype_primary;
			$part_attach = explode(";", $msg_part->headers["content-disposition"]);
			$disp = $msg_part->headers["content-disposition"];

			if($part_attach[0] == "attachment") {

				ereg ("(.*)filename=\"(.*)\"(.*)", $disp, $regs);
		     		$att_filename = $regs[2];


				if ($att_filename == "no_msg.txt") {

					print "Found special file: no_msg.txt\n";

					$fp = fopen("news/reports/data/" . $title[1] . "/no_msg.txt", w);
				    	fwrite ($fp, $msg_part->body);
				    	fclose($fp);


				} elseif($att_filename == "en_msg.txt") {

					print "Found special file: en_msg.txt\n";

					$fp = fopen("news/reports/data/" . $title[1] . "/en_msg.txt", w);
				    	fwrite ($fp, $msg_part->body);
				    	fclose($fp);


				} elseif($att_filename == "nav.txt") {

					print "Found special file: nav.txt\n";

					$fp = fopen("news/reports/data/" . $title[1] . "/nav.txt", w);
				    	fwrite ($fp, $msg_part->body);
				    	fclose($fp);


				} elseif($att_filename == "file_desc.txt\n") {

					print "Found attachment description file: file_desc.txt\n";

					$fp = fopen("news/reports/data/" . $title[1] . "/file_desc.txt", w);
				   	fwrite ($fp, $msg_part->body);
				    	fclose($fp);


				} else {

					printf("<span>Discovered <b>additional</b> file:	%s</span>\n", $att_filename);

					if (!file_exists ($report_dir . "/files")) {

						print("<span style=\"color: red\">Making directory for additionial files.</span>");
						mkdir("news/reports/data/" . $title[1] . "/files", 0755);

					}

		      			$fp = fopen("news/reports/data/" . $title[1] . "/files/" . $att_filename, w);
					fwrite ($fp, $msg_part->body);
					fclose($fp);

				}

			} else {

				// printf("<h1>%s</h1>", $msg_part->body);
				// printf($part_attach[0]);

			}


			next($structure->parts);

		}

		print("\n");



	} elseif(($title[0] == "ROZPOS") || ($title[0] == "Message from Inmarsat-C Mobile")) {


		printf("<b>Discovered message: \"%s\"</b>, evaluated to be a position message.\n", $title[0]);



		$params['include_bodies'] = true;
		$params['decode_bodies'] = false;
		$params['decode_headers'] = false;
		$params['input'] = $msg[1];



		print("Decoding...");
		print("done\n");

		$structure = Mail_mimeDecode::decode($params);


		if($title[0] == "ROZPOS") {


			$line = trim($structure->body);

			$parts = explode(" ", $line);


			$text_date = $structure->headers[date];
			$unix = strtotime($text_date);



			$right_parts = explode(" ", $line);


			$y = $right_parts[2];
			$x = $right_parts[3];

			$y_pos = substr($y, 0, strlen($y) - 7);
			$y_pos .= "° " . substr($y, strlen($y) - 7, 6);
			$y_pos .= "' " . substr($y, strlen($y) - 1, 1);

			$x_pos = substr($x, 0, strlen($x) - 7);
			$x_pos .= "° " . substr($x, strlen($x) - 7, 6);
			$x_pos .= "' " . substr($x, strlen($x) - 1, 1);



			$new_entry = $unix . "/" . $x_pos . "/" . $y_pos . "///";


		} elseif($title[0] == "Message from Inmarsat-C Mobile") {


			$lines = explode("\n", $structure->body);


			while($line = each($lines)) {

				$pos_test = explode(" ", $line[1]);


				if($line[1] == "Maritime Mobile Position Report") {

					$loc = $lines[$line[0] + 2];
					$loc = explode(",", $loc);
					$loc = $loc[0];

				} elseif($pos_test[0] == "Position") {

					$pos = $line[1];
					$pos = explode(" ", $pos);
					$y_pos = $pos[4] . "° " . $pos[5] . " " . $pos[6];
					$y_pos = substr($y_pos, 0, strlen($y_pos) - 1);
					$x_pos = $pos[7] . "° " . $pos[8] . " " . $pos[9];

				} elseif($pos_test[0] == "Speed") {

					$dir = $line[1];
					$dir = explode(" ", $dir);
					$speed = $dir[2];
					$course = $dir[7];

				} elseif($pos_test[0] == "Time") {

					$time = $line[1];
					$time = explode(" ", $time);

					$unix = strtotime($time[4] . " " . $time[5] . " UTC");

					$date = explode("-", $time[4]);
					$clock = explode(":", $time[5]);

					$new_entry = $unix . "/" . $x_pos . "/" . $y_pos . "/" . $speed . "/" . $course . "/" . $loc;
				}

			}


		}



		if(is_numeric($unix)) {


			$posfile = "news/positions/positions.txt";
			$fp = fopen($posfile, "r");


			$fline = trim(fgets($fp, 4096));
			$parts = explode(" - ", $fline);



			if($unix > $parts[0]) {

			printf("<b>%s, Action: ADD NEWEST</b>\n", $posfile);
			$first_part = $new_entry . chr(10) .  $fline;

			} elseif($parts[0] == $unix) {

				printf("<b>%s, Action: UPDATING NEWEST POSITION ENTRY</b>\n", $posfile);
				$first_part = $new_entry;


			} else {


				do {

 					$first_part .= $fline . chr(10);
					$fline = trim(fgets($fp, 4096));
					$parts = explode("/", $fline);

				} while($parts[0] > $unix && !feof($fp));

				if($parts[0] == $unix) {

					printf("<b>%s, Action: UPDATING OLD POSITION ENTRY</b>\n", $posfile);
					$first_part .= $new_entry;

				} elseif($parts[0] < $unix) {

					printf("<b>%s, Action: INSERTING OLD POSITION ENTRY</b>\n", $posfile);
					$first_part .= $new_entry . chr(10) . $fline;
				}


			}



			while(!feof($fp)) {
				$first_part .= chr(10) . trim(fgets($fp, 4096));
			}

			fclose($fp);
			printf("%s\n\n", $new_entry);

			$fp = fopen($posfile, "w");
			fwrite ($fp, $first_part);
			fclose($fp);
			$first_part = "";


		} else {

			printf("<span style=\"color: red\">Could not find valid data in position message no. %s.</span>\nHere is the message body:\n
<div style=\"border: 1px solid red; padding: 4px;\">%s</div>\n\n", $subj[0] + 1, $structure->body);
		}


	} else {

		printf("<span style=\"color: red\">Ignoring message no. %s. Unknown subject: \"%s\". Not decoding message</span>.\n\n", $subj[0] + 1, $subj[1]);

	}

	$structure = "";
	$unix = "";

}



}



function monthtoint($month) {
	if(strcasecmp($month, "jan") == 0) {
    		return 1;
	} elseif(strcasecmp($month, "feb") == 0) {
    		return 2;
	} elseif(strcasecmp($month, "mar") == 0) {
    		return 3;
	} elseif(strcasecmp($month, "apr") == 0) {
    		return 4;
	} elseif(strcasecmp($month, "may") == 0) {
    		return 5;
	} elseif(strcasecmp($month, "jun") == 0) {
    		return 6;
	} elseif(strcasecmp($month, "jul") == 0) {
    		return 7;
	} elseif(strcasecmp($month, "aug") == 0) {
    		return 8;
	} elseif(strcasecmp($month, "sep") == 0) {
    		return 9;
	} elseif(strcasecmp($month, "oct") == 0) {
    		return 10;
	} elseif(strcasecmp($month, "nov") == 0) {
    		return 11;
	} elseif(strcasecmp($month, "dec") == 0) {
    		return 12;
	} else {
		return -1;
	}
}

include("rendermap.php");
include("renderzoommap.php");
?>

</pre>
</body>
</html>

