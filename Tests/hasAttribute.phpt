--TEST--
hasAttribute
--FILE--
<?php
require_once '../DomQuery.php';
$q = DomQuery::fromHtml('<html><body><div>foo</div><div id="test">bar</div><div>baz</div></body></html>');
$q->hasAttribute('id')->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [div] => Array
                (
                    [attributes] => Array
                        (
                            [id] => test
                        )

                    [children] => Array
                        (
                            [0] => Array
                                (
                                    [#text] => bar
                                )

                        )

                )

        )

)
