<?php
include("functions.php");
$style[standard] = true;
$style[table] = true;
$style[image] = true;
$style[news] = true;
print_htmlheader("Administrative nyheter", $style, "");
?>

<body>

<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">

<h1>Administrative nyheter</h1>

<?php

include("news_functions.php");

$num = 0;
$dirname = "nyheter/";

$dir = opendir($dirname);

while (false !== ($file = readdir($dir))) {

    $files[$num] = $file;
    $num++;

}
closedir($dir);


array_shift($files);
array_shift($files);



$files = array_reverse($files);


if (count($files) > 0) {

    $id = 0;

    if($_GET['id'] > count($files) - 1) {
        $_GET['id'] = 0;
    }

    while ($id < $_GET['id']) {


        $filename = $files[$id];
        print_newsline($filename, $id);
        $id++;


    }


    $filename = $files[$id];
    print_news($filename);
    $id++;


    while ($filename = $files[$id]) {

        print_newsline($filename, $id);
        $id++;

    }


}

?>


</div>



</div>


</div>



<?php include("right.php"); ?>

</body>
</html>


