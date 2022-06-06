<?php

function nextChar($char){
    $nextchar = ++$char;
    if(strlen($nextchar) > 1){
        $nextchar = $nextchar[0];
    }
    return $nextchar;
}

echo nextChar('c')."<br>";
echo nextChar('a')."<br>";


function getChar($url){
    return substr($url, strrpos($url,'/')+1 )."<br>";
}

echo getChar('http://www.example.com/5478631');


?>