<?php

function print_entry($time, $owner, $title, $body) {
    printf("<div class=\"entry\">\n");
    printf("<p class=\"title\">%s<br/></p>\n", base64_decode($title));
    printf("<p class=\"time\">%s av %s</p>\n", strftime("%Y-%m-%d kl. %H.%M", $time), $owner);

    printf("<p class=\"body\">%s</p>\n", base64_decode($body));
    printf("</div>\n\n");
}


function safehtml($text) {
    $text = stripslashes($text);
    $text = strip_tags($text, '<b><i><u>');
    $text = ereg_replace ("<a[^>]+href *= *([^ ]+)[^>]*>", "<a href=\\1>", $text);
    $text = ereg_replace ("<([b|i|u])[^>]*>", "<\\1>", $text);
    return $text;
}


function cleantext($text_to_clean) {
    $trans = array_flip(get_html_translation_table(HTML_ENTITIES));
    //strip nonbreaking space, strip php tags, strip html tags, convert html entites, strip extra white space
    $search_clean = array("%&nbsp;%i", "%<\?.*\?>%Usi", "%<[\/]*[^<>]*>%Usi", "%(\&[a-zA-Z0-9\#]+;)%es", "%\s+%");
    $replace_clean = array(" ", "", "", "strtr('\\1',\$trans)", " ");
    $clean = preg_replace($search_clean, $replace_clean, $text_to_clean);
    return $clean;

}

function print_threadview($messages, $thread_offset, $line_offset, $do_mark) {


    print "<ul>\n";

    foreach ($messages as $msg) {
	$arr = explode(":", $msg);

	$ftime =  $arr[1];
	$owner = $arr[2];
	$ftitle = $arr[3];
	$fbody = $arr[4];

	$title = base64_decode($ftitle);
	$time = strftime("%Y-%m-%d kl. %H.%M %Z", $ftime);

	$linedata = each ($messages);
	$line_number = $linedata[0];
	$ref = "show.php?id=" . ($line_number + $line_offset + 1);

	if($arr[0] > $thread_offset) {

            printf("<ul>\n");
    	    printf("<li><a href=\"%s\">%s</a> av <b>%s</b> - %s</li>\n", $ref, $title, $owner, $time);

	} elseif($arr[0] == $thread_offset) {

            if ($do_mark) {
        	printf("<li class=\"grey\">%s av <b>%s</b> - %s</li>\n", $title, $owner, $time);
                $do_mark = "";
            } else {
        	printf("<li><a href=\"%s\">%s</a> av <b>%s</b> - %s</li>\n", $ref, $title, $owner, $time);
            }

	} elseif($arr[0] < $thread_offset) {

            for ($num = $thread_offset; $num > $arr[0]; $num--) {
		printf("</ul>\n");
	    }

        printf("<li><a href=\"%s\">%s</a> av <b>%s</b> - %s</li>\n", $ref, $title, $owner, $time);
	}

    $thread_offset = $arr[0];

    }

    for ($num = $thread_offset; $num > 0; $num--) {
	printf("</ul>\n");
    }

}
?>