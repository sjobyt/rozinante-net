<?php
session_start();

if (!session_is_registered("SESSION")) {

// if session check fails, invoke error handler

header("Location: login.php");
exit();
}

print("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Nord Atlanteren Rundt 2003/2004 med Rozinante</title>

<link rel="stylesheet" href="../style.css" media="screen"/>
<link rel="stylesheet" href="logstyle.css" media="screen"/>

</head>

<body>

<div id="article">


<div id="articlecontent">

<h1>Felles BBS</h1>

<?php

include("bbs_functions.php");

$ini_array = parse_ini_file("../config.ini");


$real = $ini_array[real];
$http = $ini_array[http];


$messages = file("bbs.txt");

setlocale ( LC_TIME, "no_NO");

foreach ($messages as $msg) {
    $arr = explode(":", $msg);

    $time =  $arr[1];
    $owner = $arr[2];
    $title = $arr[3];
    $body = $arr[4];

print $time;
}


?>

</div>
</div>

<?php


if (session_is_registered("SESSION")) {
   include("loginright.php");
} else {
   include("../right.php");
}

?>

</body>
</html>