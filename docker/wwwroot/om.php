<?php
include("functions.php");

if(!$_GET['nostyle']) {
    $style[standard] = true;
    $style[text] = true;
}
print_htmlheader("Om nettstedet", $style, "");
?>

<body>

<?php
    $selected = 4;
    include('bar.php');
?>

<div id="wrap">

<div id="article">


<div id="articlecontent">
<h1>Om nettstedet</h1>

<?php if (!$_GET['page'] == 2): ?>

<h2>Generell informasjon</h2>

<p>Vi prøver å lage en interessant nettside hvor du kan følge prosjektet fra
begynnelse til slutt. Et slikt prosjekt vi er i gang med
krever mye planleggning. Etter hvert vil vi også komme med informasjon om
hvilke løsninger vi velger på de behovene vi ser at vi har
for å fullføre prosjeketet. Nettstedet vil til slutt inneholde mye
informasjon og vi vil derfor kunne tilby et nettsted som
andre personer som vil gjøre det samme som oss kan benytte seg av.</p>

<p style="display: inline;">Har du spørsmål, forslag til endringer etc. kan du kontakte webmaster Stig Hornang på e-post: <b>shornang@gmail.com</b></p>
<p><a href="om.php?page=2">Teknisk informasjon</a></p>

<?php endif; ?>

<?php if ($_GET['page'] == 2): ?>

<h2>Teknisk informasjon</h2>

<p>Teknisk sett er målet for nettstedet å holde seg til alle de standardene
som finnes vedrørende informasjonsutveksling på <acronym title="World Wide Web">WWW</acronym>.
Dette er hovedsaklig <a href="http://www.w3.org/MarkUp/"><acronym title="HyperText Markup Language">HTML
</acronym></a> og <a href="http://www.w3.org/Style/CSS/"><acronym title="Cascading Style Sheets">CSS</acronym></a>
spesifikasjonene utgitt av <a href="http://www.w3.org/"><abbr title="World Wide Web Consortium">W3C</abbr></a>.
Vi har ingen planer om å bryte disse eller gjøre bruk av tabeller
til design. Å bruke tabeller til design er sterkt frarådet selv om mesteparten av nettsidene i dag gjør det.
(Les mer om <a
href="http://stud.ntnu.no/~hornang/altes/index.php?page=design">design
på internett</a>).
Enkelte steder er vi imildertid nødt til å bruke ugyldig HTML-koding eller CSS-koding dette er fordi de ulike
nettleserene (les Internet Explorer) ikke tolker eller støtter kodene bra nok.</p>

<p>Designen på nettstedet baserer seg istedet på CSS. <a href="om.php?nostyle=yes&page=2">Ta en kikk</a> på hvordan
denne siden ville sett ut uten CSS (stilsett) aktivert. Siden du vil få fram er ren HTML (innhold uten
design). For dem som bruker tekstbaserte nettlesere er det viktig at sidene skal opptre strukturert og
oversiktelig selv om mangelen på layout fører til at innholdet bretter seg nedover siden. At sidene kan fungere uten layout
er også viktig for søkemotorer. Forstyrrende og ustrukturert html-koding i dokumentet gjør at siden blir indeksert med en lavere "kvalitets-indeks"
noe som gjør at den blir liggende lavere i søkeresultater.</p>

<p>Heldigvis er CSS noenlunde støttet i de fleste nettlesere i dag.
I dag bruker likevel de fleste nettsteder tabeller til utforming av
nettsteder, noe som ikke akkurat er med på å framskynde CSS-støtten i
nettleserene.</p>

<p>CSS versjon 2 kom ut i 1998. Fremdeles er det mange som irriterer seg over
<acronym title="Internet Explorer">IE</acronym>s manglende støtte for noen av CSS's funksjoner.
Det er mange som bruker IE, faktisk mesteparten. Dette nettstedet
bruker kun noen få funksjoner i CSS som ikke er støttet av IE.
Derfor vil sidene forhåpentligvis bli vist nesten helt riktig i alle de
vanlige nettleserene.</p>

<p>Nettstedet bruker <a href="http://www.php.net"><acronym title="Hypertext Processor">PHP</acronym></a> for å generere dynamiske sider.
<acronym title="HyperText Transfer Protocol">HTTP</acronym>-serveren er Apache. Alt som er av PHP-kode her
nå (utenom bildegalleriet) er laget helt fra bunnen av.</p>

<p>Hvis du har spørsmål er det bare å ta kontakt (enklest er e-post).</p>



<p><a href="http://folk.ntnu.no/~hornang/altes">Stig Hornangs
hjemmeside.</a></p>
<img src="graphics/stig_mail.gif" alt="stig på rozinante.net"/>


<?php endif; ?>

</div>

</div>


<?php include("right.php"); ?>

</div>

</body>

</html>
