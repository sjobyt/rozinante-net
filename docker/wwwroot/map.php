<?php
include("functions.php");
include("php_functions/letter_data.php");
include("php_functions/report_functions.php");
$style['standard'] = true;
$style['image'] = true;
print_htmlheader("Jorda rundt med Rozinante 2003-2006", $style, "");
?>

<body>



<?php include('bar.php'); ?>

<div id="wrap">


<div style="background: url('graphics/decoration.png') repeat-y #f4f3be; padding: 20px; padding-left: 60px;">

<h1>Posisjonsplotting av Rozinante</h1>
<?php /*
<p>Foreløpig funksjonalitet er
plotting av posisjonsmeldingene som mottas automatisk via Inmarsat
systemet (satelitt) ca. hver 1 time og 53 min. Kartet oppdateres
med siste mottatte posisjonsmelding hver hele time. Pga. denne
forskyvningen vil nyeste posisjonsmelding være opp til (maksimalt) 2 timer
og 53 min gammel og i beste fall 5 min gammel.</p>
*/ ?>

<img src="auto-zoommap.png" alt="" class="pic" style="width: 799px; height: 702px;" />

<img src="auto-map.png" alt="" class="pic" style="width: 800px; height: 603px;" />





</div>
</div>

</div>




</body>
</html>
