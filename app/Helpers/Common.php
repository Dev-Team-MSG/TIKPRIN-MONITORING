<?php 

function showDateTime($carbon, $format = "d M Y @ H:i"){
    // dd('carbon');
     return $carbon->translatedFormat($format);
 
 }

?>