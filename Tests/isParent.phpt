--TEST--
isParent
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><div id="a"></div></body></html>');
$q->isParent()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [html] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [body] => Array
                                        (
                                            [children] => Array
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

                                        )

                                )

                        )

                )

        )

    [1] => Array
        (
            [body] => Array
                (
                    [children] => Array
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

                )

        )

)
