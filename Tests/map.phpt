--TEST--
map
--FILE--
<?php
function getId($node)
{
    $attr = $node->attributes->getNamedItem('id');
    if ($attr !== null)
    {
        return $attr->value;
    }
    return null;
}
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div><div id="baz"></div></body></html>');
print_r($q->hasAttribute('id')->map('getId'));
--EXPECT--
Array
(
    [0] => foo
    [1] => bar
    [2] => baz
)
