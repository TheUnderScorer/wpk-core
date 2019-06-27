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
    const PLUGIN_NAME = 'plugin_name';

    /**
     * @var string
     */
    const PLUGIN_DIR = 'plugin_dir';

    /**
     * @var string
     */
    const PLUGIN_DESCRIPTION = 'plugin_description';

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
    protected $pluginName = '';

    /**
     * @var string
     */
    protected $pluginDescription = '';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName( $this->commandName )
            ->setDescription( $this->commandDescription )
            ->addArgument(
                self::PLUGIN_NAME,
                InputArgument::REQUIRED,
                'Enter plugin name: '
            )
            ->addArgument(
                self::PLUGIN_DESCRIPTION,
                InputArgument::REQUIRED,
                'Enter plugin description: '
            )
            ->addArgument(
                self::PLUGIN_DIR,
                InputArgument::OPTIONAL,
                'Enter plugin directory [default: wpk-core]',
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
        $this->pluginDescription = $input->getArgument( self::PLUGIN_DESCRIPTION );
        $this->pluginName        = $input->getArgument( self::PLUGIN_NAME );

        $output->writeln( "Creating plugin files at {$this->targetDir}" );

        $this->createTargetDir();
        $this->copyPlugin();

        $output->writeln( 'Setting up plugin...' );

        $result = $this->setupPlugin();

        if ( $result ) {
            $output->writeln( 'Plugin created!' );
        } else {
            $output->writeln( 'Unable to create plugin.', Output::VERBOSITY_VERY_VERBOSE );
        }

        return $result;
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

    /**
     * @return bool
     */
    protected function setupPlugin()
    {
        $targetDir = $this->targetDir;

        $indexFile    = $targetDir . '/index.php';
        $indexContent = file_get_contents( $indexFile );

        $indexContent = str_replace(
            'Plugin Name: WPK Core',
            "Plugin Name: $this->pluginName",
            $indexContent
        );

        $indexContent = str_replace(
            'Description: WPK Core plugin framework',
            "Description: $this->pluginDescription",
            $indexContent
        );

        return (bool) file_put_contents( $indexFile, $indexContent );
    }

}
