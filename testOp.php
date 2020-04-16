<?php
$date = new DateTime('2011-12-27');
//$date->add(new DateInterval('P1Y'));
$date->add(new DateInterval('P1M'));
echo $date->format('Y-m-d') . "\n";

?>