<?php

/**
 * This file is part of PhpUnitGen.
 *
 * (c) 2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace PhpUnitGen\Model\PropertyTrait;

/**
 * Trait FinalTrait.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
trait FinalTrait
{
    /**
     * @var bool $isFinal A boolean describing if it is final.
     */
    protected $isFinal = false;

    /**
     * @param bool $isFinal The new final value to set.
     */
    public function setIsFinal(bool $isFinal): void
    {
        $this->isFinal = $isFinal;
    }

    /**
     * @return bool True if it is final.
     */
    public function isFinal(): bool
    {
        return $this->isFinal;
    }
}
