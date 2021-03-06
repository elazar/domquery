--TEST--
siblings
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><ul><li>1</li><li class="a">2</li><li>3</li></ul></body></html>');
$q->hasClass('a')->siblings()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [li] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => 1
                                )

                        )

                )

        )

    [1] => Array
        (
            [li] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => 3
                                )

                        )

                )

        )

)
