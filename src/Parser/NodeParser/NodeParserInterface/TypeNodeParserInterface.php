<?php

namespace PhpUnitGen\Parser\NodeParser\NodeParserInterface;

use PhpUnitGen\Model\PropertyInterface\TypeInterface;

/**
 * Interface TypeNodeParserInterface.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
interface TypeNodeParserInterface
{
    /**
     * Parse a node to update the parent node model.
     *
     * @param mixed         $node   The node to parse.
     * @param TypeInterface $parent The parent node.
     *
     * @return TypeInterface  The updated parent.
     */
    public function invoke($node, TypeInterface $parent): TypeInterface;
}