<?php

namespace UnderScorer\Core\Admin;

use Exception;
use UnderScorer\Core\Utility\AttributeBuilder;

/**
 * @author Przemysław Żydek
 */
class Menu
{

    use AttributeBuilder;

    /**
     * @var string Menu slug
     */
    protected $slug;

    /**
     * @var string Stores menu name
     */
    protected $menuTitle;

    /**
     * @var string
     */
    protected $pageTitle;

    /**
     * @var string
     */
    protected $parentSlug;

    /**
     * @var string
     */
    protected $capability = 'manage_options';

    /**
     * @var boolean Determines whenever menu is set using ACF
     */
    protected $isAcf = false;

    /**
     * @var boolean Determines whenever menu should be registered
     */
    protected $register = true;

    /**
     * @var callable|string|array Menu callback
     */
    protected $callback;

    /**
     * @var string Path to menu icon
     */
    protected $icon = '';

    /**
     * Menu constructor
     *
     * @param string $slug
     * @param array  $args Optional properties
     * @param Menu   $parent
     */
    public function __construct( string $slug, array $args = [], Menu $parent = null )
    {
        $priority = 98;

        $this->slug = $slug;

        $this->parseAttributes( $args );

        $name = str_replace( [ '-', '_' ], ' ', $slug );

        if ( empty( $this->pageTitle ) ) {
            $this->pageTitle = $name;
        }

        if ( empty( $this->menuTitle ) ) {
            $this->menuTitle = $name;
        }

        if ( ! empty( $parent ) ) {
            $this->parentSlug = $parent->getSlug();

            $priority = 99;

            $this->setIsAcf( $parent->isAcf() );
        }

        add_action( 'admin_menu', [ $this, 'register' ], $priority );
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Menu
     */
    public function setSlug( string $slug ): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAcf(): bool
    {
        return $this->isAcf;
    }

    /**
     * @param bool $isAcf
     *
     * @return $this
     */
    public function setIsAcf( bool $isAcf ): self
    {
        $this->isAcf = $isAcf;

        return $this;
    }

    /**
     * Registers admin menus
     *
     * @return void
     */
    public function register()
    {

        if ( ! $this->register ) {
            return;
        }

        if ( $this->isAcf ) {

            if ( empty( $this->parentSlug ) ) {
                acf_add_options_page( [
                    'page_title' => $this->pageTitle,
                    'menu_title' => $this->menuTitle,
                    'capability' => $this->capability,
                    'menu_slug'  => $this->slug,
                ] );
            } else {
                acf_add_options_sub_page( [
                    'page_title'  => $this->pageTitle,
                    'menu_title'  => $this->menuTitle,
                    'capability'  => $this->capability,
                    'menu_slug'   => $this->slug,
                    'parent_slug' => $this->parentSlug,
                ] );
            }

        } else {

            if ( empty( $this->parentSlug ) ) {
                add_menu_page(
                    $this->pageTitle,
                    $this->menuTitle,
                    $this->capability,
                    $this->slug,
                    $this->callback,
                    $this->icon
                );
            } else {
                add_submenu_page(
                    $this->parentSlug,
                    $this->pageTitle,
                    $this->menuTitle,
                    $this->capability,
                    $this->slug,
                    $this->callback
                );
            }

        }

    }

    /**
     * @return bool
     */
    public function shouldRegister(): bool
    {
        return $this->register;
    }

    /**
     * @param bool $register
     *
     * @return $this
     */
    public function setRegister( bool $register ): self
    {
        $this->register = $register;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon( string $icon ): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getParentSlug(): string
    {
        return $this->parentSlug;
    }

    /**
     * @param string $parentSlug
     *
     * @return $this
     */
    public function setParentSlug( string $parentSlug ): self
    {
        $this->parentSlug = $parentSlug;

        return $this;
    }

    /**
     * @param string $slug
     * @param array  $args
     *
     * @return Menu Created submenu instance
     * @throws Exception
     */
    public function addSubmenu( string $slug, array $args = [] ): self
    {

        if ( ! empty( $this->parentSlug ) ) {
            throw new Exception( 'This method should be called only on parent menu instance.' );
        }

        return new Menu( $slug, $args, $this );

    }

    /**
     * @return string
     */
    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }

    /**
     * @param string $menuTitle
     *
     * @return Menu
     */
    public function setMenuTitle( string $menuTitle ): self
    {
        $this->menuTitle = $menuTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     *
     * @return Menu
     */
    public function setPageTitle( string $pageTitle ): self
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * @param string $capability
     *
     * @return Menu
     */
    public function setCapability( string $capability ): self
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * @return array|callable|string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param array|callable|string $callback
     *
     * @return Menu
     */
    public function setCallback( $callback )
    {
        $this->callback = $callback;

        return $this;
    }

}
