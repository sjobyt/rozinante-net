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
$style[news] = true;

print_htmlheader("Post nyhet", $style, "../");



function print_prev() {


    $filename = "news-preview.tmp";
    $file = fopen($filename, "r");
    $title = fgets($file, 4096);
    print("<div class=\"newslink\">");
    printf("<h2>%s</h2>", $title);
    $meta = fgets($file, 4096);
    setlocale (LC_TIME, "no_NO");
    printf("<p>Skrevet av <b>%s</b>, <i>%s</i></p>", $meta, strftime("%A %d %B %H:%M:%S %G ", time()));

    print("<div class=\"horizline\"></div>");

    while(!feof($file)) {
        $line = fgets($file, 4096);
        printf("%s", $line);
    }
    fclose($file);
    print("</div>");

}

?>

<body>

<div id="article">


<div id="articlecontent">

<h1>Post nyhet</h1>

<?php

if ($_POST['submit'] || $_POST['preview']) {
    $filename = time();

    $head .= stripslashes($_POST['title']);

    $msg .= $head . chr(10);
    $msg .= $_SESSION['REALNAME'] . chr(10);

    $rest = $_POST['body'];

    $main = stripslashes($rest);

    $msg .= "<p>";
    $msg .= str_replace(chr(10), "</p>" . chr(10). "<p>", $main);
    $msg .= "</p>";

    $file = fopen("news-preview.tmp", "w");
    fputs($file, $msg);
    fclose($file);
}


if ($_POST['submit']) {
    $file = fopen("../nyheter/". $filename, "w");
    fputs($file, $msg);
    fclose($file);

    print("<h2>Følgende ble postet</h2>");

    print_prev();

} elseif ($_POST['preview']) {

    print("<h2>Forhåndsvisning</h2>");

    print_prev();

}




?>

<p>For å legge til lenker bruker du følgende format: &lt;a href="lenke-addresse"&gt;<span style="text-decoration: underline; color: blue;">lenketekst</span></u>&lt;/a&gt;.
Hvis du f.eks. skal lenke til artikler, nyheter o.l innenfor rozinante.net holder det å bruke f.eks. "rfiles.php?id=arbeidet" som lenketekst. Bare gå inn på sida du vil lenke til og kopiér fra addressefeltet det som står etter "kaja03.fastcom.no/rozreal/" (forutsatt at du ikke går inn via rozinante.net addressa). Oss som er en del av prosjektet bør bruke <a href="http://kaja03.fastcom.no/rozreal/">http://kaja02.fastcom.no/rozreal/</a>.</p>

<form method="post" action="post_news.php">
<table>
<tr><td>Navn:</td><td><?=$_SESSION['REALNAME']?></td></tr>
<tr><td>Tittel:</td><td><input type="text" name="title" value="<?php print(htmlspecialchars($head)); ?>" size="50"/></td></tr>
<tr><td>Tekst:</td><td><textarea name="body" rows="15" cols="50"><?=$main ?></textarea></td></tr>
<tr><td></td><td>
<input type="submit" name="submit" value="OK" size="50" />
<input type="submit" name="preview" value="Forhåndsvis" size="50" />
</table>
</form>

<?php
$titles = 0;
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