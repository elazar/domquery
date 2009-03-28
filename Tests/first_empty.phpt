--TEST--
first empty
--FILE--
<?php
require_once '../DomQuery.php';
$q = new DomQuery();
var_dump($q->first()->count());
--EXPECT--
int(0)
