<?php

/**
 * @file
 * Template file for the fortytwo theme.
 */

require_once dirname(__FILE__) . '/includes/fortytwo.inc';

/**
 * Override or insert variables into the html templates.
 *
 * @param array $variables
 *   An array of variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function fortytwo_preprocess_html(&$variables, $hook) {
  load_debuggers();
  $variables['staticpath'] = fortytwo_get_staticpath(TRUE);
  $variables['classes_array'][] = theme_get_setting('ft_layout_style');
  $grid = theme_get_setting('ft_show_grid');
  ($grid) ? $variables['classes_array'][] = 'show_grid' : $variables['classes_array'][] = '';
  $variables['classes_array'][] = theme_get_setting('ft_layout_responsive');
}

/**
 * Implements hook_page_alter().
 */
function fortytwo_page_alter(&$page) {
  fortytwo_get_theme();
}

/**
 * Override or insert variables into the node templates.
 *
 * @param array $variables
 *   An array of variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function fortytwo_preprocess_node(&$variables, $hook) {
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }

  $variables['classes_array'] = array($variables['type']);
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param array $variables
 *   - title: An optional string to be used as a navigational heading to give
 *     context for breadcrumb links to screen-reader users.
 *   - title_attributes_array: Array of HTML attributes for the title. It is
 *     flattened into a string within the theme function.
 *   - breadcrumb: An array containing the breadcrumb links.
 *
 * @return string
 *   A string containing the breadcrumb output.
 */
function fortytwo_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('ft_breadcrumb');
  if ($show_breadcrumb == 'yes') {
    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('ft_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('ft_breadcrumb_separator');
      $trailing_separator = $prefix_separator = $title = '';
      if (theme_get_setting('ft_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $breadcrumb[] = check_plain($item['title']);
        }
        else {
          $breadcrumb[] = drupal_get_title();
        }
      }
      elseif (theme_get_setting('ft_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users.
      if (empty($variables['title'])) {
        $variables['title'] = t('You are here');
      }
      // Unless overridden by a preprocess function, make the heading invisible.
      if (!isset($variables['title_attributes_array']['class'])) {
        $variables['title_attributes_array']['class'][] = 'element-invisible';
      }

      if (theme_get_setting('ft_breadcrumb_prefix')) {
        $prefix_separator = $breadcrumb_separator;
      }

      // Build the breadcrumb trail.
      $output = '<nav class="breadcrumb" role="navigation">';
      $output .= '<h2' . drupal_attributes($variables['title_attributes_array']) . '>' . $variables['title'] . '</h2>';
      $output .= '<ol><li data-icon="' . $breadcrumb_separator . '">' . $prefix_separator . implode('</li><li data-icon="' . $breadcrumb_separator . '">', $breadcrumb) . $trailing_separator . '</li></ol>';
      $output .= '</nav>';
    }
  }

  return $output;
}

/**
 * Implements hook_preprocess_block().
 *
 * Clean up the div classes for blocks
 */
function fortytwo_preprocess_block(&$variables) {
  $variables['classes_array'] = array('block');
  $variables['block_html_id'] = str_replace('block-', '', $variables['block_html_id']);
}

/**
 * Implements hook_preprocess_views_view().
 *
 * Clean up the div classes for views
 */
function fortytwo_preprocess_views_view(&$variables) {
  $variables['classes_array'] = array('list-' . $variables['view']->name);
}

/**
 * Implements hook_preprocess_entity().
 *
 * Clean up the div classes for field_collections
 */
function fortytwo_preprocess_entity(&$variables) {
  if ($variables['entity_type'] == 'field_collection_item') {
    $variables['classes_array'] = array(
      str_replace('field-collection-item-field-', '', $variables['classes_array'][2]),
    );
  }
  if ($variables['entity_type'] == 'registration') {
    $variables['classes_array'] = array(
      $variables['elements']['#entity']->type,
    );
  }
}
