<?php

session_start();

if (session_is_registered("SESSION")) {
    header("Location: show.php");
    exit();
}

include("../functions.php");
include("bbs_functions.php");

$style[bbs] = true;
$style[text] = true;
print_htmlheader("Logg inn", $style, "../");

?>

<body>

<div id="article">


<div id="articlecontent">


<?php
if ($_GET[wrong] == yes) {
    print("<p><b>Login incorrect</b></p>");
}
?>

<form method="post" action="auth.php">

<table class="facts">
<tr><th>Brukernavn:</th><td><input type="text" name="f_user" size="20"></td></tr>
<tr><th>Passord:</th><td><input type="password" name="f_pass" size="20"></td></tr>
<tr><td></td><td colspan="2"><input type="submit" value="Fortsett" name="submit" size="20"></td></tr>
</table>

</form>


<p><a href="../index.php">&lt;-- Tilbake til hovedside</a></p>
</div>

</div>



</body>
</html>