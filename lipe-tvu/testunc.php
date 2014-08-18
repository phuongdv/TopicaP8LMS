<?php
header ('Content-Type: text/plain; charset=ISO-8859-2');

$encoded = unicode_encode ('\u0150\u0179', 'ISO-8859-2');

echo 'The string itself:', $encoded, PHP_EOL;
echo 'The length of the string: ', strlen ($encoded);
?>
