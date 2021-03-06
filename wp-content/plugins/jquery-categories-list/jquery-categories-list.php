<?php
/*
  Plugin Name: jQuery Categories List Widget
  Plugin URI: http://skatox.com/blog/jquery-categories-list-widget/
  Description: A simple jQuery widget for displaying a categories collapsible list with some effects
  Version: 2.1
  Author: Miguel Useche
  Author URI: http://migueluseche.com/
  License: GPL2
  Copyleft 2010-2013  Miguel Useche  (email : migueluseche@skatox.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
class JQCategoriesList extends WP_Widget 
{
    const JS_FILENAME = "jcl.js";
    protected $pluginUrl;
    public $defaults = array( 
        'title' =>  '',
        'symbol' => 1,
        'ex_sym' => '►',
        'con_sym' => '▼',
        'layout' => 'right',
        'effect' => 'slide',
        'fx_in' => 'slideDown',
        'fx_out' => 'slideUp',
        'orderby' => 'name',
        'orderdir' => 'ASC',
        'show_empty' => 0,
        'showcount' => 0,
        'expand' => 'none',
        'exclude' => NULL
    );

    public function __construct()
    {
        $this->pluginUrl =  WP_PLUGIN_URL . '/' . 
                            preg_replace("/^.*[\/\\\]/", "", dirname(__FILE__)) .
                            '/' . self::JS_FILENAME;

        add_shortcode('jQuery Categories List', array($this,'filter'));
        add_filter('widget_text', 'do_shortcode');
        
        if (function_exists("load_plugin_textdomain"))
            load_plugin_textdomain('jcl_i18n', null, basename(dirname(__FILE__)) . '/lang');

        parent::WP_Widget(
            'jcl_widget', 
            'jQuery Categories List Widget', 
            array(
                'description' => __(
                    __('A simple jQuery widget for displaying a categories list with some effects.', 'jcl_i18n')
                )
            )
        );
    }

    public function widget($args, $instance)
    {
        if (function_exists("wp_enqueue_script")) {
            wp_enqueue_script('jquery_categories_list', $this->pluginUrl, array('jquery'), false, true);
        }

        extract($args);
        echo $before_widget;
        echo $before_title;
        echo $instance['title'];
        echo $after_title;
        echo $this->buildHtml($instance);
        echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        if(empty($new_instance['title']))
            $instance['title'] =  __('Categories', 'jcl_i18n');
        else
            $instance['title'] =  stripslashes(strip_tags($new_instance['title']));

        $instance['symbol'] = $new_instance['symbol'];
        $instance['effect'] = stripslashes($new_instance['effect']);
        $instance['layout'] = stripslashes($new_instance['layout']);
        $instance['orderby'] = stripslashes($new_instance['orderby']);
        $instance['orderdir'] = stripslashes($new_instance['orderdir']);
        $instance['show_empty'] = empty($new_instance['show_empty']) ? 0 : 1;
        $instance['showcount'] = empty($new_instance['showcount']) ? 0 : 1;
        $instance['expand'] = $new_instance['expand'];
        $instance['exclude'] = empty($new_instance['exclude']) ? NULL : serialize($new_instance['exclude']);

        switch ($new_instance['symbol']) {
            case '0':
                $instance['ex_sym'] = ' ';
                $instance['con_sym'] = ' ';
                break;
            case '1':
                $instance['ex_sym'] = '►';
                $instance['con_sym'] = '▼';
                break;
            case '2':
                $instance['ex_sym'] = '(+)';
                $instance['con_sym'] = '(-)';
                break;
            case '3':
                $instance['ex_sym'] = '[+]';
                $instance['con_sym'] = '[-]';
                break;
            default:
                $instance['ex_sym'] = '>';
                $instance['con_sym'] = 'v';
                break;
        }

        switch ($new_instance['effect']) {
            case 'slide':
                $instance['fx_in'] = 'slideDown';
                $instance['fx_out'] = 'slideUp';
                break;
            case 'fade':
                $instance['fx_in'] = 'fadeIn';
                $instance['fx_out'] = 'fadeOut';
                break;
            default:
                $instance['fx_in'] = 'none';
                $instance['fx_out'] = 'none';
        }
        return $instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args( (array) $instance, $this->defaults ); 
    ?>  
        <dl>
            <dt><strong><?php _e('Title', 'jcl_i18n') ?></strong></dt>
            <dd>
                <input name="<?php echo $this->get_field_name( 'title' )?>" type="text" value="<?php echo $instance['title']; ?>" />
            </dd>
            <dt><strong><?php _e('Trigger Symbol', 'jcl_i18n') ?></strong></dt>
            <dd>
                <select id="<?php echo $this->get_field_id( 'symbol' ) ?>" name="<?php echo $this->get_field_name( 'symbol' ) ?>">
                    <option value="0"  <?php if ($instance['symbol'] == '0') echo 'selected="selected"' ?> >
                        <?php _e('Empty Space', 'jcl_i18n') ?>
                    </option>
                    <option value="1" <?php if ($instance['symbol'] == '1') echo 'selected="selected"' ?> >
                        ► ▼
                    </option>
                    <option value="2" <?php if ($instance['symbol'] == '2') echo 'selected="selected"' ?> >
                        (+) (-)
                    </option>
                    <option value="3" <?php if ($instance['symbol'] == '3') echo 'selected="selected"' ?> >
                        [+] [-]
                    </option>
                </select>
            </dd>
            <dt><strong><?php _e('Symbol position', 'jcl_i18n') ?></strong></dt>
            <dd>
                <select id="<?php echo $this->get_field_id( 'layout' ) ?>" name="<?php echo $this->get_field_name( 'layout' ) ?>">
                    <option value="right"  <?php if ($instance['layout'] == 'right') echo 'selected="selected"' ?> >
                        <?php _e('Right', 'jcl_i18n') ?>
                    </option>
                    <option value="left" <?php if ($instance['layout'] != 'right') echo 'selected="selected"' ?> >
                        <?php _e('Left', 'jcl_i18n') ?>
                    </option>
                </select>
            </dd>
            <dt><strong><?php _e('Effect', 'jcl_i18n') ?></strong></dt>
            <dd>
                <select id="<?php echo $this->get_field_id( 'effect' ) ?>" name="<?php echo $this->get_field_name( 'effect' ) ?>">
                    <option value="none" <?php if ($instance['effect'] == '') echo 'selected="selected"'?>>
                        <?php _e('None', 'jcl_i18n') ?>
                    </option>
                    <option value="slide"  <?php if ($instance['effect'] == 'slide') echo 'selected="selected"' ?> >
                        <?php _e('Slide (Accordion)', 'jcl_i18n') ?>
                    </option>
                    <option value="fade" <?php if ($instance['effect'] == 'fade') echo 'selected="selected"' ?> >
                        <?php _e('Fade', 'jcl_i18n') ?>
                    </option>
                </select>
            </dd>
            <dt><strong><?php _e('Order By', 'jcl_i18n') ?></strong></dt>
            <dd>
                <select id="<?php echo $this->get_field_id( 'orderby' ) ?>" name="<?php echo $this->get_field_name( 'orderby' ) ?>">
                    <option value="name"  <?php if ($instance['orderby'] == 'name') echo 'selected="selected"' ?> ><?php _e('Name', 'jcl_i18n') ?></option>
                    <option value="id"  <?php if ($instance['orderby'] == 'id') echo 'selected="selected"' ?> ><?php _e('Category ID', 'jcl_i18n') ?></option>
                    <option value="count"  <?php if ($instance['orderby'] == 'count') echo 'selected="selected"' ?> ><?php _e('Entries count', 'jcl_i18n') ?></option>
                </select>
                <select id="<?php echo $this->get_field_id( 'orderdir' ) ?>" name="<?php echo $this->get_field_name( 'orderdir' ) ?>">
                    <option value="ASC"  <?php if ($instance['orderdir'] == 'ASC') echo 'selected="selected"' ?> ><?php _e('ASC', 'jcl_i18n') ?></option>
                    <option value="DESC"  <?php if ($instance['orderdir'] == 'DESC') echo 'selected="selected"' ?> ><?php _e('DESC', 'jcl_i18n') ?></option>
                </select>
            </dd>
            <dt><strong><?php _e('Expand', 'jcl_i18n') ?></strong></dtd>
            <dd>
                <select id="<?php echo $this->get_field_id( 'expand' ) ?>" name="<?php echo $this->get_field_name( 'expand' ) ?>">
                    <option value="none" <?php if ($instance['expand'] == '') echo 'selected="selected"'?>>
                        <?php _e('None', 'jcl_i18n') ?>
                    </option>
                    <option value="all" <?php if ($instance['expand'] == 'all') echo 'selected="selected"'?> >
                        <?php _e('All', 'jcl_i18n') ?>
                    </option>
                </select>
            </dd>
            <dt><strong><?php _e('Extra options', 'jcl_i18n') ?></strong></dt>
            <dd>
                <input id="<?php echo $this->get_field_id( 'showcount' ) ?>" value="1" name="<?php echo $this->get_field_name( 'showcount' ) ?>" type="checkbox" <?php if ($instance['showcount']) echo 'checked="checked"' ?> />
                <?php _e('Show number of posts', 'jcl_i18n') ?>
            </dd>
            <dd>
                <input id="<?php echo $this->get_field_id( 'show_empty' ) ?>" value="1" name="<?php echo $this->get_field_name( 'show_empty' ) ?>" type="checkbox" <?php if (!empty($instance['show_empty'])) echo 'checked="checked"' ?> />
                <?php _e('Show empty categories', 'jcl_i18n') ?>
            </dd>
            <dt><strong><?php _e('Categories to exclude:', 'jcl_i18n') ?></strong></dt>
            <dd>
                <select id="<?php echo $this->get_field_id( 'exclude' ) ?>" name="<?php echo $this->get_field_name( 'exclude' ) ?>[]" style="height:75px;" multiple="multiple">
                    <?php
                    $cats = get_categories(
                            array(
                                'type' => 'post',
                                'child_of' => 0,
                                'orderby' => 'name',
                                'order' => 'asc',
                                'hide_empty' => 0,
                                'hierarchical' => 1,
                                'taxonomy' => 'category',
                                'pad_counts' => false
                            )
                    );
                    $instance['exclude'] = empty($instance['exclude']) ? array() : unserialize($instance['exclude']);

                    foreach ($cats as $cat) {
                        $checked = (in_array($cat->term_id, $instance['exclude'])) ? 'selected="selected"' : '';
                        echo "<option value=\"{$cat->term_id}\" {$checked}>{$cat->cat_name}</option>";
                    }
                    ?>
                </select>
            </dd>
        </dl>
        <?php
    }
    
    /**
     * Returns all categories
     * @return an array of categories.
     */
    protected function getCategories($instance)
    {
        return get_categories(
            array(
                'type' => 'post',
                'child_of' => 0,
                'orderby' => $instance['orderby'],
                'order' => $instance['orderdir'],
                'hide_empty' => !$instance['show_empty'],
                'hierarchical' => 1,
                'taxonomy' => 'category',
                'pad_counts' => false
            )
        );
    }

    /**
     * Gets an array of children categories as an array given its parent id, this
     * functions avoiding excesive database calls
     * @param $cat categories object
     * @param $parentId category's parent id
     */
    protected function getCategoriesAsArray($cat, $parentId)
    {
        $categories = array();

        foreach ($cat as $c)
            if ($c->parent == $parentId)
                $categories[] = $c;

        return $categories;
    }

    /**
     * Creates HTML code recursive
     */
    protected function printCategory($cat, $parentId, $instance) 
    {
        $html = '';
        $child_html = '';
        $categories = $this->getCategoriesAsArray($cat, $parentId);
        $cat_to_exc = empty($instance['exclude']) ? array() : unserialize($instance['exclude']);
        $hideCategory = $parentId > 0 && $instance['expand'] == 'none';

        foreach ($categories as $category) {

            if (is_array($cat_to_exc))
                $exclude = in_array($category->term_id, $cat_to_exc);
            else
                $exclude = false;

            if (!$exclude)
                $child_html = $this->printCategory($cat, $category->cat_ID, $instance);

            if (!empty($category->cat_name) && !$exclude) {
                $styleAttribute = $hideCategory ? 'style="display:none;"' : '';

                $categoryLink = '<a href="' . get_category_link($category->term_id) . '" >' . $category->cat_name;

                if ( $instance['showcount'] )
                    $categoryLink .= ' (' . $category->count . ')';

                $categoryLink .= '</a>';
                $childLink = '';

                if (!empty($child_html)) {
                    $cssRule = $instance['layout'] === 'right' ? 'right' : 'left';
                    $childLink .= '<a class="jcl_link" href="' . get_category_link($category->term_id) . '" title="' . __('View Sub-Categories', 'jcl_i18n') . '">';
                    $childLink .= '<span class="jcl_symbol" style="padding-' . $cssRule . 'left:5px">';
                    $childLink .= $hideCategory || !$parentId && $instance['expand'] == 'none' ? htmlspecialchars($instance['ex_sym']) : htmlspecialchars($instance['con_sym']);
                    $childLink .= '</span></a>';
                }

                $html .= '<li class="jcl_category" ' . $styleAttribute . ' >';
                $html .= $instance['layout'] === 'right' ? $categoryLink . $childLink : $childLink . $categoryLink;

                if (!empty($child_html))
                    $html .= '<ul>' . $child_html . '</ul>';

                $html .= '</li>';
            }
        }

        return $html;
    }

    /**
     * Builds categories list's HTML code
     */
    protected function buildHtml($instance) 
    {
        global $wp_locale;
        $cats = $this->getCategories($instance);
        
        $html = '<ul class="jcl_widget">';
        $list = $this->printCategory($cats, 0, $instance);

        if( empty( $list ) ){
            $html .= '<li>';
            $html .= __('There are no categories to display' , 'jcl_i18n');
            $html .= '</li>';
            $html .= '</ul>';
        } else {
            $html .= $list;
            $html .= '</ul>';
            $html.= $this->printHiddenInput('fx_in', $instance['fx_in']);
            $html.= $this->printHiddenInput('ex_sym', $instance['ex_sym']);
            $html.= $this->printHiddenInput('con_sym', $instance['con_sym']);
            $html.= $this->printHiddenInput('showcount', $instance['showcount']);
        }
        return $html;
    }

    protected function printHiddenInput($fieldName, $value)
    {
        return sprintf('<input type="hidden" id="%s" name="%s" class="%s" value="%s" />',
                $this->get_field_id($fieldName), $this->get_field_name($fieldName), $fieldName, $value);
    }

    /**
     * Function to clean input from user
     * @return int 1 or 0 if true or false
     */
    protected function fixAttr($attr)
    {
        $val = 0;

        switch ($attr) {
            case 'yes':
            case 'true':
            case '1':
                $val = 1;
                break;
        }
        return $val;
    }

    /**
     * Function wich filters any [jQuery Categories List] text inside post to display archive list
     */
    public function filter($attr)
    {
         if (function_exists("wp_enqueue_script")) {
            wp_enqueue_script('jquery_categories_list', $this->pluginUrl, array('jquery'), false, true);
        }
        
        $instance = shortcode_atts($this->defaults, $attr);
        $instance['exclude'] = serialize(explode(',', $instance['exclude']));
        
        return $this->buildHtml($instance);
    }
}

function jclw_register_widget() {
    register_widget('JQCategoriesList');
}

add_action('widgets_init', 'jclw_register_widget');