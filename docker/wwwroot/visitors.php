<?php
include("functions.php");
$style['standard'] = true;
$style['news'] = true;
$style['image'] = true;
$style['rfiles'] = true;
$style['text'] = true;
print_htmlheader("Personer", $style, "");
?>

<body>


<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">



<?php


if ( !$_GET['id'] ) {
    print "<h1>De besøkende på turen</h1>\n\n";
    print "<p>På denne siden vil du få en liten presentasjon av de som skal besøke Rozinante-mannskapet i løpet av turen. Mange mønstrer på når Rozinante er kommet til sydlige farvann, men fra begynnelsen blir det fire stk. ombord.</p>\n\n";
}


$filename = "visitors/" . $_GET['id'] . ".xml";

if(is_file($filename)) {

$filename = "visitors/" . $_GET['id'] . ".xml";
$id = $_GET['id'];


$fd = fopen ($filename, "r");
$data = fread ($fd, filesize($filename));
fclose ($fd);



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
            $image = "visitors/". $id . ".jpg";
            if(is_file($image)) {
                insert_image($image, "", "" , "picright", "");
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



$parser = xml_parser_create();
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");
xml_parse($parser, $data);
print(xml_error_string (xml_get_error_code ($parser)));
xml_parser_free ($parser);

}

?>



</div>



</div>

</div>


<div id="menu">

<div id="menucontent">

<div class="menublock">
<dl>
<dt>De besøkende:</dt>
<?php

$fp = fopen ("visitors/desc.list", "r");
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
