<?php
include("functions.php");
$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
$style['rfiles'] = true;
print_htmlheader("Våre medhjelpere", $style, "");
?>

<body>


<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">



<?php


if(!$_GET['id']) {

print "<h1>Våre medhjelpere</h1>\n\n";
print "<p>På denne siden vil vi presentere personene som har vært og er til meget stor hjelp for oss under forbredelelsene til turen!</p>";

$fp = fopen ("persons/desc.list", "r");

$pos = "left";


do {
    $buffer = fgets($fp, 4096);
    $columns = explode(",", $buffer);

    if ($columns[0] != false) {

        if($pos == "left") {
        	print "<div class=\"contentblock\">\n";
        	print "<div class=\"personleft\">\n";
        	$pos = "right";
        } elseif ($pos == "right") {
        	print "<div class=\"personright\">\n";
        	$pos = "left";
        }


        $image = "persons/" . $columns[0] . "_small.jpg";

        if(is_file($image)) {
            insert_image($image, "", "person.php?id=" . $columns[0] , "picleft", "", "");

        } else {
            printf("<p>[inget bilde ennå]</p>");
        }
            printf("<p><b><a href=\"%s\">%s</a></b><br/>Navn: %s</p>", "person.php?id=" . $columns[0], $columns[1], $columns[2]);
        print "</div>";
        if($pos == "left") {
            print "</div>";
        }

    }
} while (!feof($fp));

fclose ($fp);




} else {
    print "<div class=\"border\">";

    $filename = "persons/" . $_GET['id'] . ".xml";
    $id = $_GET['id'];

$fd = fopen ($filename, "r");
$data = fread ($fd, filesize($filename));
fclose ($fd);

$first_newline = strpos($data, "\n");
fclose ($fd);
if (substr($data, 0, 5) == "<?xml")
{
        $data = "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>" . substr($data, $first_newline, strlen($data));
}


function startElement($parser, $name, $attrs) {


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
    }
}

function characterData($parser, $data) {
    print $data;
}

function endElement($parser, $name) {
global $id;

    switch($name) {
        case "head":
            print "</h1>";
            $image = "persons/". $id . ".jpg";
            if(is_file($image)) {
                insert_image($image, "", "" , "picright", "", "");
            }
            break;
        case "p":
            print "</p>";
            break;
        case "link":
            printf("</a>");
            break;
    }
}



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


print "</div>";
}

?>



</div>



</div>

</div>


<div id="menu">

<div id="menucontent">

<div class="menublock">
<dl>
<dt>Våre medhjelpere:</dt>
<?php

$fp = fopen ("persons/desc.list", "r");
do {
    $buffer = fgets($fp, 4096);
    $columns = explode(",", $buffer);
    if ($columns[0] != false) {
        printf("<dd><a href=\"%s\">» %s</a></dd>", "?id=" . $columns[0], $columns[1]);
    }

} while (!feof($fp));

fclose ($fp);



?>


</dl>
</div>

</div>

</div>



</div>

</body>
</html>
