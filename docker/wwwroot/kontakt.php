<?php
include("functions.php");
$style['standard'] = true;
$style['news'] = true;
print_htmlheader("Kontaktinformasjon", $style, "");
?>

<body>


<?php include('bar.php'); ?>

<div id="wrap">

<div id="article">


<div id="articlecontent">

<h1>Kontaktinformasjon</h1>


<h2>Kaptein</h2>

<div class="person">
<p><b>Staale Jordan</b><br/>
Skjærbommen 162<br/>
4639 Kristiansand<br/>
<?php
//Tlf: +870764563855 (kan ringes mellom kl 12-13 norsk tid hver dag)
?>
</p>
<img src="graphics/caubry_mail.png" alt="E-post: caubry krøllalfa start.no"/>
</div>


<div class="contentblock">

<h2>Tidligere mannskap</h2>

<div class="person">
<p><b>Ragnar Torkildsen</b><br/>
Huldertun 18<br/>
4638 Kristiansand<br/>
Tlf: 41048447</p>
<img src="graphics/rto_mail.gif" alt="E-post: rto krøllalfa rozinante.net"/>
</div>

<div class="person">
<p><b>Paul-Andrè Knudsen</b><br/>
Bordalen 9A<br/>
4639 Kristiansand<br/>
Tlf: 97189310<br/></p>
<img src="graphics/pak_mail.gif" alt="E-post: pak krøllalfa rozinante.net"/>
</div>


</div>


<div class="contentblock">


<?php
//<div class="newslink">
//<h2>Iridium sattelittelefon til Rozinante</h2>
//<p>Du kan få tak i Rozinante uansett hvor båten befinner seg ved å bruke følgende nummer: +881631527858 (å ringe til
//sattelitt-telefon 21,- NOK i minuttet!)</p>
//<p>Hvis du bare vil sende melding til Rozinante,<br/> kan du gjøre det gratis via <a
//href="http://messaging.iridium.com/">Iridiums nettsider</a> eller bruke skjemaet på bunnen av denne siden.</p>
//</div>
?>

<div class="newslink">
<h2>Radiokommunikasjon</h2>
<h3>Radioamatør-båndene</h3>
<p>Vårt radioutstyr av typen ICOM M802 opererer i frekvensområdet 0-30 MHz med en uteffekt på 150 Watt. Vårt
kallesignal på de frekvensene som er tildelt radioamatørene er LA7GZ/MM (MM=Maritime Mobile). Kontakt kan oppnås
ved å sende frekvens og tidspunkt som tekstmelding til sattelitttelefonen. </p>

<h3>Maritime VHF-kanaler</h3>
<p>Vårt kallesignal her er LK6163.</p>

<h3>Maritime MF/HF SSB-frekvenser</h3>
<p>På maritime frekvenser i frekvensområdet 1,5-30 MHz. Er kallesignalet vårt LK6163. Vi benytter også her vår ICOM M802 SSB radio.</p>

<p>Kontakt via Rogaland Radio kan i Norge oppnås ved å ringe tlf: 122 og oppgi MMSI ID: 257594630 (Rozinante's maritime telefonummer) og omtrentlig hvor Rozinante befinner seg. Av en eller annen merkelig grunn koster det faktisk mer å bruke denne gammeldagse metoden enn å ringe til sattelitttelefonen vår. Denne kommuikasjonen foregår via kortbølge telefoni og er halv-duplex (prate som i en walkie-talkie). Radiostøy kan også oppstå under kommunikasjonen.</p>
</div>

</div>

<div class="newslink" style="clear: both;">
<p>Er det noe du lurer på kan du også sende e-post til:</p>
<img  style="display: inline;" src="graphics/gutta_mail.gif" alt="E-post: rozinante krøllalfa rozinante.net"/>
<p>Så vil alle tre (pluss webmaster) få den samme e-posten og så svarer den som best kan svare.</p>
</div>

<div class="contentblock">

<div class="horizline"></div>

<p><b>Rozinantes andre eiere:</b></P>
<div class="person">
<p><b>Bjørn Jordan</b><br/>
Skjærbommen 162<br/>
4639 Kristiansand<br/>
Tlf: 90955231/38040521<br/>
Hjemmeside: <a href="http://www.rozinante.net/birkebeiner">http://www.rozinante.net/birkebeiner</a><br/>
<b>bjjo1@vaf.no</b></p>
</div>

<div class="person">
<p><b>Annelise Aasheim Hornang</b><br/>
Skjærbommen 162<br/>
4639 Kristiansand<br/>
Tlf: 41823590/38040521<br/>
<b>annelise.hornang@kristiansand.kommune.no</b></p>
</div>


</div>

<div class="horizline"></div>

<div class="flatbox">
<h2>Send tekstmelding til Rozinante (DEAKTIVERT)</h2>

<form name="msgform" method="post"
action="http://www.jalla.org/~stig/send-msg.php">
<table style="streamline">
<tr><th>Fra:</th><td><input type="text" size=33 name="from" value="" onKeyUp="Javascript:updateCharCount();" onChange="Javascript:updateCharCount();" class=text></td></tr>
<tr><th>Melding:</th><td><textarea class="text" onKeyUp="Javascript:updateCharCount();" onChange="Javascript:updateCharCount();" cols=38 rows=4 style="overflow:hidden;" name="message" wrap="virtual"></textarea></td></tr>
</table>
<p>(Maks 160 tegn)</p>
<input class="text" type="submit" value="Send">
<input class="text" type="text" size="3" name="charcount" readonly="readonly"/>
<p>(Tjenesten er levert av <a name="down" href="http://www.iridium.com/">Iridium</a> og er begrenset til 160
tegn).</p>
</form>
</div>
</div>

<script language="Javascript">
<!--
function updateCharCount() {
    if(document.msgform.from.value.length) {
    document.msgform.charcount.value = document.msgform.message.value.length + document.msgform.from.value.length + 1;
  }
  else {
    document.msgform.charcount.value = document.msgform.message.value.length;

  }
  }
function validateForm() {
  if(document.msgform.message.value=='') {
    alert("Message must be specified");
    document.msgform.message.focus();
    return false;
  }
  if((document.msgform.from.value.length && ((document.msgform.message.value.length+document.msgform.from.value.length+1)>160)) || (!document.msgform.from.value.length && (document.msgform.message.value.length>160))) {
    alert("Maximum message size is 160 characters")
    document.msgform.message.focus();
    return false;
  }
  return true;
}
-->
</script>

</div>

<?php include("right.php"); ?>

</div>

</body>
</html>
