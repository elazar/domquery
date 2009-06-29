--TEST--
descendants
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="foo"><a href="bar"><strong>baz</strong></a></div></body></html>');
$q->element('div')->descendants()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [a] => Array
                (
                    [attributes] => Array
                        (
                            [href] => bar
                        )

                    [children] => Array
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

                )

        )

    [1] => Array
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

    [2] => Array
        (
            [#text] => baz
        )

)
