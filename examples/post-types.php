<?php

use UnderScorer\Core\Admin\Menu;
use UnderScorer\Core\Creators\PostTypeCreator;

$creator = new PostTypeCreator( 'my_post_type', [
    /**
     * @see register_post_type() for args
     */
] );

$creator
    ->addTaxonomy( 'some_taxonomy', [
        /**
         * @see register_taxonomy() for args
         */
    ] );

// Regular column
$creator
    ->addAdminColumn(
        'my_column',
        'My column',
        function ( int $postID ) {
            $meta = get_post_meta( $postID, 'some_meta', true );

            echo $meta;
        }
    );

// Sortable column
$creator
    ->addSortableColumn(
        'my_sortable_column',
        'Sortable column',
        function ( int $postID ) {
            $meta = get_post_meta( $postID, 'some_meta', true );

            echo $meta;
        },
        );

// Submenu that get's attached to post type menu in dashboard
$creator->addSubmenu(
    new Menu( 'my_post_menu', [
        'menuTitle' => 'Some title',
        'pageTitle' => 'Some title',
        'callback'  => function () {
            echo 'Hello world!';
        },
    ] )
);
