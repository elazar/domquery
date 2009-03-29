--TEST--
fromNodeList
--FILE--
<?php
require_once '../DOMQuery.php';
$doc = new DomDocument();
$doc->load('fromXmlFile.xml');
$xpath = new DomXPath($doc);
$list = $xpath->query('//child');
$q = DOMQuery::fromNodeList($list);
$q->dump();
--EXPECT--
Array
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
