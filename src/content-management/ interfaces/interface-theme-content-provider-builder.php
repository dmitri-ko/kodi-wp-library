<?php
/**
 * ThemeContentProviderBuilderInterface
 *
 * Defines the builder interface for constructing Theme_Content_Provider instances.
 *
 * @package Kodi
 * @subpackage ContentManagement
 * @since 1.0.0
 */

namespace Kodi\ContentManagement\Interfaces;

use Kodi\ContentManagement\ThemeContentProvider;

/**
 * Interface ThemeContentProviderBuilderInterface
 *
 * Specifies methods for building a Theme_Content_Provider.
 *
 * @since 1.0.0
 */
interface ThemeContentProviderBuilderInterface {

	/**
	 * Sets theme subscribers.
	 *
	 * @param array $subscribers List of theme subscribers.
	 * @return ThemeContentProviderBuilderInterface
	 */
	public function set_theme_subscribers( array $subscribers ): self;

	/**
	 * Sets theme shortcodes.
	 *
	 * @param array $shortcodes List of theme shortcodes.
	 * @return ThemeContentProviderBuilderInterface
	 */
	public function set_theme_shortcodes( array $shortcodes ): self;

	/**
	 * Sets default theme settings.
	 *
	 * @param array $settings Default settings for the theme configuration.
	 * @return ThemeContentProviderBuilderInterface
	 */
	public function set_default_settings( array $settings ): self;

	/**
	 * Builds and returns an instance of ThemeContentProvider.
	 *
	 * @return ThemeContentProvider
	 */
	public function build(): ThemeContentProvider;
}
