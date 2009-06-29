--TEST--
last empty
--FILE--
<?php
require_once '../DOMQuery.php';
$q = new DOMQuery();
var_dump($q->last()->count());
--EXPECT--
int(0)
