<?php

function make_letter_list () {

    $letters = "news/letters/";
    $letternum = 0;

    $directory = opendir($letters);

    while (false !== ($dir = readdir($directory))) {
        $dirs[$letternum] = $dir;
        $letternum++;
    }

    closedir($directory);


    array_shift ($dirs);
    array_shift ($dirs);
    rsort($dirs);

    return($dirs);

}





function read_letter($no) {


    $letter_dir = "news/letters/" . $no . "/";
    $dirname = opendir($letter_dir);

    while (false !== ($file = readdir($dirname))) {
        if(!($file == "." || $file == "..")) {
	    $dir_size +=  filesize($letter_dir . $file) / 1000 ;
	}
    }



    closedir($dirname);

    $index_file = $letter_dir . "index.txt";


    $idx = fopen($index_file, "r");

    while(!feof($idx)) {

	$line = fgets ($idx, 4067);
	$type = substr($line, 0, 5);

	if($type == "info:") {

	    $meta = explode ("_", substr($line, 6), 4);
	    setlocale ( LC_TIME, "no_NO");
	    $pubtime = strftime("publisert: %a %d %B %H:%M", filemtime($index_file));
	    $date = strftime("%a %d %B %H:%M", strtotime($meta[2]) );

	} elseif($type == "docu:") {

	    $doc_count++;
	    $docu = explode("_", substr($line, 6));
	    $doc_file[$doc_count] = $docu[0];
	    $doc_title[$doc_count] = rtrim ( $docu[1] , "\n");

	}
    }

    fclose($idx);



    $desc_filename = $letter_dir . "desc.txt";

    if(is_readable ($desc_filename)) {

	$desc_file = fopen($desc_filename, "r");

	$first = false;
	$description = false;

	while(!feof($desc_file)) {

	    $line = fgets ($desc_file, 4067);

	    if($first == true) {
		$description .= $line;
		$first = false;
	    } else {
		$description .= $line . "<br/>";
	    }

	}

	fclose($desc_file);
    }

    $meta[3] = $dir_size;

    $data[0] = filemtime($index_file);
    $data[1] = $meta;
    $data[2] = $doc_file;
    $data[3] = $doc_title;
    $data[4] = $description;

    return($data);


}


function size_conv($dir_size) {
    if($dir_size >= 1000) {
	$dir_size = number_format($dir_size / 1000, 2, ',', ' ')  . " Mb";
    } elseif ($dir_size >= 1) {
	$dir_size = number_format($dir_size / 1, 0, ',', ' ')  . " kb";
    } elseif ($dir_size < 1) {
	$dir_size = number_format($dir_size * 1000, 0, ',', ' ')  . " byte";
    }
    return $dir_size;

}
?>