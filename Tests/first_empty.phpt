--TEST--
first empty
--FILE--
<?php
require_once '../DOMQuery.php';
$q = new DOMQuery();
var_dump($q->first()->count());
--EXPECT--
int(0)
