<?php
include("functions.php");
$style[standard] = true;
$style[news] = true;
$style['image'] = true;
print_htmlheader("Sponsorer", $style, "");
?>

<body>


<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">



<?php

if (!$_GET['id']) {

print("<h1>Sponsorer</h1>");

$dir = "sponsor/articles/";
$list = "sponsor/sponsor.list";

$sponsors = file($list);

reset($sponsors);
$pos = 1;


do {
    $columns = explode(",", current($sponsors));


    if ($pos == 1) {
        print "<div class=\"contentblock\">";
        print "<div class=\"newslink\" style=\"float: left; width: 43%;\">";
        $pos = 2;
    } elseif ( $pos == 2 ) {
        print "<div class=\"newslink\" style=\"float: right; width: 43%;\">";
        $pos = 1;
    }




    $image_file = "sponsor/logos/" . $columns[0] . ".png";
    $id_link = "sponsor.php?id=" . $columns[0];

    if(is_file($image_file)) {
        insert_image($image_file, "", $id_link, "logoright", "logo", "");
    }
    printf("<h2><a href=\"%s\">%s</a></h2>", $id_link, $columns[1]);
    printf("<p>%s</p>", $columns[2]);
    print "</div>";

    if ($pos == 2) { print "</div>";}
} while (next($sponsors));

} else {


$filename = "sponsor/articles/" . $_GET['id'] . ".xml";
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
	    $image = "sponsor/pictures/" . $_GET['id'] . "/";
	    if($img_attrs['link']) {
	        $link = $image . $img_attrs['link'];
	    } else {
	        $link = "";
	    }
            insert_image($image . $img_attrs['src'], $img_comment, $link , $img_attrs['pos'], $img_attrs['alt'], "");
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

$parser = xml_parser_create("ISO-8859-1");
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");
xml_parse($parser, $data);
if (xml_get_error_code($parser))
{
    print(xml_error_string (xml_get_error_code ($parser)));
}
xml_parser_free ($parser);

print("<div class=\"contentblock\">");

insert_image("graphics/back.png", "", "sponsor.php" , "logoleft", "Tilbake", "");

print("</div>");

} else {
print "<h1>Ugyldig sponsor</h1>";
}

}

?>
</div>



</div>


<?php include("right.php"); ?>

</div>

</body>
</html>
