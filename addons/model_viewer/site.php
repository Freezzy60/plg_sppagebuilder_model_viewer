<?php
/**
 * @package SP Page Builder
 * @author Dennis Baumann http://www.bits.co.at
 * @copyright Copyright (c) 2023 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct access
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
class SppagebuilderAddonModel_viewer extends SppagebuilderAddons
{
	/**
	 * The addon frontend render method.
	 * The returned HTML string will render to the frontend page.
	 *
	 * @return string The HTML string.
	 * @since 1.0.0
	 */
	public function render()
	{
		$doc                           = Factory::getDocument();
		$doc->addScript(JURI::base() . 'plugins/sppagebuilder/model_viewer/addons/model_viewer/js/model-viewer.js', array(''), array('type' => 'module'));
		$settings = $this->addon->settings;
		$settings->content_zoom_min .= 'deg';
		$settings->content_zoom_max .= 'deg';
		$dis = ($settings->content_disable_zoom === 1) ? 'disable-zoom' : '';
		$class = (isset($settings->class) && $settings->class) ? ' ' . $settings->class : '';
		$title = (isset($settings->title) && $settings->title) ? $settings->title : '';
		$heading_selector = (isset($settings->heading_selector) && $settings->heading_selector) ? $settings->heading_selector : 'h2';
		$content = (isset($settings->content) && $settings->content) ? $settings->content : '';
		$modelViewer = "<model-viewer src='$content->url'  shadow-intensity='$settings->content_shadow_intensity' camera-controls $dis touch-action='pan-y'  min-field-of-view='$settings->content_zoom_min' max-field-of-view='$settings->content_zoom_max' style='height: 100%; width: 100%'></model-viewer>";
		$output = '';
		// Link Parse
		[$link, $target] = AddonHelper::parseLink($settings, 'url');
		
		$output .= '<div class="sppb-addon sppb-addon-model-viewer' . $class . '">';
		
		// Title
		$output .= '<' . $heading_selector . ' class="sppb-addon-title">';
		$output .= nl2br($title);
		$output .= '</' . $heading_selector . '>';
		
		
		// Content
		$output .= '<div class="sppb-addon-content">'. $modelViewer .'</div>';
		
		
		$output .= '</div>';
		
		return $output;
	}
	
	/**
	 * Generate the CSS string for the frontend page.
	 *
	 * @return string The CSS string for the page.
	 * @since 1.0.0
	 */
	public function css()
	{
		$addon_id = '#sppb-addon-' . $this->addon->id;
		$cssHelper = new CSSHelper($addon_id);
		
		$css = '';
		
		$settings = $this->addon->settings;
		$settings->alignment = CSSHelper::parseAlignment($settings, 'alignment');
		$alignment = $cssHelper->generateStyle('.sppb-addon.sppb-addon-model-viewer', $settings, ['alignment' => 'text-align'], false);
		$settings->content_width = CSSHelper::parseAlignment($settings, 'content_width');
		$content_size = $cssHelper->generateStyle('.sppb-addon-model-viewer .sppb-addon-content', $settings, ['content_width' => 'width', 'content_height' => 'height']);
		
		$css .= $alignment;
		$css .= $content_size;
		
		return $css;
	}
	
	/**
	 * Generate the lodash template string for the frontend editor.
	 *
	 * @return string The lodash template string.
	 * @since 1.0.0
	 */
	public static function getTemplate()
	{
			$lodash = new Lodash('#sppb-addon-{{ data.id }}');
			
			// Inline Styles
			$output = '<style type="text/css">';
			$output .= $lodash->alignment('text-align', '.sppb-addon-model-viewer', 'data.alignment');
			$output .= '</style>';
			
			$output .= '
		 <#
		 let btnUrl = "";
		 let target = "";
		 let rel = "";
		 if (!_.isEmpty(data.url) && _.isObject(data.url)){
		 const {url, page, menu, type, new_tab, nofollow} = data?.url;
		 if(type === "url") btnUrl = url;
		 if(type === "menu") btnUrl = menu;
		 if(type === "page") btnUrl = page ? `index.php?option=com_sppagebuilder&view=page&id=${page}` : "";
		 
		 target = new_tab ? "_blank": "";
		 rel = nofollow ? "noopener noreferrer": "";
		 }
		 
		 #>
		 ';
			
			$output .= '<div class="sppb-addon sppb-addon-rich_text {{ data.class}}">';
			
			// Title
			$output .= '<{{ data.heading_selector }} class="sppb-addon-title">';
			$output .= '<span class="sp-inline-editable-element" data-id={{data.id}} data-fieldName="title" contenteditable="true">{{{ data.title }}}</span>';
			$output .= '</{{ data.heading_selector }}>';
			
			// Content
			$output .= '<p>';
			$output .= '<span class="sp-inline-editable-element" data-id={{data.id}} data-fieldName="content" contenteditable="true">{{{ data.content }}}</span>';
			$output .= '</p>';
			
			
			$output .= '</div>';
			
			return $output;
	}
}