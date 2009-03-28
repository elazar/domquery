--TEST--
nth
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><div id="foo"></div><div id="bar"></div><div id="baz"></div></body></html>');
$q->element('div')->nth(2)->dump();
--EXPECT--
Array
(
    [0] => Array
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