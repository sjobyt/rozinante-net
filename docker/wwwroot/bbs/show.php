<?php

session_start();

if (!session_is_registered("SESSION")) {
    header("Location: login.php");
    exit();
}

include("../functions.php");
include("bbs_functions.php");

$style[bbs] = true;
$style[text] = true;
print_htmlheader("Postinger", $style, "../");

?>

<body>

<div id="article">


<div id="articlecontent">

<h1>Felles BBS</h1>

<?php





$messages = file("bbs.txt");

setlocale ( LC_TIME, "no_NO");

if($_GET[id] == 0) {


    print_threadview($messages, 0, 0, "");

} else {

    $id = 1;

    while ($id < $_GET[id]) {
	$id++;
    };

    $msg = $messages[$id - 1];
    $arr = explode(":", $msg);

    $thread_offset = $arr[0];
    $time = $arr[1];
    $owner = $arr[2];
    $title = $arr[3];
    $body = $arr[4];

    printf("<p><a href=\"show.php\">Gå til toppnivå</a> | <a href=\"add.php\">Ny posting</a> |
    <a href=\"add.php?id=%s&title=$title\">Svar på viste posting</a></p>\n", $id);

    print_entry($time, $owner, $title, $body);


    $start_id = $id;

    $thread_base = $arr[0];
    $thread = $thread_base + 1;


    $arr = explode(":", $messages[$id]);

    if ($arr[0] == $thread) {

	while ($thread > $thread_base) {

	    $id++;
	    $last_offset = $thread;
	    $msg = $messages[$id - 1];
	    $arr = explode(":", $msg);
	    $thread = $arr[0];

	}

    } else {
    	$id++;
    }


    $array_part = array_slice ( $messages, $start_id - 1, $id - $start_id);

    printf("<p><b>Responser utover dette nivået (%s stk):</b></p>", $id - $start_id - 1);

    print_threadview($array_part, $thread_base, $start_id - 1, "true");

    //print("<pre>");
    //print_r($array_part);
    //print("</pre>");

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
