--TEST--
each
--FILE--
<?php
function getFirstSibling($node)
{
    return $node->parentNode->firstChild;
}
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div></body></html>');
$q->element('div')->each('getFirstSibling')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => foo
                        )

                )

        )

    [1] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => foo
                        )

                )

        )

)
