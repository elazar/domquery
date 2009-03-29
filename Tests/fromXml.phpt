--TEST--
fromXml
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromXml('<?xml version="1.0"?><root><child attribute="value">text</child></root>');
$q->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [root] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [child] => Array
                                        (
                                            [attributes] => Array
                                                (
                                                    [attribute] => value
                                                )

                                            [children] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [#text] => text
                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

    [1] => Array
        (
            [child] => Array
                (
                    [attributes] => Array
                        (
                            [attribute] => value
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => text
                                )

                        )

                )

        )

    [2] => Array
        (
            [#text] => text
        )

)
