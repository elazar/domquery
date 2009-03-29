--TEST--
index
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body></body></html>');
var_dump($q->index($q[1]));
--EXPECT--
int(1)
