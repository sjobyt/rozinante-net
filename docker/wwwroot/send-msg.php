<?php
include("functions.php");
print_htmlheader("Meldingsbehandling", $style, "");
?>

<body style="background-color: #e0ffe0;">

<h1>Meldingsbehandling</h1>

<?php

$from_lng = strlen($_POST['from']);
$msg_lng = strlen($_POST['message']);

if($from_lng + $msg_lng > 160) {

	print("<h2>Feil med melding</h2>\n
	<p style=\"color: red\"><b>Meldingen er for lang. Maks 160 tegn.</b></p>\n
	<p>Gå tilbake og prøv igjen. Bruk tilbake-funksjon i nettleser så mister du ikke meldingen du skrev.</p>");

} elseif(($from_lng + $msg_lng) == 0) {

	print("<h2>Feil med melding</h2>\n
	<p style=\"color: red\"><b>Du kan ikke sende en tom melding.</b></p>\n
	<p>Gå tilbake og prøv igjen. Bruk tilbake-funksjon i nettleser så mister du ikke meldingen du skrev.</p>");

} else {

	print("<h2>Sender melding</h2>\n");
	$msg = "F " . $_POST['from'] . "\nM " . $_POST['message'];
	$return = mailsend($msg);
	if($return == 0) {
		print("<h2>Meldingen er sendt</h2>");
	} else {
		print("<h2 style=\"color: red\">Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	}

    $fp = fopen("sent-messages.txt",'a');
    $item = strftime("%Y-%m-%d kl. %H.%M", time()) . "\n" . $msg  . "\n\n";
    fwrite ($fp, $item, strlen($item));
    fclose($fp);

}



function mailsend($msg) {

	error_reporting (E_ALL);

	echo "<pre>";

	$address = gethostbyname ("inmc.eik.com");
	$service_port = 25;
	$headers = "From: staale.sat@natoil.com\r\nTo: la7gz@winlink.org\r\nSubject: S\r\nContent-Type: text/plain; charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n";


	/* Create a TCP/IP socket. */
	$socket = socket_create (AF_INET, SOCK_STREAM, 0);
	if ($socket < 0) {
 	   echo "Unable to create socket:" . socket_strerror ($socket) . "\n";
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
 	   echo "Connecting...";
	}

	$result = socket_connect ($socket, $address, $service_port);

	if ($result < 0) {
 	   echo "<b>\nsocket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "</b>\n";
	} else {
	    echo "OK.\n";
	}

	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out, 0, 3) != 220) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}


	$in = "HELO natoil.com\r\n";
	$out = '';
	echo "Sending HELO...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out, 0, 3) != 250) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}


	$in = "MAIL FROM:staale.sat@natoil.com\r\n";
	$out = '';
	echo "Sending MAIL FROM...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out, 0, 3) != 250) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}

	$in = "RCPT TO:425799920@inmc.eik.com\r\n";
	$out = '';
	echo "Sending RCPT TO...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out, 0, 3) != 250) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";

	}

	$in = "DATA\r\n";
	$out = '';
	echo "Sending DATA...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out,0 , 3) != 354) {
		printf("\n<b>Unexpected reply: %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}

	$in = $headers . "\n" . $msg . "\r\n." . "\r\n";
	$out = '';
	echo "Sending message...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out,0 , 3) != 250) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}

	$in = "QUIT\r\n";
	$out = '';
	echo "Sending QUIT...";
	socket_write ($socket, $in, strlen ($in));
	echo "OK.\n";
	echo "Reading response: ";
	$out = socket_read ($socket, 2048);
	if(substr($out,0 , 3) != 221) {
		printf("\n<b>Unexpected reply:\n %s</b>\n", $out);
	    die("<h2>Meldingen ble ikke sendt pga. ukjent feil!</h2>");
	} else {
		echo "Reply OK.\n\n";
	}

	echo "Closing socket...";
	socket_close ($socket);
	echo "OK.\n\n";

	echo "</pre>";

	return(0);
}

?>

<p>©2005 www.rozinante.net.</p>

</body>
</html>