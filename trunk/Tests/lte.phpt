--TEST--
lte
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div><div id="baz"></div></body></html>');
$q->element('div')->lte(1)->dump();
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

)
