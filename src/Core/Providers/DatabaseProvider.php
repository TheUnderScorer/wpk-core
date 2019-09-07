<?php

namespace UnderScorer\Core\Providers;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Grammars\Grammar;
use UnderScorer\Core\Database\Migrations\Blueprint;
use UnderScorer\Core\Database\Migrations\Migration;
use UnderScorer\Core\Database\MySql\MySqlGrammar;
use UnderScorer\ORM\Eloquent\Database;

/**
 * Class DatabaseProvider
 * @package UnderScorer\Core\Providers
 */
class DatabaseProvider extends ServiceProvider
{

    /**
     * Registers service
     */
    public function register(): void
    {
        $this->app->singleton( ConnectionInterface::class, function () {
            return Database::instance();
        } );

        $this->app->bind( Grammar::class, MySqlGrammar::class );
        $this->app->bind( Blueprint::class );
        $this->app->bind( Migration::class );
    }

}
