<?php
include("functions.php");
$style[standard] = true;
$style[table] = true;
$style[image] = true;
$style[news] = true;
print_htmlheader("Siste nytt om Rozinante", $style, "");
?>

<body>

<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">
<h1>Siste nytt om Rozinante</h1>

<?php


$ini_array = parse_ini_file("config.ini");


$real = $ini_array[real];
$http = $ini_array[http];


$dir = "news/rozinante/";
$pic_dir = "news/pics/";
$thumb_dir = "news/thumbs/";

if ($directory = opendir($dir)) {

    $no = 0;

    while (false !== ($file = readdir($directory))) {
	$path = $dir . $file;
	if (is_file($path)) {

	    $fp = fopen($path, "r");
	    $line = fgets($fp, 100);
	    fclose($fp);

	    $mtime = ereg_replace ("<!--Unixtime:", "", $line);
	    $mtime = ereg_replace ("-->", "", $mtime);

	    $filelist[$no] = $path;
	    $filemlist[$no] = $mtime;

	    $no++;
	}
    }
    closedir($directory);

}


if (count($filelist) > 0) {
    array_multisort($filemlist, $filelist);
}


$elements_count = count($filelist);

for ($no = 0; $no < $elements_count; $no += 1) {

    $path = $filelist[$no];
    $rawtime = $filemlist[$no];

    setlocale ( LC_TIME, "no_NO");

    if (strlen($rawtime) > 1) {
	$mtime = strftime("%d %B %G", $rawtime);
    } else {
	$mtime = "ukjent";
    }


    $regtime = "Registrert (endret): " . strftime("%A %d %B %G %H:%M:%S %Z", filemtime ($path));

    if (is_readable($path)) {
	include($path);
    }

};



?>



</div>

</div>

<?php include("right.php"); ?>

</div>

</body>
</html>

