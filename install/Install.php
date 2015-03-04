<?php

namespace Spear;

use Composer\IO\IOInterface;
use GitWrapper\GitWrapper;

class Install
{
    const
        COMPOSER_FILENAME = 'composer.json',
        COMPOSER_PROJECT_NAME_TO_REPLACE = 'silex-spear-skeleton',
        COMPOSER_NAMESPACE_TO_REPLACE = 'Spear\\\\Skeleton',
        NAMESPACE_TO_REPLACE = 'Spear\Skeleton';

    private
        $io,
        $git,
        $rootPath;

    public function __construct(IOInterface $io, GitWrapper $git)
    {
        $this->io = $io;
        $this->rootPath = __DIR__ . '/../';
        $this->git = $git;
    }

    public function process()
    {
        $vendorName = $this->askVendorName();
        $appName = $this->askAppName();

        $namespace = sprintf('%s\%s', $vendorName, $appName);

        $this->confirmInitialization($namespace);
        $this->initializeGitRepository();

//         $this->replaceNamespaces($namespace);

        $this->output('    <info>composer.json</info>');
        $this->replaceComposerJsonNamespacePsr4Declaration($namespace);
        $this->replaceComposerJsonProjectName($vendorName, $appName);

        $this->output('Done.');
    }
    
    private function initializeGitRepository()
    {
        $this->output('Initializing empty git repository');

        $this->git->init($this->rootPath);
    }
    
    private function replaceComposerJsonProjectName($vendorName, $appName)
    {
        $inlineProjectName = implode('-', array(
            $vendorName,
            $appName
        ));

        $composerJsonPath = $this->rootPath . self::COMPOSER_FILENAME;

        $this->replaceStringInFile(self::COMPOSER_PROJECT_NAME_TO_REPLACE, $inlineProjectName, $composerJsonPath);
    }

    private function replaceComposerJsonNamespacePsr4Declaration($namespace)
    {
        $composerJsonPath = $this->rootPath . self::COMPOSER_FILENAME;

        $this->replaceStringInFile(self::COMPOSER_NAMESPACE_TO_REPLACE, str_replace('\\', '\\\\', $namespace), $composerJsonPath);
    }

    private function replaceNamespaces($namespace)
    {
        $this->outputForVerboseLevel('<comment>Replacing namespaces</comment>');

        $filesToReplaceNamespaces = array(
            'src/Application.php',
            'src/Console.php',
            'src/Commands/GreetCommand.php',
            'src/Controllers/Home/Provider.php',
            'src/Controllers/Home/Controller.php',
            'www/index.php',
            'console',
        );

        foreach($filesToReplaceNamespaces as $path)
        {
            $this->outputForVerboseLevel(sprintf('    <info>%s</info>', $path));

            $filepath = $this->rootPath . $path;

            $this->replaceStringInFile(self::NAMESPACE_TO_REPLACE, $namespace, $filepath);
        }
    }

    private function replaceStringInFile($search, $replace, $filepath)
    {
        $content = file_get_contents($filepath);

        $content = str_replace($search, $replace, $content);

        file_put_contents($filepath, $content);
    }

    private function confirmInitialization($namespace)
    {
        $confirmation = $this->io->askConfirmation(sprintf('Initialize project with namespace <comment>%s</comment> [Y]N ? ', $namespace));

        if(! $confirmation)
        {
            $this->output('<warning>Initialization aborted.</warning>');

            exit(0);
        }
    }

    private function askVendorName()
    {
        return $this->io->askAndValidate('vendor name : ', function($answer) {
            if(! preg_match('~^\w+$~', $answer))
            {
                throw new \InvalidArgumentException('Invalid vendor name');
            }

            return $answer;
        });
    }

    private function askAppName()
    {
        return $this->io->askAndValidate('application name : ', function($answer) {
            if(! preg_match('~^\w+$~', $answer))
            {
                throw new \InvalidArgumentException('Invalid vendor name');
            }

            return $answer;
        });
    }

    private function outputForVerboseLevel($message)
    {
        if($this->io->isVerbose())
        {
            $this->output($message);
        }
    }

    private function output($message)
    {
        $this->io->write($message);
    }
}
