--TEST--
ancestors
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><div id="test"></div></body></html>');
$q->element('div')->ancestors()->dump();
--EXPECT--
Array
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
                                                    [id] => test
                                                )

                                        )

                                )

                        )

                )

        )

    [1] => Array
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
                                                                            [id] => test
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
