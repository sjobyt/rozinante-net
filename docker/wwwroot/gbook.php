<?php
include("functions.php");
$style['standard'] = true;
$style['guestbook'] = true;
print_htmlheader("Gjestebok / Guestbook", $style, "");
?>

<body>

<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">

<h1>Gjestebok / Guestbook</h1>





<?php

$filename = "guestbook/entries.txt";


if ($_GET['action'] == "nytt"): {

$messages = file($filename);
$number = count($messages) + 1;


?>

<h2>Skriv i gjesteboken / Write in Guestbook</h2>

<form method="post" action="gbook.php?number=<?php print($number); ?>">
<table>
<tr><td>Navn/Name:</td><td><input type="text" name="posted_by" size="20" maxlength="30"/></td></tr>
<tr><td>E-post/E-Mail (hvis ønskelig/if desirable):</td><td><input type="text" name="email" size="40" maxlength="60"/></td></tr>
<tr><td>I dette feltet skriver du nøyaktig/Here you write exactly: THISISNOTSPAM:</td><td><input type="text" name="nospam" size="40"
maxlength="60"/></td></tr>
<tr><td>Tekst/Text (maks 1000 tegn/Max 1000 characters):</td><td><textarea name="body" rows="15" cols="50"></textarea></td></tr>
<tr><td></td><td>
<input type="submit" name="submit" value="OK" size="50" />
</table>
</form>

<?php

} else:

function print_entry($time, $posted_by, $email, $body) {
    printf("<div class=\"entry\">\n");
    printf("<p><span class=\"info\">%s av %s", strftime("%Y-%m-%d kl. %H.%M", $time), base64_decode($posted_by));
    if($email) {
        printf(" &lt;<a href=\"mailto:%s\">%s</a>&gt;", base64_decode($email), base64_decode($email));
    }
    printf("</span><br/>\n%s</p>\n", base64_decode($body));
    printf("</div>\n\n");
}



if($_POST['submit'] == true) {
    $fp = fopen($filename,"r");
    $file = fread ($fp, filesize($filename));
    fclose($fp);

    if($_POST['nospam'] == "THISISNOTSPAM" && $_POST['posted_by'] && $_POST['body'] && strlen($_POST['body']) <= 1000) {


        $body = htmlspecialchars ($_POST['body']);
        $body = stripslashes($body);
        $body = str_replace (chr(10), "<br/>\n", $body);


	$_POST['posted_by'] = stripslashes($_POST['posted_by']);
	$_POST['email'] = stripslashes($_POST['email']);

        $new_entry = time() . ":" . base64_encode($_POST['posted_by']) . ":" . base64_encode($_POST['email']) . ":" . base64_encode($body);

        if(strlen($file)) {
            $newfile = $new_entry . chr(10) . $file;
        } else {
            $newfile = $new_entry . $file;
        }

        $fp = fopen($filename,"w");
        fputs ($fp, $newfile);
        fclose($fp);


    } else {

        if(strlen($_POST['body']) > 1000) {
            print("<p style=\"color: red\">Du kan ikke skrive mer enn 1000 tegn som kommentar. Reduser antall tegn.</p>");
            print("<p style=\"color: red\">You cannot write more than 1000 characters in your comment. Please shorten your comment.</p>");
	} elseif($_POST['nospam'] != "THISISNOTSPAM") {
	    print("<p style=\"color: red\">Du må huske å skrive: THISISNOTSPAM i det siste feltet. Dette er en for å forhindre at gjesteboken blir full av reklame.");
	    print("<p style=\"color: red\">Please write: THISISNOTSPAM in the last entry field to be able to post your comment. This prevents the guestbook beeing spammed.</p>");
        } else {
            print("<p style=\"color: red\">Du må skrive inn navn og noe i kommentar-feltet for at du skal kunne skrive i gjestboken.</p>");
            print("<p style=\"color: red\">You must write something in the name- and comment field to be able to post a comment.</p>");
        }

    }

}


print("<p><a href=\"gbook.php?action=nytt\">Skriv/Write</a> i
gjestboken / In guestbook</p>");


$fp = fopen($filename,"r");


while(!feof($fp) && filesize($filename)) {
    $entry = fgets($fp, 4096);
    $columns = explode(":", $entry);

    print_entry($columns[0], $columns[1], $columns[2], $columns[3]);
}


endif;

?>





</div>

</div>


<?php include("right.php"); ?>

</div>

</body>


</html>

