<?


$output = "auto-map.png";
printf("Rendering %s from position-file...", $output);

function alpha_rect($image, $x_start, $y_start, $w, $h, $ratio) {

	for($x = 0; $x <= $w; $x++) {
		for($y = 0; $y <= $h; $y++) {
			$prev_color = imagecolorat($image, $x_start + $x, $y_start + $y);
			$values = imagecolorsforindex($image, $prev_color);
			$values[red] = $values[red] * $ratio;	if($values[red] < 0) { $values[red]
= 0; };
			$values[green] = $values[green] * $ratio;	if($values[green] < 0) {
$values[green] = 0; };
			$values[blue] = $values[blue] * $ratio;	if($values[blue] < 0) {
$values[blue] = 0; };
			$color = imagecolorallocate($image, $values[red], $values[green], $values[blue]);
			imagesetpixel($image, $x_start + $x, $y_start + $y, $color);
		}
	}
}





$image = imagecreatefrompng ("maps/pacific.png");
$color_high = imagecolorallocate ( $image, 255, 70, 70);
$color_low = imagecolorallocate ( $image, 200, 0, 0);


$r = 590;
$lat0 = 0.9163;
$lon0 = -2.190;




$fp = fopen("news/positions/positions.txt", "r");

$first = true;


while(!feof($fp)) {
	$line = fgets ($fp, 4096);

	$parts = explode("/", $line);

	$pos_x = explode(" ", $parts[1]);
	$pos_y = explode(" ", $parts[2]);


	$pos_x_deg = substr($pos_x[0], 0, strlen($pos_x[0]) - 1) + substr($pos_x[1], 0, strlen($pos_x[1]) - 1) / 60;
	$pos_y_deg = substr($pos_y[0], 0, strlen($pos_y[0]) - 1) + substr($pos_y[1], 0, strlen($pos_y[1]) - 1) / 60;

	if($pos_x[2] == "W") {
		$pos_x_deg = -$pos_x_deg;
	}
	if($pos_y[2] == "S") {
		$pos_y_deg = -$pos_y_deg;
	}

	$lon = $pos_x_deg / 180 * 3.1415;
	$lat = -$pos_y_deg / 180 * 3.1415;

	$x = ($r * cos($lat) * sin($lon - $lon0)) + 401;
	$y = ($r * (cos($lat0) * sin($lat) - sin($lat0) * cos($lat) * cos($lon - $lon0))) + 234;

	if($first == true) {
		$first_x = $x;
		$first_y = $y;
		$first_parts = $parts;
		$first = false;
	}

	imagesetpixel ($image, $x, $y, $color_low);
	imagesetpixel ($image, $x + 1, $y, $color_low);
	imagesetpixel ($image, $x, $y + 1, $color_low);
	imagesetpixel ($image, $x + 1, $y + 1, $color_low);


}

fclose($fp);



$color_white = imagecolorallocate ( $image, 255, 255, 255);

$x_offset = -220;
$y_offset = 20;

$text_x = $first_x + $x_offset;
$text_y = $first_y + $y_offset;

alpha_rect($image, $text_x, $text_y, 170, 50, 0.8);
alpha_rect($image, $text_x, $text_y, 170, 15, 0.6);

imagerectangle ($image, $text_x, $text_y, $text_x + 170, $text_y + 50, 0);

imageline ($image, $text_x, $text_y + 16, $text_x + 170, $text_y + 16, 0);


$timetext = strftime("%H:%M %d. %b %Y %Z", $first_parts[0]);

imagestring ($image, 2, $text_x + 23, $text_y + 1, $timetext, $color_white);
imagestring ($image, 2, $text_x + 18, $text_y + 19, $first_parts[1], $color_white);
imagestring ($image, 2, $text_x + 18, $text_y + 32, $first_parts[2], $color_white);
imagestring ($image, 2, $text_x + 110, $text_y + 19, $first_parts[3] . " kts", $color_white);
imagestring ($image, 2, $text_x + 110, $text_y + 32, $first_parts[4] . "°", $color_white);

imageline ($image, $first_x, $first_y, $first_x + $x_offset + 169, $first_y + $y_offset - 1, 0);
imageline ($image, $first_x, $first_y, $first_x + $x_offset + 170, $first_y + $y_offset - 1, 0);
imageline ($image, $first_x, $first_y, $first_x + $x_offset + 171, $first_y + $y_offset, 0);

imagejpeg($image, $output);

printf("done\n");


imagedestroy ($image)

?>

