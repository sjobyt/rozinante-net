<?php
// added timezone to fix time issue inside docker container
date_default_timezone_set('Europe/London');

function insert_image($address, $caption, $link, $class, $alt, $height) {

    if(is_file($address)) {


    if(ereg (".jpg$", $address) || ereg (".JPG$", $address)) {
        $src_img = imagecreatefromjpeg($address);
    } elseif (ereg (".png$", $address) || ereg (".PNG$", $address)) {
        $src_img = imagecreatefrompng($address);
    }


    $src_width = imagesx ($src_img);
    $src_height = imagesy ($src_img);

    imagedestroy ($src_img);

    if($height) {
	$height_string = "height: " . $height . "px;";
    }

    printf("<div class=\"%s\" style=\"width: %spx;%s\">\n" , $class, $src_width + 2, $height_string);

    if ($link) { printf("<a href=\"%s\">", $link); $type = "linkpic"; } else { $type = "pic"; };
    printf("<img src=\"%s\" alt=\"%s\" class=\"%s\" style=\"width: %spx; height: %spx;\" />", $address, $alt, $type, $src_width, $src_height);
    if ($link) { printf("</a>"); };

    if ($caption) { printf("\n<p>%s</p>", $caption); };
    printf("\n</div>\n");

    } else {
	printf("<p><b>Fant ikke bildefil: %s / </b><i>\"%s\"</i></p>", $address, $caption);
    }

}

function print_htmlheader($title, $which, $prefix) {
    header("Content-type: text/html; charset=iso-8859-1");
    function print_styleref($link) {
        printf("<link rel=\"stylesheet\" href=\"%s\" media=\"screen\" />\n", $link);
    }

    print("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n");
    print("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n");
    print("<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"no\">\n");
    print("<head>\n");
    print("<title>" . $title . "</title>\n\n");


    //printf("<link rel=\"stylesheet\" href=\"%sstylesheets/print.css\" media=\"print\" />\n", $prefix);
    if ($which[standard] == true) {
	print_styleref($prefix . "stylesheets/layout.css");
	print_styleref($prefix . "stylesheets/text.css");
    }

    if ($which[report] == true) {
	print_styleref($prefix . "stylesheets/report.css");

    }


    if ($which[image] == true) {
	print_styleref($prefix . "stylesheets/image.css");
    }

    if ($which[table] == true) {
	print_styleref($prefix . "stylesheets/table.css");
    }

    if ($which[news] == true) {
	print_styleref($prefix . "stylesheets/news.css");
    }

    if ($which[bbs] == true) {
	print_styleref($prefix . "stylesheets/bbs.css");
    }

    if ($which[frontpage] == true) {
	print_styleref($prefix . "stylesheets/frontpage.css");
    }

    if ($which[landinfo] == true) {
	print_styleref($prefix . "stylesheets/landinfo.css");
    }
    if ($which[rfiles] == true) {
	print_styleref($prefix . "stylesheets/r-files.css");
    }
    if ($which[guestbook] == true) {
	print_styleref($prefix . "stylesheets/guestbook.css");
    }
    if ($which[links] == true) {
	print_styleref($prefix . "stylesheets/links.css");
    }
    if ($which[letters] == true) {
	print_styleref($prefix . "stylesheets/letters.css");
    }


    print("</head>\n");


}
?>
