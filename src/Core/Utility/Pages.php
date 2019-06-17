<?php

namespace UnderScorer\Core\Utility;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use UnderScorer\ORM\WP\Post;

/**
 * @author Przemysław Żydek
 */
class Pages
{

    /**
     * @param string $template
     *
     * @return string
     */
    public static function getLinkByTemplate( string $template ): string
    {

        $page = self::getByTemplate( $template );

        if ( empty( $page ) ) {
            return '';
        }

        return get_permalink( $page->first()->ID );

    }

    /**
     * @param string $template
     *
     * @return Collection
     */
    public static function getByTemplate( string $template ): Collection
    {

        return Post::query()
                   ->where( 'post_type', '=', 'page' )
                   ->whereHas( 'meta', function ( Builder $query ) use ( $template ) {
                       $query
                           ->where( [
                               [ 'meta_key', '=', '_wp_page_template' ],
                               [ 'meta_value', '=', $template ],
                           ] );
                   } )
                   ->get();

    }

    /**
     * @return string
     */
    public static function getCurrentTemplate(): string
    {
        return basename( get_page_template() );
    }

}
