<?php


function xml_parser($source) {


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


                $link = $basedir . $img_attrs['link'];

                insert_image($basedir . $img_attrs['src'], $img_comment, $link , $img_attrs['pos'], "");
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




    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
    xml_set_element_handler($parser, "startElement", "endElement");
    xml_set_character_data_handler($parser, "characterData");
    xml_parse($parser, $source);
    printf("<p style=\"background: red\"><b>%s</b></p>", xml_error_string (xml_get_error_code ($parser)));
    xml_parser_free ($parser);

}
?>