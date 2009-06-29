--TEST--
next
--FILE--
<?php
require_once '../DOMQuery.php';
$q = DOMQuery::fromHtml('<html><body><label for="foo">Foo</label><input type="text" name="foo"></body></html>');
$q->element('label')->next()->dump();
--EXPECT--
Array
(
    [0] => Array
        (
            [input] => Array
                (
                    [attributes] => Array
                        (
                            [type] => text
                            [name] => foo
                        )

                )

        )

)
