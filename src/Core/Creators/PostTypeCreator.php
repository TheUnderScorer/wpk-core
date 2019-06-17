<?php

namespace UnderScorer\Core\Creators;

use Closure;
use UnderScorer\Core\Admin\Menu;
use WP_Query;

/**
 * Helper function for creating new post types
 *
 * @author Przemysław Żydek
 */
class PostTypeCreator
{

    /**
     * @var array Post type args
     */
    protected $args = [];

    /**
     * @var string Post type slug
     */
    protected $slug = [];

    /**
     * @var array Array of taxonomies to register
     */
    protected $taxonomies = [];

    /**
     * PostType constructor.
     *
     * @param string $slug
     * @param array  $args
     */
    public function __construct( string $slug, array $args = [] )
    {
        $this->slug = $slug;
        $this->args = $args;

        add_action( 'init', [ $this, 'register' ] );
        add_action( 'init', [ $this, 'registerTaxonomies' ], 11 );
    }

    /**
     * Wrapper for this class constructor
     *
     * @param string $slug
     * @param array  $args
     *
     * @return PostTypeCreator
     */
    public static function create( string $slug, array $args = [] ): self
    {
        return new static( $slug, $args );
    }

    /**
     * Register post type. Hooked into init
     *
     * @return void
     */
    public function register()
    {
        register_post_type( $this->slug, $this->args );
    }

    /**
     * Add new column to admin view
     *
     * @param string  $columnSlug
     * @param string  $columnName
     * @param Closure $callback Callback for column content
     *
     * @return self
     */
    public function addAdminColumn( string $columnSlug, string $columnName, Closure $callback ): self
    {

        add_filter( "manage_{$this->slug}_posts_columns", function ( $columns = [] ) use ( $columnSlug, $columnName )
        {
            $columns[ $columnSlug ] = $columnName;

            return $columns;
        } );

        add_action( "manage_{$this->slug}_posts_custom_column", function ( $column, $postId ) use ( $callback, $columnSlug )
        {
            if ( $column === $columnSlug ) {
                $callback( $postId );
            }
        }, 10, 2 );

        return $this;
    }

    /**
     * @param string  $columnSlug
     * @param string  $columnName
     * @param Closure $contentCallback
     * @param array   $args Args for filtering (meta_key and orderby)
     *
     * @return self
     */
    public function addSortableColumn( string $columnSlug, string $columnName, Closure $contentCallback, array $args = [] ): self
    {

        $args += [
            'meta_key' => $columnSlug,
            'orderby'  => 'meta_value_num',
        ];

        // Add column to view
        add_filter( "manage_{$this->slug}_posts_columns", function ( $columns = [] ) use ( $columnSlug, $columnName )
        {
            $columns[ $columnSlug ] = $columnName;

            return $columns;
        } );

        // Make column sortable
        add_filter( "manage_edit-{$this->slug}_sortable_columns", function ( $columns = [] ) use ( $columnSlug, $columnName )
        {
            $columns[ $columnSlug ] = $columnSlug;

            return $columns;
        } );

        // Callback for column content
        add_action( "manage_{$this->slug}_posts_custom_column", function ( $column, $postId ) use ( $contentCallback, $columnSlug )
        {
            if ( $column === $columnSlug ) {
                $contentCallback( $postId );
            }
        }, 10, 2 );

        // Ordering
        add_action( 'pre_get_posts', function ( WP_Query $query ) use ( $args )
        {

            if ( ! is_admin() ) {
                return;
            }

            $queryOrder = $query->get( 'orderby' );

            if ( $queryOrder === $args[ 'meta_key' ] ) {

                foreach ( $args as $key => $item ) {
                    $query->set( $key, $item );
                }

            }

        } );

        return $this;

    }

    /**
     * Remove admin column from table
     *
     * @param string $columnSlug
     *
     * @return self
     */
    public function removeAdminColumn( string $columnSlug ): self
    {

        add_filter( "manage_{$this->slug}_posts_columns", function ( $columns = [] ) use ( $columnSlug )
        {
            unset( $columns[ $columnSlug ] );

            return $columns;
        } );

        return $this;

    }

    /**
     * @param string  $action
     * @param string  $label
     * @param Closure $callback Callback for this bulk action called with params $redirectTo and $postIDS
     *
     * @return self
     */
    public function addBulkAction( string $action, string $label, Closure $callback ): self
    {

        add_filter( "bulk_actions-edit-{$this->slug}", function ( $actions ) use ( $action, $label )
        {
            $actions[ $action ] = $label;

            return $actions;
        } );

        add_filter( "handle_bulk_actions-edit-{$this->slug}", function ( $redirectTo, $calledAction, $postIDS ) use ( $action, $callback )
        {

            if ( $calledAction !== $action ) {
                return $redirectTo;
            }

            return $callback( $redirectTo, $postIDS );

        }, 10, 3 );

        return $this;

    }

    /**
     * Add submenu to post page
     *
     * @param Menu $menu
     *
     * @return self
     */
    public function addSubmenu( Menu $menu ): self
    {

        $menu->setParentSlug( "edit.php?post_type={$this->slug}" );

        return $this;

    }

    /**
     * @param string $taxonomy
     * @param array  $args
     *
     * @return self
     */
    public function addTaxonomy( string $taxonomy, array $args = [] ): self
    {

        $this->taxonomies[ $taxonomy ] = $args;

        return $this;

    }

    /**
     * @return void
     */
    public function registerTaxonomies()
    {

        foreach ( $this->taxonomies as $slug => $args ) {
            register_taxonomy( $slug, $this->slug, $args );
        }

    }

}
