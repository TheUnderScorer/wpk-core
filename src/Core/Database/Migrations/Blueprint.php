<?php

namespace UnderScorer\Core\Database\Migrations;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Illuminate\Database\Schema\Grammars\Grammar;

/**
 * Class Blueprint
 * @package UnderScorer\Core\Migrations
 */
class Blueprint extends BaseBlueprint
{

    /**
     * Parses blueprint into sql string
     *
     * @param ConnectionInterface $connection
     * @param Grammar             $grammar
     *
     * @return array
     */
    public function toSqlString( ConnectionInterface $connection, Grammar $grammar )
    {
        $this->addImpliedCommands( $grammar );

        $statements = [];

        foreach ( $this->commands as $command ) {
            $method = 'compile' . ucfirst( $command->name );

            if ( method_exists( $grammar, $method ) ) {
                if ( ! is_null( $sql = $grammar->$method( $this, $command, $connection ) ) ) {
                    $statements = array_merge( $statements, (array) $sql );
                }
            }
        }

        return $statements;
    }

}
