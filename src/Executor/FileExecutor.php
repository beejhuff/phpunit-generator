<?php

namespace PhpUnitGen\Executor;

use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use PhpUnitGen\Configuration\ConfigurationInterface\ConsoleConfigInterface;
use PhpUnitGen\Exception\ExecutorException;
use PhpUnitGen\Executor\ExecutorInterface\ExecutorInterface;
use PhpUnitGen\Executor\ExecutorInterface\FileExecutorInterface;
use PhpUnitGen\Validator\ValidatorInterface\FileValidatorInterface;
use Respect\Validation\Validator;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class FileExecutor.
 *
 * @author     Paul Thébaud <paul.thebaud29@gmail.com>.
 * @copyright  2017-2018 Paul Thébaud <paul.thebaud29@gmail.com>.
 * @license    https://opensource.org/licenses/MIT The MIT license.
 * @link       https://github.com/paul-thebaud/phpunit-generator
 * @since      Class available since Release 2.0.0.
 */
class FileExecutor implements FileExecutorInterface
{
    /**
     * @var ConsoleConfigInterface $config The configuration to use.
     */
    private $config;

    /**
     * @var StyleInterface $output The output to display message.
     */
    private $output;

    /**
     * @var ExecutorInterface $executor The executor for php code.
     */
    private $executor;

    /**
     * @var FilesystemInterface $fileSystem The file system to use.
     */
    private $fileSystem;

    /**
     * @var FileValidatorInterface $fileValidator The file validator to know which files we need to parse.
     */
    private $fileValidator;

    /**
     * DirectoryParser constructor.
     *
     * @param ConsoleConfigInterface $config        A config instance.
     * @param StyleInterface         $output        An output to display message.
     * @param ExecutorInterface      $executor      A PhpUnitGen executor.
     * @param FilesystemInterface    $fileSystem    A file system instance.
     * @param FileValidatorInterface $fileValidator A file validator.
     */
    public function __construct(
        ConsoleConfigInterface $config,
        StyleInterface $output,
        ExecutorInterface $executor,
        FilesystemInterface $fileSystem,
        FileValidatorInterface $fileValidator
    ) {
        $this->config        = $config;
        $this->output        = $output;
        $this->executor      = $executor;
        $this->fileSystem    = $fileSystem;
        $this->fileValidator = $fileValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sourcePath, string $targetPath): void
    {
        if (! $this->fileValidator->validate($sourcePath)) {
            return;
        }

        $targetPathExists = $this->fileSystem->has($targetPath);

        if ($targetPathExists && ! $this->config->hasOverwrite()) {
            throw new ExecutorException(sprintf('The target file "%s" already exists.', $targetPath));
        }

        $code = $this->executor->execute($this->fileSystem->read($sourcePath));

        if ($targetPathExists) {
            $this->fileSystem->delete($targetPath);
        }
        $this->fileSystem->write($targetPath, $code);

        // Output that a file is parsed
        $this->output->text(sprintf('Parsing file "%s" completed.', $sourcePath));
    }
}