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
print_htmlheader("Post innlegg", $style, "../");

?>

<body>

<div id="article">


<div id="articlecontent">

<?php

if ($_POST[submit] == true): {

$safe_body = safehtml($_POST[body]);
$safe_body = ereg_replace(chr(10), "<br/>", $safe_body);

$encoded_body = base64_encode($safe_body);
$encoded_title = base64_encode(safehtml($_POST[title]));
$current_time = time();
$owner = trim($_SESSION['REALNAME']);


$fp = fopen ("bbs.txt", "r");
$fid = 1;


if ($_POST[id]) {

    $id = $_POST[id];

    while ($fid != $id) {
	$msg = fgets($fp, 4096);
	$file .= $msg;
	$fid++;
    }

    $msg = fgets($fp, 4096);
    $file .= $msg;

    $arr = explode(":", $msg);


    $thread = $arr[0] + 1;


} else {
    $thread = 0;
}


$new_msg = $thread . ":" . $current_time . ":" . $owner . ":" . $encoded_title . ":" . $encoded_body . chr(10);
$file .= $new_msg;


while (!feof ($fp)) {
    $msg = fgets($fp, 4096);
    $file .= $msg;
}

fclose($fp);

$fp = fopen("bbs.txt", "w");
fputs ($fp, $file);
fclose($fp);


print("<h1>Følgende innlegg ble lagt til</h1>");


print_entry($current_time, $owner, $encoded_title, $encoded_body);

} else:

if ($_GET[title]) {

    $real_title = base64_decode($_GET[title]);

    if (ereg ("^RE:", $real_title) ) {
	$addtitle = $real_title;
    } else {
	$addtitle = "RE: " . $real_title;
    }


}
if ($_GET[id] > 0) {
    $id = $_GET[id];
}

?>

<h1>Post innlegg</h1>
<p>Tillatt HTML-formatering er: &lt;b&gt;<b>fet tekst</b>&lt;/b&gt;,
&lt;i&gt;<i>kursiv tekst</i>&lt;/i&gt;, &lt;u&gt;<u>undersktreket tekst</u>&lt;/u&gt;</p>

<form method="post" action="add.php">
<table>
<tr><td>Navn:</td><td><?=$_SESSION['REALNAME']?></td></tr>
<tr><td>Tittel:</td><td><input type="text" name="title" value="<?=$addtitle?>" size="50"/></td></tr>
<tr><td>Tekst:</td><td><textarea name="body" rows="15" cols="50"></textarea></td></tr>
<tr><td></td><td>
<input type="submit" name="submit" value="OK" size="50" />
<input type="hidden" name="id" value="<?=$id?>" />
</table>
</form>

<?php endif; ?>

</div>

</div>

<?php include("loginright.php"); ?>


</body>

</html>