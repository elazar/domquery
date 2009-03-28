--TEST--
siblings
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><ul><li>1</li><li class="a">2</li><li>3</li></ul></body></html>');
$q->xpath('//ul/li')->dump();
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
                    [attributes] => Array
                        (
                            [class] => a
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => 2
                                )

                        )

                )

        )

    [2] => Array
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
