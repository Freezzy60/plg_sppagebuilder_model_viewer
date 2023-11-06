<?php
/**
 * @package SP Page Builder
 * @author Dennis Baumann http:   //www.bits.co.at
 * @copyright Copyright (c) 2023 Bits
 * @license http:   //www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;

/**
 * Inline editor settings rules:
 * 1. The inline array must have an attribute named `buttons`
 * 2. The buttons array contains all the editor buttons. The key of the array must be unique.
 * 3. Every button contains some attributes like-
 *         a. action (string) (required) [The action will perform after clicking the button]
 *         b. type (string) (required) [The type of the button. valid values are `placeholder`, `icon-text`]
 *         c. placeholder (string) (optional) [If the button is dynamic and this cannot be expressed as icon/text.]
 *         d. icon (string) (optional) [A valid icon name available in the pagebuilder]
 *         e. text (string) (optional) [A text value to show as the button text]
 *         f. icon_position (string) (optional) [`left` or `right` position of the icon to the text. Default `left`]
 *         g. tooltip (string) (optional) [Tooltip text to show on the button hover.]
 *         h. fieldset (array) (conditional) [An conditional array (which is required if action is dropdown) for representing the fieldset fields.
 *             This is valid only if the action is `dropdown`.
 *             The direct children of the fieldset array would be the tabs.
 *             Inside the tabs name you should define the fields descriptions.
 *             If there is only one fieldset child then that means no tabs]
 *         i. options (array) (conditional) [This is a conditional field. This is required if the action is dropdown
 *             but you need to show some options not fields.]
 *         j. default (mixed) (conditional) [This is required if there is the options key. This indicates the default value of the button from the options array.]
 */

SpAddonsConfig::addonConfig(
	[
		'type' => 'content',
		'addon_name' => 'model_viewer',
		'title' => 'Model Viewer',
		'desc' => 'Model Viewer Custom addon',
		'category' => 'Custom',
		'icon' => '',
		'settings' => [
			'content' => [
				'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT'),
				'fields' => [
					'image' => [
						'type' => 'media',
						'std' => [
							'src' => '',
							'height' => '',
							'width' => '',
						],
					],
					
					'alt_text' => [
						'type' => 'text',
						'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALT_TEXT'),
						'desc' => Text::_('COM_SPPAGEBUILDER_GLOBAL_ALT_TEXT_DESC'),
						'std' => 'Image',
						'inline' => true,
					],

				],
			
			],
			
			'options' => [
				'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_OPTIONS'),
				'fields' => [
					'content_width' => [
						'type' => 'slider',
						'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_WIDTH'),
						'max' => 2000,
						'min' => 0,
						'responsive' => true,
						'std' => 800,
					],
					
					'content_height' => [
						'type' => 'slider',
						'title' => Text::_('COM_SPPAGEBUILDER_GLOBAL_HEIGHT'),
						'max' => 2000,
						'min' => 0,
						'responsive' => true,
						'std' => 300,
					],
					
					'content_zoom_min' => [
						'type' => 'slider',
						'title' => Text::_('PLG_BITS_MODEL_VIEWER_MIN_FIELD_OF_VIEW'),
						'max' => 180,
						'min' => 0,
						'std' => 25,
					],
					
					'content_zoom_max' => [
						'type' => 'slider',
						'title' => Text::_('PLG_BITS_MODEL_VIEWER_MAX_FIELD_OF_VIEW'),
						'max' => 180,
						'min' => 0,
						'std' => 35,
					],
					
					'content_disable_zoom' => [
						'type' => 'checkbox',
						'title' => Text::_('PLG_BITS_MODEL_VIEWER_DISABLE_ZOOM'),
						'std' => 0,
					],
					
					'content_shadow_intensity' => [
						'type' => 'slider',
						'title' => Text::_('PLG_BITS_MODEL_VIEWER_SHADOW_INTENSITY'),
						'max' => 10,
						'min' => 0,
						'std' => 1,
					],
				],
			],
		],
		'attr' => [],
	],
);
