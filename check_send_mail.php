<?php
ini_set('display_errors','on');
function getTime()
    {
    $a = explode (' ',microtime());
    return(double) $a[0] + $a[1];
    }
$Start = getTime(); 
mail('vietth@topica.edu.vn', 'Chuc mung ', 'Trúng ipad rồi nhé ');
$End = getTime();
echo "Time taken = ".number_format(($End - $Start),2)." secs"; 
?>