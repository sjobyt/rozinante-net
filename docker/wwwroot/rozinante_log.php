<?php
include("functions.php");
$style[standard] = true;
$style[table] = true;
$style[image] = true;
$style[news] = true;
print_htmlheader("Nyheter fra forberedelsene", $style, "");
?>

<body>

<?php
$selected = 2;
include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">

<?php

$dir = "news/rozinante/";

if ($directory = opendir($dir)) {

    $no = 0;

    while (false !== ($file = readdir($directory))) {
	$path = $dir . $file;
	if (is_file($path)) {

	    $fp = fopen($path, "r");
	    $line = fgets($fp, 100);

	    fclose($fp);
	    preg_match ( "/<!--(.*)-->[\n|.]*<!--(.*)-->[\n|.]*<!--(.*)-->/i", $line, $meta);
	    $mtime = $meta[1];

	    $filelist[$no] = $path;
	    $filemlist[$no] = $mtime;

	    $no++;
	}
    }
    closedir($directory);

}


if (count($filelist) > 0) {
    array_multisort($filemlist, SORT_DESC, $filelist);
}



$elements_count = count($filelist);

if ($_GET['no'] || $_GET['id']) {

    $pic_dir = "news/pics/";
    $thumb_dir = "news/thumbs/";

    $element = $_GET['no'] - 1;

    if($_GET['no']) {
	$filename = $filelist[$element];
    } else {
        $filename = "news/rozinante/" . $_GET['id'];
        if(!is_file($filename)) { $filename = $filelist[0]; }
    }

    $fp = fopen($filename, "r");
    $line = fgets($fp, 100);
    fclose($fp);


    preg_match ( "/<!--(.*)-->[\n|.]*<!--(.*)-->[\n|.]*<!--(.*)-->/i", $line, $meta);

    setlocale ( LC_TIME, "no_NO");
    $formatted_time = strftime("%A %d %B %G (%H:%M) %Z", $meta[1]);
    $formatted_mtime = strftime("%A %d %B %G %H:%M:%S %Z", filemtime($filename));

    print("<div class=\"header\">\n");
    print("<table class=\"header\">\n");
    printf("<tr><th>Tittel:</th><td>%s</td></tr>\n", $meta[2]);
    printf("<tr><th>Skrevet av:</th><td>%s</td></tr>\n", $meta[3]);
    printf("<tr><th>Dato:</th><td>%s</td></tr>\n", $formatted_time);
    printf("<tr><th>Endret/lagt ut:</th><td>%s</td></tr>\n", $formatted_mtime);
    printf("<tr><th>Fil:</th><td>%s</td></tr>\n", $filename);
    print("</table>\n");
    print("</div>\n");


    printf("<h1>%s</h1>\n", $meta[2]);

    include($filename);

} else {

    print("<h1>Nyheter fra forberedelsene</h1>\n");
    for ($no = 0; $no < $elements_count; $no++) {

    $fp = fopen ( $filelist[$no], r );
	do {
	    $char = fgetc ( $fp );
            $file = $file . $char;
        } while (!feof ($fp));
    fclose ($fp);

    preg_match ( "/<!--(.*)-->[\n|.]*<!--(.*)-->[\n|.]*<!--(.*)-->/i", $file, $meta);
    preg_match ( "/<p>((.|\n)*?)<\/p>/i", $file, $paragraph);

    setlocale ( LC_TIME, "no_NO");
    $formatted_time = strftime("%a %d %B %G", $meta[1]);

    $curr_month = strftime("%m", $meta[1]);
    $month_name = ucfirst( strftime("%B", $meta[1]) );

    if($curr_month != $last_month) {
	$year = strftime("%Y", $meta[1]);
	if($year == 2002) {
	    printf("<h2>%s (%s)</h2>", $month_name, $year);
	} else {
	    printf("<h2>%s</h2>", $month_name);
	}
    }

    $last_month = $curr_month;


    print("<div class=\"newslink\">\n");
    printf("<h3>%s</h3>", $meta[2]);
    printf("\n<p>%s<br/>\n<a href=\"%s\"><b>Les mer</b></a></p>", $paragraph[1], "rozinante_log.php?no=" . ($no + 1));
    printf("\n<p class=\"tech\">Skrevet av %s - %s</p>", $meta[3], $formatted_time);
    print("\n</div>");

    $file = false;
    }

}

?>

</div>

</div>

<?php include("right.php"); ?>

</div>

</body>
</html>
