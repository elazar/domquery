--TEST--
attributeStartsWith
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div><div id="baz"></div></body></html>');
$q->attributeStartsWith('id', 'ba')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => bar
                        )

                )

        )

    [1] => Array
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
