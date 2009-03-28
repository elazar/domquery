--TEST--
classMatches
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><p class="foo">foo test</p><p class="foo bar">foo bar test</p><p class="bar baz">bar baz test</p></body></html>');
$q->classMatches('/^ba/')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [p] => Array
                (
                    [attributes] => Array
                        (
                            [class] => foo bar
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => foo bar test
                                )

                        )

                )

        )

    [1] => Array
        (
            [p] => Array
                (
                    [attributes] => Array
                        (
                            [class] => bar baz
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => bar baz test
                                )

                        )

                )

        )

)
