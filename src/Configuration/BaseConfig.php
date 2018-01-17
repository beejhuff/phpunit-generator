<?php

namespace PhpUnitGen\Configuration;

use PhpUnitGen\Configuration\ConfigurationInterface\ConfigInterface;
use PhpUnitGen\Exception\InvalidConfigException;
use Respect\Validation\Validator;

/**
 * Class BaseConfig.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class BaseConfig implements ConfigInterface
{
    protected const DEFAULT_CONFIG = [
        'interface' => false,
        'auto'      => true,
        'phpdoc'    => []
    ];

    /**
     * @var array $config The configuration as an array.
     */
    protected $config;

    /**
     * ArrayConfig constructor.
     *
     * @param mixed $config The config array to use.
     */
    public function __construct($config = BaseConfig::DEFAULT_CONFIG)
    {
        $this->validate($config);

        $this->config = $config;
    }

    /**
     * Validate a configuration to know if it can be used to construct an instance.
     *
     * @param mixed $config The configuration to validate.
     *
     * @throws InvalidConfigException If the $config is invalid.
     */
    protected function validate($config): void
    {
        // Check that $config is an array
        if (! Validator::arrayType()->validate($config)) {
            throw new InvalidConfigException('The config must be an array.');
        }

        // Check boolean parameters
        if (! Validator::key('interface', Validator::boolType())->validate($config)) {
            throw new InvalidConfigException('"interface" parameter must be set as a boolean.');
        }
        if (! Validator::key('auto', Validator::boolType())->validate($config)) {
            throw new InvalidConfigException('"auto" parameter must be set as a boolean.');
        }

        $this->validatePhpdoc($config);
    }

    /**
     * Validate the phpdoc key in the config array.
     *
     * @param mixed $config The configuration.
     *
     * @throws InvalidConfigException If the phpdoc is invalid (source or target).
     */
    private function validatePhpdoc($config): void
    {
        // Check that dirs key exists
        if (! Validator::key('phpdoc', Validator::arrayType())->validate($config)) {
            throw new InvalidConfigException('"phpdoc" parameter is not an array.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasInterfaceParsing(): bool
    {
        return $this->config['interface'];
    }

    /**
     * {@inheritdoc}
     */
    public function hasAuto(): bool
    {
        return $this->config['auto'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplatesPath(): string
    {
        return __DIR__ . '/../../templates';
    }

    /**
     * {@inheritdoc}
     */
    public function getPhpDoc(): array
    {
        return $this->config['phpdoc'];
    }
}
