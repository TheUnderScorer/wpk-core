<?php

use Illuminate\Database\Eloquent\Builder;
use UnderScorer\Core\Utility\Date;
use UnderScorer\ORM\Models\Post;
use UnderScorer\ORM\Models\TermTaxonomy;

// Usage of laravel ORM

// Simple meta query
$postsByMetaDate = Post::query()
                       ->whereHas( 'meta', function ( Builder $query ) {
                           $query->where( [
                               [ 'meta_key', '=', 'some_date' ],
                               [
                                   'meta_value',
                                   '>=',
                                   Date::now()->subtract( 'days', 5 )->toDateTimeString(),
                               ],
                           ] );
                       } )->get();

/**
 * @var Post $post
 */
foreach ( $postsByMetaDate->all() as $post ) {

    // Get single meta value from post
    $meta = $post->getSingleMeta( 'some_date' );

    /**
     * Stores post taxonomy "category" terms
     *
     * @var TermTaxonomy[] $categories
     */
    $categories = $post->taxonomy( 'category' );

    // Outputs term name
    foreach ( $categories as $term ) {
        echo $term->term->name;
    }

    // Adds meta value
    $post->addMeta( 'some_meta', 'Some value' );

    // Adds new term to category taxonomy
    $post->addTerms( 'category', [
        [
            'name' => 'Some term',
            'slug' => 'some_term',
        ],
    ] );

    echo $meta;
    echo $post->post_title;
}
