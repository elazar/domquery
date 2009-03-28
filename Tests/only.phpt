--TEST--
only
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><div></div><div><span></span></div></body></html>');
$q->only()->dump();
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
                                                                )

                                                        )

                                                    [1] => Array
                                                        (
                                                            [div] => Array
                                                                (
                                                                    [children] => Array
                                                                        (
                                                                            [0] => Array
                                                                                (
                                                                                    [span] => Array
                                                                                        (
                                                                                        )

                                                                                )

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
            [div] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [span] => Array
                                        (
                                        )

                                )

                        )

                )

        )

)
