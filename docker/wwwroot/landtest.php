<?php
include("functions.php");
$style[standard] = true;
print_htmlheader("Landinfo test", $style, "");
?>

<body>

<?php

$level;
$html;
$file = "landinfo/countrydata/sp.xml";


$fp = fopen ($file,"r");
do {
    $char = fgetc ( $fp );
    $data = $data . $char;
} while (!feof ($fp));
fclose ($fp);


function startElement($parser, $name, $attrs) {
    global $level;
    global $html;

    if(!$level) {
        if($name == "arrival") {
            $html .= "<p><b>Ankomst:</b>";
            $level = 1;
        }
        if($name == "departure") {
            $html .= "<p><b>Avgang:</b>";
            $level = 2;
        }
        if($name == "distance") {
            $html .= "<p><b>Avstand:</b>";
            $level = 3;
        }
    }
}

function characterData($parser, $data) {
    global $level;
    global $html;
    if($level == 1) {
        $html .= " $data";
    }
        if($level == 2) {
        $html .= " $data";
    }
        if($level == 3) {
        $html .= " $data";
    }
}

function endElement($parser, $name) {
    global $level;
    global $html;
    if($level) {
        $html .= "</p>";
        $level = 0;
    }

}


$parser = xml_parser_create();
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, "startElement", "endElement");
xml_set_character_data_handler($parser, "characterData");


xml_parse($parser, $data);



print(xml_error_string (xml_get_error_code ($parser)));



xml_parser_free ($parser);


print $html;



?>

</body>
</html>