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
print_htmlheader("Oversikt", $style, "../");

?>

<body>

<div id="article">


<div id="articlecontent">
<h1>Du er logget inn som "<?=$_SESSION['UNAME']?>"</h1>

<dl>
<dt>Valg mens du er logget inn:</dt>
<dd><a href="show.php">» Se på postinger</a></dd>
<dd><a href="add.php">» Post innlegg</a></dd>
<dd><a href="post_news.php">» Post nyhet</a></dd>
<dd><a href="chpass.php">» Endre passord</a></dd>
<dd><a href="logout.php">» Avslutt</a></dd>
</dl>


</div>

</div>

</body>


</html>
