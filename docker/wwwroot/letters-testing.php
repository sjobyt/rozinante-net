<?php

$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
$style['table'] = true;
$style['letters'] = true;
require("functions.php");
print_htmlheader("Jorda rundt med Rozinante 2003-2006 ", $style, "");

?>

<body>




<?php
$selected = 2;
include('bar.php'); ?>

<div id="wrap">

<div id="article">



<div id="articlecontent">



<?php

$letters = "news/letters2/";
$letternum = 0;

if (($directory = opendir($letters))  && !($_GET['read'])) {

    while (false !== ($dir = readdir($directory))) {
        $dirs[$letternum] = $dir;
        $letternum++;
    }
    closedir($directory);

    print("<h1>Reisebrev</h1>");

    $letternum = 0;
    array_shift ($dirs);
    array_shift ($dirs);
    rsort($dirs);

    $dir_total = count($dirs);


    while($letternum < $dir_total) {


    	$index_file = $letters . $dirs[$letternum] . "/" . "index.txt";




	if (is_file($index_file)) {




	    $meta = false;
	    $pubtime = false;
	    $doc_count = -1;
	    $dir_size = 0;
	    $docs = false;
            $doc_file = false;
            $doc_title = false;
            $current_no = 0;


	    $letter_dir = $letters . $dirs[$letternum] . "/";

	    if ($dirname = opendir($letter_dir)) {

	        while (false !== ($file = readdir($dirname))) {

	            if(!($file == "." || $file == "..")) {
                        $dir_size +=  filesize($letter_dir . $file) / 1000 ;
                    }
	        }

	        closedir($dirname);
	        $dirname = false;



	        if($dir_size >= 1000) {
	            $dir_size = number_format($dir_size / 1000, 2, ',', ' ')  . " Mb";
	        } elseif ($dir_size >= 1) {
	            $dir_size = number_format($dir_size / 1, 0, ',', ' ')  . " kb";
	        } elseif ($dir_size < 1) {
	            $dir_size = number_format($dir_size * 1000, 0, ',', ' ')  . " byte";
	        }
	    }



            $color = "light";

	    $idx = fopen($index_file, "r");



	    while(!feof($idx)) {

                $line = fgets ($idx, 4067);
	    	$type = substr($line, 0, 5);


	if($type == "info:") {

  		    $meta = explode ("_", substr($line, 6), 4);
  		    setlocale ( LC_TIME, "no_NO");
     		    $pubtime = strftime("publisert: %d %B %H:%M", filemtime($index_file));

       		    $date = strftime("%a %d %B %H:%M", strtotime($meta[2]) );



		} elseif($type == "docu:") {

	    	   $doc_count++;
	    	   $docu = explode("_", substr($line, 6));
	    	   $doc_file[$doc_count] = $docu[0];
	    	   $doc_title[$doc_count] = rtrim ( $docu[1] , "\n");

	        }



	    }
	    fclose ($idx);

    	}




	print("<div class=\"header\">\n");
	print("<div class=\"lefttab\">\n");
	printf("<div class=\"heading\">\n<h2>%s<br/><span class=\"date\">%s</span></h2>\n</div>\n", $meta[0], $pubtime);
	print("<table class=\"header\">\n");
	printf("<tr><th>Hvor:</th><td>%s</td></tr>\n", $meta[1]);
	printf("<tr><th>Når:</th><td>%s</td></tr>\n", $date);
	print("</table>\n");
	print("<table class=\"header\">\n");
	printf("<tr><th>Tekster:</th><td>%s</td></tr>\n", $doc_count + 1);
	printf("<tr><th>Størrelse:</th><td>%s</td></tr>\n", $dir_size);
	print("</table>\n");

	$desc_filename = $letters . $dirs[$letternum] . "/" . "desc.txt";



	print("</div>\n");
	print("<div class=\"righttab\">\n");
	print("<table class=\"list\">\n");


	$elements = count($doc_file);

	while($current_no < $elements) {
	    if($color == "light") {
		$color = "dark";
	    } else {
		$color = "light";
	    }

	    printf("<tr><th class=\"%s\"><img src=\"graphics/article_icon_%s.png\" alt=\"Tekst\"/></th><td class=\"%s\"><a href=\"letters.php?read=%s\">%s</a></td></tr>\n", $color, $color, $color, $dirs[$letternum] . "_" . $doc_file[$current_no], $doc_title[$current_no]);

	    $current_no++;
	}

	print("</table>\n");
	print("</div>\n");


	if(is_readable ($desc_filename)) {

	    $desc_file = fopen($desc_filename, "r");

	    $first = false;
	    $description = false;

	    while(!feof($desc_file)) {

		$line = fgets ($desc_file, 4067);

		if($first == true) {
		    $description .= $line;
		    $first = false;
		} else {
		    $description .= $line . "<br/>";
		}

	    }

	    fclose($desc_file);
	    printf("<div class=\"summary\">\n<p>%s</p></div>\n", $description);

	}


	print("<div class=\"contentblock\"></div>\n");
	print("</div>\n\n");

    $letternum++;
    }

}











if($_GET['read']) {
    $path = explode ("_", $_GET['read']);
    $basedir = "news/letters2/" . $path[0] . "/";
    $filename = $basedir . "/" . $path[1];
}




if(is_file($filename)) {

$fd = fopen ($filename, "r");
$data = fread ($fd, filesize($filename));
fclose ($fd);




    function startElement($parser, $name, $attrs) {
	global $id;
        global $img_attrs;



        switch($name) {
            case "h1":
                print "<h1>";
                break;
            case "h2":
                print "<h2>";
                break;
            case "p":
                print "<p>";
                break;
            case "a":
                printf("<a href=\"%s\">", $attrs['href']);
                break;
            case "img":
                $img_attrs = $attrs;
                break;
            case "block":
                print "<div class=\"contentblock\">";
                break;
            case "br":
                print "<br/>";
                break;
            case "b":
                print "<b>";
                break;

            case "pre":
                print "<pre>";
                break;
        }
    }

    function characterData($parser, $data) {
        global $img_attrs;
        global $img_comment;

        if($img_attrs['src']) {
            $img_comment = $data;
        } else {
            print $data;
        }
    }

    function endElement($parser, $name) {
        global $id;
        global $img_attrs;
        global $img_comment;
        global $basedir;



        switch($name) {
            case "h1":
                print "</h1>";
                break;
            case "h2":
                print "</h2>";
                break;
            case "p":
                print "</p>";
                break;
            case "a":
                printf("</a>");
                break;
            case "img":

        	if($img_attrs['pos'] == "left") { $img_attrs['pos'] = "picleft"; }
   	        if($img_attrs['pos'] == "right") { $img_attrs['pos'] = "picright"; }

		if($img_attrs['link']) {
                    $link = $basedir . $img_attrs['link'];
              	}

                insert_image($basedir . $img_attrs['src'], $img_comment, $link, $img_attrs['pos'], "",
$img_attrs['height']);
                $img_attrs['src'] = false;
                $img_comment = false;
                break;
            case "block":
                print "</div>";
                break;
            case "b":
                print "</b>";
                break;

            case "pre":
                print "</pre>";
                break;
        }
    }




    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
    xml_set_element_handler($parser, "startElement", "endElement");
    xml_set_character_data_handler($parser, "characterData");
    xml_parse($parser, $data);
    printf("<p style=\"background: red\"><b>%s</b></p>", xml_error_string (xml_get_error_code ($parser)));
    xml_parser_free ($parser);


}
?>

<div class="contentblock">&nbsp;</div>


</div>

</div>



<?php include("right.php"); ?>



</div>

</body>
</html>

