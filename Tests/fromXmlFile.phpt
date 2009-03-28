--TEST--
fromXmlFile
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromXmlFile('fromXmlFile.xml');
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
