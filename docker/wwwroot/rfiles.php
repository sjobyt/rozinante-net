<?php
include("functions.php");
$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
print_htmlheader("The R-Files", $style, "");
?>

<body>




<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">



<div id="articlecontent">


<?php


$filename = "rfiles/" . $_GET['id'] . ".xml";
$id = $_GET['id'];





function startElement($parser, $name, $attrs) {
    global $id;
    global $img_attrs;



    switch($name) {
        case "head":
            print "<h1>";
            break;
        case "p":
            print "<p>";
            break;
        case "link":
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



    switch($name) {
        case "head":
            print "</h1>";
            break;
        case "p":
            print "</p>";
            break;
        case "link":
            printf("</a>");
            break;
        case "img":
	    $image = "rfiles/pictures/" . $id . "/";
	    if($img_attrs['pos'] == "logoright" || $img_attrs['pos'] == "logoleft") {
	        $link = "";
	    } else {
	        $link = $image . $img_attrs['link'];
	    }
            insert_image($image . $img_attrs['src'], $img_comment, $link , $img_attrs['pos'], "", "");
            $img_attrs['src'] = false;
            $img_comment = false;
            break;
        case "block":
            print "</div>";
            break;
        case "b":
            print "</b>";
            break;
    }
}



if(is_file($filename)) {

$fd = fopen ($filename, "r");
$data = fread ($fd, filesize($filename));
fclose ($fd);

$first_newline = strpos($data, "\n");
fclose ($fd);
if (substr($data, 0, 5) == "<?xml")
{
        $data = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>" . substr($data, $first_newline, strlen($data));
}


$parser = xml_parser_create("ISO-8859-1");
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");
xml_parse($parser, $data);
   if (xml_get_error_code($parser) != XML_ERROR_NONE)
    {
        printf("<p style=\"background: red\"><b>%s</b></p>", xml_error_string (xml_get_error_code ($parser)));
    }

xml_parser_free ($parser);

} else {
print("<h1>The R-Files</h1>\n<p>

<p>Alle har hørt om \"The X-Files\" langt færre har vel derimot hørt om
de langt mindre mystiske \"Rozinante-Files\" (Aka \"R-Files\")!<br/>
Kanskje ikke såå rart...</p>
<p>Her finnes artikler og historier som ikke har passet inn noe annet sted,
men som er vel verdt å få med seg allikevel, fra nostalgi til humor.</p>");


print("<h2>Siste R-file:</h2>");

$dir = "rfiles/";
$highest = 0;

if ($directory = opendir($dir)) {

    while (false !== ($filename = readdir($directory))) {
	$path = $dir . $filename;
	if (is_file($path)) {

	    $current = filemtime($path);

	    if($current > $highest) {
	        $highest = $current;
	        $newest_filename = $filename;
	    }

	}
    }
    closedir($directory);

}

$fd = fopen ("rfiles/" . $newest_filename, "r");
$file = fread ($fd, filesize("rfiles/" . $newest_filename));
fclose ($fd);

preg_match ( "/<head>((.|\n)*?)<\/head>/i", $file, $title);
preg_match ( "/<p>((.|\n)*?)<\/p>/i", $file, $paragraph);


$id = substr ($newest_filename, 0, strlen($filename) - 4);

setlocale ( LC_TIME, "no_NO");
$formatted_time = strftime("%a %d %B %G", filemtime("rfiles/" . $newest_filename));

print("<div class=\"newslink\">\n");
printf("<h3>%s</h3>", $title[0]);
printf("\n<p>%s<br/>\n<a href=\"%s\"><b>Les mer</b></a></p>", $paragraph[1], "rfiles.php?id=" . $id);
printf("\n<p class=\"tech\">%s</p>", $formatted_time);
print("\n</div>");

}
?>


</div>

</div>


<div id="menu">

<div id="menucontent">


<div class="menublock">

<dl>
<dt>R-files:</dt>


<?php

$dir = "rfiles/";

if ($directory = opendir($dir)) {

while (false !== ($file = readdir($directory))) {

    $path = $dir . $file;

    if (is_file($path)) {

        $fd = fopen ($path, "r");
	$data = fread ($fd, 500);
	fclose ($fd);


        preg_match ( "/<head>((.|\n)*?)<\/head>/i", $data, $title);
       	$id = substr($file, 0, strlen($file) - 4);
        $title[0] = substr($title[0], 6, strlen($title[0]) - 13);
	printf("<dd><a href=\"rfiles.php%s\">» %s</a></dd>", $_php['self'] . "?id=". $id, $title[0]);

    }

}
closedir($directory);

}
?>
</dl>
</div>




</div>

</div>


</div>

</body>
</html>

