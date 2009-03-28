--TEST--
fromHtmlFile
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtmlFile('fromHtmlFile.html');
$q->dump();
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
                                    [head] => Array
                                        (
                                            [children] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [title] => Array
                                                                (
                                                                    [children] => Array
                                                                        (
                                                                            [0] => Array
                                                                                (
                                                                                    [#text] => Test Page
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
                                                            [#text] => 

                                                        )

                                                    [1] => Array
                                                        (
                                                            [p] => Array
                                                                (
                                                                    [children] => Array
                                                                        (
                                                                            [0] => Array
                                                                                (
                                                                                    [#text] => Paragraph
                                                                                )

                                                                        )

                                                                )

                                                        )

                                                    [2] => Array
                                                        (
                                                            [#text] => 

                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

    [1] => Array
        (
            [head] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [title] => Array
                                        (
                                            [children] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [#text] => Test Page
                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

    [2] => Array
        (
            [title] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => Test Page
                                )

                        )

                )

        )

    [3] => Array
        (
            [#text] => Test Page
        )

    [4] => Array
        (
            [body] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => 

                                )

                            [1] => Array
                                (
                                    [p] => Array
                                        (
                                            [children] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [#text] => Paragraph
                                                        )

                                                )

                                        )

                                )

                            [2] => Array
                                (
                                    [#text] => 

                                )

                        )

                )

        )

    [5] => Array
        (
            [#text] => 

        )

    [6] => Array
        (
            [p] => Array
                (
                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => Paragraph
                                )

                        )

                )

        )

    [7] => Array
        (
            [#text] => Paragraph
        )

    [8] => Array
        (
            [#text] => 

        )

)
