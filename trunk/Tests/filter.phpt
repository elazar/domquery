--TEST--
filter
--FILE--
<?php
function divWithId($node)
{
    return ($node->nodeName == 'div' && $node->attributes->getNamedItem('id') !== null);
}
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div><div id="baz"></div></body></html>');
$q->filter('divWithId')->dump();
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
                            [id] => bar
                        )

                )

        )

    [2] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => baz
                        )

                )

        )

)
