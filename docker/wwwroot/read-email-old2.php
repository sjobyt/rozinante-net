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

print("<h1>Load and parse messages (mail2web executive)</h1><br/>");


printf("<p>Current time  is: %s</p>", strftime("%d %b %y  %H:%M:%S %Z", time()));

$inbox = "/var/spool/mail/zoretad";
$num = 0;
$mbox = fopen($inbox, 'r');


printf("<b>Opening mailbox file: %s</b><br/>", $inbox);

do {


    if($test == "From ") {

	do {

	    $messages[$num] .= $line;
	    $line = fgets ($mbox, 4096);
            $test = substr($line, 0, 5);

	    if($test == "Subje") {
		$subjects[$num] = rtrim(substr($line, 9));
	    }

	} while (($test != "From ") && !feof($mbox));

        $num++;

    } else {

        $line = fgets ($mbox, 4096);
        $test = substr($line, 0, 5);


    }



} while(!feof($mbox));


fclose($mbox);



$number = count($messages);


if($number > 0) {

    printf("<b>Found and loaded %s message(s) with the following subjects:</b><br/>", $number);

    print("<b>No.	Size	Subject</b><br/>");
    while ($subj = each($subjects)) {
	    $msg = current($messages);
	    next($messages);
	    $size = strlen($msg);
		printf("%s 	%s B	%s<br/>", $subj[0] + 1, $size, $subj[1], 9);
    }
    print("<br/>");

	parse_msg($messages, $subjects);

} else {

    printf("<b>Found %s new messages.</b><br/>", $number);

}


// print("<p>Deleteing messages in mailbox...</p>");
// $mbox = fopen($inbox, w);
// fwrite($mbox, "", 0);
// fclose($mbox);



function parse_msg($messages, $subjects) {


while($subj = each($subjects)) {

    $title = explode("_", $subj[1]);
    $title[1] = (integer) $title[1];

	while(strlen($title[1]) < 4) {
		$title[1] = "0" . $title[1];
	}

    if ( ($title[0] == "ROZUPDT")) {



		$msg = each($messages);
		$fp = fopen("/opt3/home/rozinante/www/news/reports/archive/" . $title[1], "w");
	        fwrite ($fp, $msg[1]);
		fclose($fp);


		$params['include_bodies'] = true;
		$params['decode_bodies'] = true;
		$params['decode_headers'] = true;
		$params['input'] = $msg[1];


		printf("<b>Processing %s...</b>\n", $subj[1]);
		$structure = Mail_mimeDecode::decode($params);



		$report_dir = "/srv/www/htdocs/rozinante/news/reports/data/" . $title[1];

		if (file_exists ($report_dir)) {
			print("<span style=\"color: red\">Report already exists. Overwriting/Updating files.</span></br>");
			// mkdir($report_dir, 0755);
		} else {
			mkdir($report_dir, 0755);
		}


		$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/received", "w+");
	    fwrite ($fp, strtotime($structure->headers['date']));
	    fclose($fp);


		while($msg_part = current($structure->parts)) {


		    $part_type = $msg_part->ctype_primary;
			$part_attach = explode(";", $msg_part->headers["content-disposition"]);
			$disp = $msg_part->headers["content-disposition"];

			if($part_attach[0] == "attachment")
			{

				ereg ("(.*)filename=\"(.*)\"(.*)", $disp, $regs);
		     	$att_filename = $regs[2];


				if ($att_filename == "no_msg.txt") {

					print "Found special file: no_msg.txt\n";

					$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/no_msg.txt", w);
				    fwrite ($fp, $msg_part->body);
				    fclose($fp);


				} elseif($att_filename == "en_msg.txt") {

					print "Found special file: en_msg.txt\n";

					$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/en_msg.txt", w);
				    fwrite ($fp, $msg_part->body);
				    fclose($fp);


				} elseif($att_filename == "nav.txt") {

					print "Found special file: nav.txt\n";

					$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/nav.txt", w);
				    fwrite ($fp, $msg_part->body);
				    fclose($fp);


				} elseif($att_filename == "file_desc.txt\n") {

					print "Found attachment description file: file_desc.txt\n";

					$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/file_desc.txt", w);
				    fwrite ($fp, $msg_part->body);
				    fclose($fp);


				} else {

					printf("<span>Discovered <b>additional</b> file:	%s</span>\n", $att_filename);

					if (!file_exists ($report_dir . "/files")) {
						print("<span style=\"color: red\">Making directory for additionial files.</span>");
						mkdir("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/files", 0755);
					}

		      		$fp = fopen("/srv/www/htdocs/rozinante/news/reports/data/" . $title[1] . "/files/" . $att_filename, w);
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

	} elseif($title[0] == "ROZPOS") {

		printf("<span><b>Discovered position-message: \"%s\"</b></span>\n", $subj[1]);

		$msg = each($messages);


		$params['include_bodies'] = true;
		$params['decode_bodies'] = false;
		$params['decode_headers'] = false;
		$params['input'] = $msg[1];


		printf("<b>Processing %s...</b>\n", $subj[1]);
		$structure = Mail_mimeDecode::decode($params);


		$i = 0;
		$length = strlen($structure->body);

		do {
			$current = substr($structure->body, $i, 1);
			$i++;
			$line .= $current;
		} while ($current != chr(10) && $i < $length);


		$line = ltrim($line);

		$parts = explode(" ", $line);

		if($parts[0] == 425799920) {

			$text_date = $structure->headers[date];
			$unix = strtotime($text_date);

			printf("<h1>%s</h1>", $unix);
			print(strftime("%a %d %B %H:%M %Y", $unix));

			$fp = fopen("news/positions/positions.txt", "r");

			do {
				$fline = fgets($fp);
				$parts = explode(" - ", $fline);
				$newfile = $fline . chr(10);
				print_r($parts);
			} while($parts[0] <= unix && !feof($fp));




		} else {
			printf("<span style=\"red\">Incorrect Inmarsat C ID: %s. Ignoring position report</span>\n", $parts[0]);
		}

		print($body_test);
		print("<pre>");
		print_r($parts);
		print("</pre>");





	} else {
		printf("<span style=\"color: red\"><b>Ignoring message \"%s\" (reason: invalid subject)</b></span>\n", $subj[1]);
		$msg = each($messages);
	}

}

}


function monthtoint($month) {
	if($month == "Jan") {
    		return 1;
    	} elseif($month == "Feb") {
    		return 2;
    	} elseif($month == "Mar") {
    		return 3;
    	} elseif($month == "Apr") {
    		return 4;
    	} elseif($month == "May") {
    		return 5;
    	} elseif($month == "Jun") {
    		return 6;
    	} elseif($month == "Jul") {
    		return 7;
    	} elseif($month == "Aug") {
    		return 8;
    	} elseif($month == "Sep") {
    		return 9;
    	} elseif($month == "Oct") {
    		return 10;
    	} elseif($month == "Nov") {
    		return 11;
    	} elseif($month == "Dec") {
    		return 12;
	} else {
		return -1;
	}
}


?>

</pre>
</body>
</html>
