<?php

namespace PhpUnitGen\Parser\NodeParser;

use PhpParser\Node;
use PhpUnitGen\Model\ModelInterface\PhpFileModelInterface;
use PhpUnitGen\Model\PropertyInterface\NodeInterface;

/**
 * Class UseNodeParser.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class UseNodeParser implements NodeParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(Node $nodeToParse, NodeInterface $node): NodeInterface
    {
        /**
         * Overriding variable types.
         * @var Node\Stmt\Use_  $nodeToParse The namespace node to parse.
         * @var PhpFileModelInterface $node        The node which contains this namespace.
         */
        foreach ($nodeToParse->uses as $use) {
            if ($use->alias !== null) {
                $node->addUse($use->alias, $use->name->toString());
            } else {
                $node->addUse($use->name->getLast(), $use->name->toString());
            }
        }

        return $node;
    }
}