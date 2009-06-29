--TEST--
children
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"><a href="bar"><strong>baz</strong></a></div></body></html>');
$q->element('a')->children()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [strong] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => baz
                                )

                        )

                )

        )

)
