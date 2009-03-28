--TEST--
index not found
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><p>test</p></body></html>');
$node = $q[3];
unset ($q[3]);
var_dump($q->index($node));
--EXPECT--
NULL
