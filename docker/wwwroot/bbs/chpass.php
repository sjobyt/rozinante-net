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
print_htmlheader("Endre passord", $style, "../");

?>

<body>

<div id="article">


<div id="articlecontent">

<h1>Endre passord</h1>


<?php


if ($_POST[submit] == true) {

    $users = file("passwd");
    $id = 0;

    do {

        $columns = explode(":", $users[$id]);
	$id++;

    } while ($columns[0] != $_SESSION['UNAME']);




    if ( md5($_POST[old]) == $columns[1] ) {

        if ( $_POST[new1] == $_POST[new2] && strlen($_POST[new1]) >= 4) {

	    $columns[1] = md5($_POST[new1]);

            $users[--$id] = $columns[0] . ":" . $columns[1] . ":" . $columns[2];

	    $id = 0;

	    while ($users[$id] != "") {

		$file .= $users[$id];
		$id++;
	    }

	    $fp = fopen("passwd", "w");
	    fputs ( $fp, $file );
	    fclose($fp);


	    print("<p><b>Passordfilen ble oppdatert. Neste gang du logger inn må du bruke det nye passordet</b></p>");
	    print("<hr/>");

        } else {

            print("<p><b>Det nye passordet må skrives inn to ganger helt likt. <br/>Passordfeltene var
            enten ulike eller innehold for få tegn. <br/>Du må ha minst 4 tegn i passordet ditt.</b></p>");

        }

    } else {

        print("<p><b>Det gamle passordet stemte ikke</b></p>");

    }


}



?>

<form method="post" action="chpass.php">
<table class="facts">
<tr><td>Gammelt passord:</td><td><input type="password" name="old" size="20"></td></tr>
<tr><td>Nytt passord (1.gang):</td><td><input type="password" name="new1" size="20"\></td></tr>
<tr><td>Nytt passord (2.gang):</td><td><input type="password" name="new2" size="20"\></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="OK" size="50"/></td></tr>
</table>

</div>

</div>


<?php include("loginright.php"); ?>


</body>

</html>













