
<?php $fh = fopen('/proc/meminfo');
$mem = 0;
while ($line = fgets($fh)) {
  $pieces = array();
  if (preg_match('^MemTotal:\s+(\d+)\skB$', $line, $pieces)) {
    $mem = $pieces[1];
    break;
  }
}

echo "$mem kB RAM found"; ?>
