--TEST--
hasClass
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><a class="foo bar">test_foo</a><a class="bar">test_bar</a><div id="baz"></div></body></html>');
$q->hasClass('foo')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [a] => Array
                (
                    [attributes] => Array
                        (
                            [class] => foo bar
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => test_foo
                                )

                        )

                )

        )

)
