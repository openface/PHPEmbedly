<?php

require '../lib/embedly.php';

$params = array(
  'format' => 'json',
  'maxwidth' => 250,
  'maxheight' => '350',
);
$embedly = new Embedly('http://www.youtube.com/watch?v=60og9gwKh1o');
print $embedly->getResponse();

?>