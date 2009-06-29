<?php

/**
 * Wrapper for various features of the DOM extension to provide a subset of  
 * features offered by the jQuery object. Uses the SPL ArrayObject class as 
 * a base for storage and iteration.
 *
 * @author Matthew Turland <matt@ishouldbecoding.com>
 * @version 1.0
 * @see http://jquery.com
 */
class DOMQuery extends ArrayObject
{
    /**
     * Flag indicating whether or not DOM extension parse errors should be
     * displayed, defaults to TRUE
     *
     * @var bool
     */
    private static $showDomErrors = true;

    /**
     * Constructor to initialize the underlying ArrayObject with an empty array.
     *
     * @param array $nodes Array of nodes to use for the internal node list
     *                     (optional)
     * @return void
     */
    public function __construct(array $nodes = array())
    {
        parent::__construct($nodes);
    }

    /**
     * Sets a flag indicating whether or not DOM extension parse errors should
     * be suppressed.
     *
     * @param bool $flag TRUE to suppress errors, FALSE otherwise, defaults to
     *                   TRUE
     * @return void
     */
    public static function showDomErrors($flag = true)
    {
        self::$showDomErrors = $flag ? true : false;
    }

    /**
     * Modifies error reporting to prevent DOM extension parse errors from
     * being displayed based on the value of an associated internal flag
     * property.
     *
     * @see DomQuery::$_showDomErrors
     * @return int Previous error reporting level
     */
    private static function toggleDomErrors()
    {
        $level = error_reporting();
        if (!self::$showDomErrors) {
            error_reporting(E_ERROR);
        }
        return $level;
    }

    /**
     * Recursively adds a node and all its descendant nodes to a list.
     *
     * @param DomNode $node Root node of the document
     * @param ArrayObject $container Container for the nodes
     * @return void
     */
    private static function populate($node, &$container)
    {
        $currentNode = $node;

        while ($currentNode) {
            $container[] = $currentNode;

            if ($currentNode->firstChild) {
                $currentNode = $currentNode->firstChild;
            } elseif ($currentNode->nextSibling) {
                $currentNode = $currentNode->nextSibling;
            } else {
                do {
                    $currentNode = $currentNode->parentNode;
                } while (!$currentNode->nextSibling && !$currentNode->isSameNode($node));

                if ($currentNode->isSameNode($node)) {
                    break;
                }

                $currentNode = $currentNode->nextSibling;
            }
        }
    }

    /**
     * Swaps the current node list out for a given list.
     *
     * @param DomNodeList $list New list of nodes
     * @return DomQuery New instance
     */
    public static function fromNodeList(DomNodeList $list)
    {
        $q = new self();
        foreach ($list as $node) {
            $q->append($node);
        }
        return $q;
    }

    /**
      * Swaps the current node list out for a list derived from a given node
      * and its descendants.
      *
      * @param DomNode $node Node to analyze
      * @return DomQuery Current instance
      */
    public static function fromNode(DomNode $node)
    {
        $q = new self();
        self::populate($node, $q);
        return $q;
    }

    /**
     * Parses a given HTML string and appends its nodes to the current node
     * list.
     *
     * @param string $html HTML string to parse
     * @return DomQuery New instance
     */
    public static function fromHtml($html)
    {
        $q = new self();
        $doc = new DomDocument();
        $level = self::toggleDomErrors();
        $doc->loadHTML($html);
        error_reporting($level);
        self::populate($doc->documentElement, $q);
        return $q;
    }

    /**
     * Parses a given HTML file and appends its nodes to the current node
     * list.
     *
     * @param string $file Path to the HTML file to parse
     * @return DomQuery New instance
     */
    public static function fromHtmlFile($file)
    {
        $q = new self();
        $doc = new DomDocument();
        $level = self::toggleDomErrors();
        $doc->loadHTMLFile($file);
        error_reporting($level);
        self::populate($doc->documentElement, $q);
        return $q;
    }

    /**
     * Parses a given XML string and appends its nodes to the current node
     * list.
     *
     * @param string $xml XML string to parse
     * @return DomQuery New instance
     */
    public static function fromXml($xml)
    {
        $q = new self();
        $doc = new DomDocument();
        $level = self::toggleDomErrors();
        $doc->loadXML($xml);
        error_reporting($level);
        self::populate($doc->documentElement, $q);
        return $q;
    }

    /**
     * Parses a given XML file and appends its nodes to the current node
     * list.
     *
     * @param string $file Path to the XML file to parse
     * @return DomQuery New instance
     */
    public static function fromXmlFile($file)
    {
        $q = new self();
        $doc = new DomDocument();
        $level = self::toggleDomErrors();
        $doc->load($file);
        error_reporting($level);
        self::populate($doc->documentElement, $q);
        return $q;
    }

    /**
     * Recursively converts an array of nodes and their descendant nodes into
     * an associative array, mainly meant for use in debugging.
     *
     * @param array $nodes Array of nodes to convert
     * @return array Associative array equivalent
     */
    public function toArray($nodes = null)
    {
        $return = array();

        if ($nodes === null) {
            $nodes = $this;
        }

        foreach ($nodes as $node) {
            if ($node->nodeName == '#text') {
                $return[] = array($node->nodeName => $node->nodeValue);
                continue;
            }

            $array = array();

            if ($node->attributes) {
                $array['attributes'] = array();

                $index = 0;
                while (($attr = $node->attributes->item($index)) !== null) {
                    $array['attributes'][$attr->nodeName] = $attr->nodeValue;
                    $index++;
                }

                if (!count($array['attributes'])) {
                    unset ($array['attributes']);
                }
            }

            if ($node->hasChildNodes()) {
                $array['children'] = $this->toArray($node->childNodes);
            }

            $return[] = array($node->nodeName => $array);
        }

        return $return;
    }

    /**
     * Outputs a readable array equivalent of the current node list, mainly
     * meant for use in debugging.
     *
     * @return void
     */
    public function dump()
    {
        print_r($this->toArray());
    }

    /**
     * Searches the current node list for the position of a specific node.
     *
     * @param DomNode $subject Node to search for
     * @return int Offset of the node starting from 0, or null if the node is
     *             not found
     */
    public function index(DomNode $subject)
    {
        foreach ($this as $key => $node) {
            if ($subject->isSameNode($node)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Applies a callback to each node in a copy of the current node list and
     * returns the copy.
     *
     * @param callback $callback Callback to apply, which must accept a
     *                           single parameter (the current DomNode
     *                           instance)
     * @return DomQuery New DomQuery instance containing the node list copy
     *                  where the callback has been applied to each node
     */
    public function each($callback)
    {
        $nodes = array();

        foreach ($this as $node) {
            $nodes[] = $callback($node);
        }

        return new self($nodes);
    }

    /**
     * Applies a callback to filter nodes in the current node list into a new
     * list.
     *
     * @param callback $callback Callback to apply, which must accept a single
     *                           parameter (the current DomNode instance) and
     *                           return true if the node should be included
     *                           in the new list or false otherwise
     * @return DomQuery New DomQuery instance containing the new list
     */
    public function filter($callback)
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($callback($node)) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Applies a callback to each node in the current node list and returns
     * an array containing the resulting callback return values.
     *
     * @param callback $callback Callback to apply, which must accept a
     *                           single parameter (the current DomNode
     *                           instance)
     * @return array Resulting callback values ordered respectively to the
     *               current node list
     */
    public function map($callback)
    {
        $values = array();

        foreach ($this as $node) {
            $values[] = $callback($node);
        }

        return $values;
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute.
     *
     * @param string $name Name of the attribute to check for
     * @return DomQuery New DomQuery instance using the new list
     */
    public function hasAttribute($name)
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->attributes && $node->attributes->getNamedItem($name) !== null) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Constructs a lookup array indexed by the value of a given attribute
     * where the value of each array entry is an enumerated array of DomNode
     * instances with the corresponding attribute value.
     *
     * @param string $name Name of the attribute to index by
     * @return array Associative array of attribute values mapped to arrays
     *               of corresponding nodes
     */
    public function attributeMap($name)
    {
        $values = array();

        foreach ($this as $node) {
            if ($node->attributes && $attr = $node->attributes->getNamedItem($name)) {
                $value = $attr->value;

                if (!isset ($values[$value])) {
                    $values[$value] = array();
                }

                $values[$value][] = $node;
            }
        }

        return $values;
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute with a given value.
     *
     * @param string $name Name of the attribute to check for
     * @param string $value Attribute value to check for
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeEquals($name, $value)
    {
        $nodes = array();

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if ($value == $valueIndex) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute that does not have a given value.
     *
     * @param string $name Name of the attribute to check for
     * @param string $value Attribute value to check for
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeNotEquals($name, $value)
    {
        $nodes = array();

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if ($value != $valueIndex) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute with a value that starts with
     * a given string.
     *
     * @param string $name Name of the attribute to check for
     * @param string $value String to check for at the start of the attribute
     *                      value
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeStartsWith($name, $value)
    {
        $nodes = array();

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if (strpos($valueIndex, $value) === 0) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute with a value that ends with a
     * given string.
     *
     * @param string $name Name of the attribute to check for
     * @param string $value String to check for at the end of the attribute
     *                      value
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeEndsWith($name, $value)
    {
        $nodes = array();
        $offset = strlen($value)  * -1;

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if (substr($valueIndex, $offset) == $value) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute with a value that contains a
     * given string.
     *
     * @param string $name Name of the attribute to check for
     * @param string $value String to check for in the attribute value
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeContains($name, $value)
    {
        $nodes = array();

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if (strpos($valueIndex, $value) !== false) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given attribute with a value that matches a
     * given PCRE-compatible regular expression.
     *
     * @param string $name Name of the attribute to check for
     * @param string $expr Regular expression to match the attribute value
     *                     against
     * @return DomQuery New DomQuery instance using the new list
     */
    public function attributeMatches($name, $expr)
    {
        $nodes = array();

        foreach ($this->attributeMap($name) as $valueIndex => $valueNodes) {
            if (preg_match($expr, $valueIndex) > 0) {
                $nodes = array_merge($nodes, $valueNodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a given node/tag name.
     *
     * @param string $element Node/tag name to check for
     * @return DomQuery New DomQuery instance using the new list
     */
    public function element($element)
    {
        $element = strtolower($element);
        $nodes = array();

        foreach ($this as $node) {
            if (strtolower($node->nodeName) == $element) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list have a node/tag name that matches a given
     * PCRE-compatible regular expression.
     *
     * @param string $expr Regular expression to match against
     * @return DomQuery New DomQuery instance using the new list
     */
    public function elementMatches($expr)
    {
        $nodes = array();

        foreach ($this as $node) {
            if (preg_match($expr, $node->nodeName) > 0) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list contain a specified item in their class attributes.
     *
     * @param string $class Name of the class to check for
     * @return DomQuery New DomQuery instance using the new list
     */
    public function hasClass($class)
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->attributes) {
                $attr = $node->attributes->getNamedItem('class');
                if ($attr !== null && in_array($class, explode(' ', $attr->nodeValue))) {
                    $nodes[] = $node;
                }
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a copy of the current node list filtered such that all nodes
     * in the new list contain one or more items in their class attributes
     * that match a given PCRE-compatible regular expression.
     *
     * @param string $expr Regular expression to match against
     * @return DomQuery New DomQuery instance using the new list
     */
    public function classMatches($expr)
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->attributes) {
                $attr = $node->attributes->getNamedItem('class');
                if ($attr !== null && count(preg_grep($expr, explode(' ', $attr->nodeValue))) > 0) {
                    $nodes[] = $node;
                }
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all ancestor nodes of each node in the
     * current node list.
     *
     * @return DomQuery New DomQuery instance containing the ancestor nodes
     */
    public function ancestors()
    {
        $nodes = array();

        foreach ($this as $node) {
            $parentNode = $node->parentNode;
            while ($parentNode && $parentNode->nodeName != '#document') {
                $nodes[] = $parentNode;
                $parentNode = $parentNode->parentNode;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all parent nodes of each node in the
     * current node list.
     *
     * @return DomQuery New DomQuery instance containing the parent nodes
     */
    public function parents()
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->parentNode) {
                $nodes[] = $node->parentNode;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all descendant nodes of each node in
     * the current node list.
     *
     * @return DomQuery New DomQuery instance containing the descendant nodes
     */
    public function descendants()
    {
        $nodes = array();

        foreach ($this as $node) {
            foreach ($node->childNodes as $childNode) {
                self::populate($childNode, $nodes);
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all immediate child nodes of each node
     * in the current node list.
     *
     * @return DomQuery New DomQuery instance containing the child nodes
     */
    public function children()
    {
        $nodes = array();

        foreach ($this as $node) {
            $childNodes = array();
            foreach ($node->childNodes as $childNode) {
                $childNodes[] = $childNode;
            }
            $nodes = array_merge($nodes, $childNodes);
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing the next immediate sibling node of each
     * node in the current node list.
     *
     * @return DomQuery New DomQuery instance containing the sibling nodes
     */
    public function next()
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->nextSibling) {
                $nodes[] = $node->nextSibling;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all sibling nodes following each node
     * in the current node list.
     *
     * @return DomQuery New DomQuery instance containing the sibling nodes
     */
    public function nextAll()
    {
        $nodes = array();

        foreach ($this as $node) {
            $nextSibling = $node->nextSibling;
            while ($nextSibling) {
                $nodes[] = $nextSibling;
                $nextSibling = $nextSibling->nextSibling;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a list containing the previous immediate sibling node of each
     * node in the current node list.
     *
     * @return DomQuery New DomQuery instance containing the sibling nodes
     */
    public function prev()
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->previousSibling) {
                $nodes[] = $node->previousSibling;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all sibling nodes preceding each node
     * in the current node list.
     *
     * @return DomQuery New DomQuery instance containing the sibling nodes
     */
    public function prevAll()
    {
        $nodes = array();

        foreach ($this as $node) {
            $previousSibling = $node->previousSibling;
            while ($previousSibling) {
                $nodes[] = $previousSibling;
                $previousSibling = $previousSibling->previousSibling;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all sibling nodes for each node in the
     * current node list.
     *
     * @return DomQuery New DomQuery instance containing the sibling nodes
     */
    public function siblings()
    {
        $nodes = array();

        foreach ($this as $node) {
            $nextSibling = $node->parentNode->firstChild;
            while ($nextSibling) {
                if (!$nextSibling->isSameNode($node)) {
                    $nodes[] = $nextSibling;
                }
                $nextSibling = $nextSibling->nextSibling;
            }
        }

        return new self($nodes);
    }

    /**
     * Convenience method to return the first node in the current node list.
     *
     * @return DomNode
     */
    public function first()
    {
        if ($this->count() > 0) {
            return new self(array($this[0]));
        }
        return new self();
    }

    /**
     * Convenience method to return the last node in the current node list.
     *
     * @return DomNode
     */
    public function last()
    {
        $count = $this->count();
        if ($count > 0) {
            return new self(array($this[$count - 1]));
        }
        return new self();
    }

    /**
     * Returns a node list containing nodes from the current node list with
     * a position within the list that is evenly divisible by 2.
     *
     * @return DomQuery
     */
    public function even()
    {
        $nodes = array();

        foreach ($this as $key => $node) {
            if ($key % 2 == 0) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing nodes from the current node list with
     * a position within the list that is not evenly divisible by 2.
     *
     * @return DomQuery
     */
    public function odd()
    {
        $nodes = array();

        foreach ($this as $key => $node) {
            if ($key % 2 == 1) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing nodes from the current node list with
     * a position within the list that is evenly divisible by a given divisor,
     * excluding the first node in the list.
     *
     * @param int $n Divisor
     * @return DomQuery
     */
    public function nth($n)
    {
        $nodes = array();

        foreach ($this as $key => $node) {
            if ($key == 0) {
                continue;
            }

            if ($key % $n == 0) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing a single node in a specified position
     * within the current node list.
     *
     * @param int $index List position of the desired node, starting from 0
     * @return DomQuery
     */
    public function eq($index)
    {
        return new self(array($this[$index]));
    }

    /**
     * Returns a row list containing a slice of the current node list past a
     * given position.
     *
     * @param int $index Position of the last node to exclude, starting from 0
     * @return DomQuery
     */
    public function gt($index)
    {
        return new self(array_slice($this->getArrayCopy(), $index + 1));
    }

    /**
     * Returns a row list containing a slice of the current node list at or
     * past a given position.
     *
     * @param int $index Position of the last node to exclude, starting from 0
     * @return DomQuery
     */
    public function gte($index)
    {
        return new self(array_slice($this->getArrayCopy(), $index));
    }

    /**
     * Returns a node list containing a slice of the current node list before a
     * given position.
     *
     * @param int $index Position of the last node to include, starting from 0
     * @return DomQuery
     */
    public function lt($index)
    {
        return new self(array_slice($this->getArrayCopy(), 0, $index));
    }

    /**
     * Returns a node list containing a slice of the current node list before
     * or at a given position.
     *
     * @param int $index Position of the last node to include, starting from 0
     * @return DomQuery
     */
    public function lte($index)
    {
        return new self(array_slice($this->getArrayCopy(), 0, $index + 1));
    }

    /**
     * Returns a node list containing parent nodes of all nodes in the
     * current node list with a child text node containing a specified string.
     *
     * @param string $text String to check for within the text node value
     * @return DomQuery
     */
    public function contains($text)
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->nodeType == XML_TEXT_NODE && strpos($node->nodeValue, $text) !== false) {
                $nodes[] = $node->parentNode;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all nodes in the current node list that
     * have any child nodes.
     *
     * @return DomQuery
     */
    public function isParent()
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->hasChildNodes()) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all nodes in the current node list that
     * do not have any child nodes.
     *
     * @return DomQuery
     */
    public function isLeaf()
    {
        $nodes = array();

        foreach ($this as $node) {
            if (!$node->hasChildNodes()) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a node list containing all nodes in the current node list that
     * have only one child node.
     *
     * @return DomQuery
     */
    public function only()
    {
        $nodes = array();

        foreach ($this as $node) {
            if ($node->childNodes->length == 1) {
                $nodes[] = $node;
            }
        }

        return new self($nodes);
    }

    /**
     * Returns a string containing the content of all text nodes in the
     * current node list.
     *
     * @return string
     */
    public function text()
    {
        $text = '';

        foreach ($this->descendants()->element('#text') as $node) {
            $text .= $node->textContent;
        }

        return $text;
    }

    /**
     * Returns a node list comprised of a slice of the current node list.
     *
     * @param int $start Starting point for the slice
     * @param int $end Ending point for the slice, or null to extent to the
     *                 end of the current node list (optional)
     * @return DomQuery
     */
    public function slice($start, $end = null)
    {
        if ($end === null) {
            return new self(array_slice($this->getArrayCopy(), $start));
        } else {
            return new self(array_slice($this->getArrayCopy(), $start, $end - $start + 1));
        }
    }

    /**
     * Returns a node list containing all the nodes in the current node list
     * that match a given XPath expression. Assumes that all nodes in the
     * current node list originate from the same document.
     *
     * @param string $expr XPath expression
     * @return DomQuery
     */
    public function xpath($expr)
    {
        $xpath = new DOMXPath($this[0]->ownerDocument);

        return self::fromNodeList($xpath->query($expr));
    }
}
