<?php
function print_news($filename) {

    $file = fopen("nyheter/" . $filename, "r");
    $meta = fgets($file, 4096);
    print("<div class=\"newslink\">");
    printf("<p class=\"imagetext\"><a name=\"%s\">%s</a></p>", $filename, $meta);
    $meta = fgets($file, 4096);
    setlocale (LC_TIME, "no_NO");
    printf("<p>Skrevet av <b>%s</b>, <i>%s</i></p>", $meta, strftime("%A %d %B %H:%M %G ", $filename));

    print("<div class=\"horizline\"></div>");


    while(!feof($file)) {

        $line = fgets($file, 4096);
        printf("%s", $line);
    }
    fclose($file);
    print("</div>");


}


function print_newsline($filename, $id) {

    $file = fopen("nyheter/" . $filename, "r");
    $title = fgets($file, 4096);
    $author = fgets($file, 4096);

    print("<div class=\"flatbox\">");

    setlocale (LC_TIME, "no_NO");
    printf("<p><b><a href=\"news.php?id=%s#%s\">%s</a></b> - <b>%s</b>, <i>%s</i></p>", $id, $filename, $title, $author, strftime("%A %d %B %H:%M:%S %G ", $filename));

    print("</div>");

}
?>
