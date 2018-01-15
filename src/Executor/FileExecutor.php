<?php

namespace PhpUnitGen\Executor;

use League\Flysystem\FilesystemInterface;
use PhpUnitGen\Configuration\ConfigurationInterface\ConsoleConfigInterface;
use PhpUnitGen\Exception\ExecutorException;
use PhpUnitGen\Exception\NotReadableFileException;
use PhpUnitGen\Executor\ExecutorInterface\ExecutorInterface;
use PhpUnitGen\Executor\ExecutorInterface\FileExecutorInterface;
use PhpUnitGen\Validator\ValidatorInterface\FileValidatorInterface;
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

        $this->checkTargetPath($targetPath);

        $content = $this->fileSystem->read($sourcePath);

        if ($content === false) {
            throw new NotReadableFileException(sprintf('The file "%s" is not readable.', $sourcePath));
        }

        // We ignore the type checked because we already check the readability
        $code = $this->executor->execute($content);

        $this->fileSystem->write($targetPath, $code);

        // Output that a file is parsed
        $this->output->text(sprintf('Parsing file "%s" completed.', $sourcePath));
    }

    /**
     * Check if an old file exists. If overwrite option is activated, delete it, else, throw an exception.
     *
     * @param string $targetPath The target file path.
     *
     * @throws ExecutorException If overwrite option is deactivated and file exists.
     */
    public function checkTargetPath(string $targetPath): void
    {
        $targetPathExists = $this->fileSystem->has($targetPath);

        if ($targetPathExists && ! $this->config->hasOverwrite()) {
            throw new ExecutorException(sprintf('The target file "%s" already exists.', $targetPath));
        }

        if ($targetPathExists) {
            $this->fileSystem->delete($targetPath);
        }
    }
}