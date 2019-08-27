<?php

namespace UnderScorer\Core\Bootstrap;

use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Filesystem\Filesystem;
use UnderScorer\Core\Database\Migrations\Migration;

/**
 * Class MigrationsBootstrap
 * @package UnderScorer\Core\Bootstrap
 */
class MigrationsBootstrap extends BaseBootstrap
{

    /**
     * Performs bootstrap of core functionality.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function bootstrap(): void
    {
        $fileSystem = $this->app->make( Filesystem::class );

        $migrationsFile = $this->getConfigDir() . 'migrations.php';

        if ( ! $fileSystem->exists( $migrationsFile ) ) {
            return;
        }

        $migrations = require $migrationsFile;

        $this->app->onActivation( function () use ( $migrations ) {
            $this->upMigrations( $migrations );
        } );

        $this->app->onDeactivation( function () use ( $migrations ) {
            $this->downMigrations( $migrations );
        } );
    }

    /**
     * @param array $migrations
     *
     * @throws BindingResolutionException
     */
    protected function upMigrations( array $migrations ): void
    {
        foreach ( $migrations as $migrationClass ) {

            /**
             * @var Migration $migration
             */
            $migration = $this->app->make( $migrationClass );

            $migration->up();
        }
    }

    /**
     * @param array $migrations
     *
     * @throws BindingResolutionException
     */
    protected function downMigrations( array $migrations ): void
    {
        foreach ( $migrations as $migrationClass ) {

            /**
             * @var Migration $migration
             */
            $migration = $this->app->make( $migrationClass );

            $migration->down();
        }
    }
}
