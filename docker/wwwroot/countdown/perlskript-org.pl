#!/usr/bin/perl

    use strict;
    use warnings;

    use Date::Calc qw(Day_of_Year Today );

    my $year = 2003;
    my $month = 7;
    my $day = 5;

    my $that_day   = Day_of_Year( $year , $month , $day );
    my $this_day   = Day_of_Year( Today([ localtime ]) );
    my $days_left  = $that_day - $this_day;


    my( $num1, $num2 ) = split //, $days_left;


    chdir "/var/www/rozinante/countdown";

    system "cp $num2.gif second_num.gif";

    my $prev_num = ($num1 . $num2) + 1;

    system "gifsicle --loopcount=10 -S 300x70 --pos=5,24 --delay 100 bg.gif --delay 100 --pos=21,26 second_num.gif --pos=38,22 --delay 10 dager_blur.gif --delay 100 --pos=38,14 dager.gif --delay 10 --pos=122,21 igjen_blur.gif --delay 300 --pos=125,21 igjen.gif > anim_" . $num1 . $num2 . ".gif";
    system "rm anim_$prev_num.gif";
