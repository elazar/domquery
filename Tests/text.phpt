--TEST--
text
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div>This is a <strong><em>really</em></strong> interesting <span id="test">test</span>.</div></body></html>');
var_dump($q->element('body')->text());
--EXPECT--
string(34) "This is a really interesting test."
