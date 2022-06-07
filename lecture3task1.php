<?php 

$twodimesions = [0 => [0=>'a' , 1=>'b' , 2=>'c' ],
                 1 => [0=>'x' , 1=>'b' , 2=>'a'],
                 2 => [0=>'z' , 1=>'z' , 2=>'v']
];

foreach($twodimesions as $key => $twodimesion){
    echo $key.' || ';
    foreach($twodimesion as $subkey => $value){
        $subkey.' : '.$value.'  ';
        echo $str = $value;
    }
    echo '<br>';
}


?>