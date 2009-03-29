--TEST--
isLeaf
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="a"></div></body></html>');
$q->isLeaf()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => a
                        )

                )

        )

)
