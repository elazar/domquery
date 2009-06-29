--TEST--
elementMatches
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><p><a href="#">Link</a></p></body></html>');
$q->elementMatches('/p|a/i')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [p] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [a] => Array
                                        (
                                            [attributes] => Array
                                                (
                                                    [href] => #
                                                )

                                            [children] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [#text] => Link
                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

    [1] => Array
        (
            [a] => Array
                (
                    [attributes] => Array
                        (
                            [href] => #
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => Link
                                )

                        )

                )

        )

)
