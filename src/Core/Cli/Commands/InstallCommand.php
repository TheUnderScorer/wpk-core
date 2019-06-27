<?php

namespace UnderScorer\Core\Cli\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Install
 * @package UnderScorer\Core\Cli\Commands
 */
class InstallCommand extends BaseCommand
{

    /**
     * @var string
     */
    const PLUGIN_DIR = 'plugin_dir';

    /**
     * @var string
     */
    protected $commandName = 'app:install';

    /**
     * @var string
     */
    protected $commandDescription = 'Installs wpk-core plugin.';

    /**
     * @var string
     */
    protected $targetDir = '';

    /**
     * @var string
     */
    protected $pluginName = 'WPK Core';

    /**
     * @var string
     */
    protected $pluginDescription = 'WPK Core plugin';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName( $this->commandName )
            ->setDescription( $this->commandDescription )
            ->addArgument(
                self::PLUGIN_DIR,
                InputArgument::OPTIONAL,
                'Plugin directory name',
                'wpk-core'
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $this->targetDir         = getcwd() . '/' . $input->getArgument( self::PLUGIN_DIR );

        $output->writeln( "Creating plugin files at {$this->targetDir}" );

        $this->createTargetDir();
        $this->copyPlugin();

        $output->writeln( 'Plugin created!' );
    }

    /**
     * @return void
     */
    protected function createTargetDir(): void
    {
        if ( ! $this->filesystem->exists( $this->targetDir ) ) {
            $this->filesystem->mkdir( $this->targetDir );
        }
    }

    /**
     * @return void
     */
    protected function copyPlugin(): void
    {
        $pluginDir = $this->getPluginDir();

        $this->filesystem->mirror( $pluginDir, $this->targetDir );
    }

    /**
     * @return string
     */
    protected function getPluginDir(): string
    {
        return $this->rootDir . '/public';
    }

}
