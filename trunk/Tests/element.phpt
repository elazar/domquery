--TEST--
element
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><a href="test1">test1_link</a><div id="separator"></div><a href="test2">test2_link</a></body></html>');
$q->element('a')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [a] => Array
                (
                    [attributes] => Array
                        (
                            [href] => test1
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => test1_link
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
                            [href] => test2
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => test2_link
                                )

                        )

                )

        )

)
