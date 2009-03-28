--TEST--
last empty
--FILE--
<?php
require_once '../DomQuery.php';
$q = new DomQuery();
var_dump($q->last()->count());
--EXPECT--
int(0)
