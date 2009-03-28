--TEST--
contains
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><div id="a">test at start</div><div id="b">ending test</div><div id="c">in test middle</div><div id="d">test</div><div id="e">none</div></body></html>');
$q->contains('test')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => a
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => test at start
                                )

                        )

                )

        )

    [1] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => b
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => ending test
                                )

                        )

                )

        )

    [2] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => c
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => in test middle
                                )

                        )

                )

        )

    [3] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => d
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => test
                                )

                        )

                )

        )

)
