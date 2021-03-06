<?php
/**
 * Sydney Theme Customizer
 *
 * @package Sydney
 */

function sydney_customize_register( $wp_customize ) {
	$wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->get_section( 'header_image' )->panel = 'sydney_header_panel';
    $wp_customize->get_section( 'header_image' )->priority = '13';
    $wp_customize->get_section( 'title_tagline' )->priority = '9';
    $wp_customize->get_section( 'title_tagline' )->title = __('Site title/tagline/logo', 'sydney');
    $wp_customize->get_section( 'colors' )->title = __('General', 'sydney');
    $wp_customize->get_section( 'colors' )->panel = 'sydney_colors_panel';
    $wp_customize->get_section( 'colors' )->priority = '10';

    //Partials
    for ($i = 1; $i < 5; $i++) { 
        $wp_customize->selective_refresh->add_partial( 'slider_title_' . $i, array(
            'selector'          => '.slide-item-' . $i . ' .maintitle',
            'render_callback'   => 'sydney_partial_slider_title_' . $i,
        ) );
        $wp_customize->selective_refresh->add_partial( 'slider_subtitle_' . $i, array(
            'selector'          => '.slide-item-' . $i . ' .subtitle',
            'render_callback'   => 'sydney_partial_slider_subtitle_' . $i,
        ) );        
    }    
    $wp_customize->selective_refresh->add_partial( 'slider_button_text', array(
        'selector'          => '.button-slider',
        'render_callback'   => 'sydney_partial_slider_button_text',
    ) );   

    //Divider
    class Sydney_Divider extends WP_Customize_Control {
         public function render_content() {
            echo '<hr style="margin: 15px 0;border-top: 1px dashed #919191;" />';
         }
    }
    //Titles
    class Sydney_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="padding:12px;color:#000;background:#cbcbcb;text-align:center;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    
    //Titles
    class Sydney_Theme_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }

    /**
     * Callbacks and sanitize
     */
    require get_template_directory() . '/inc/customizer/callbacks.php';
    require get_template_directory() . '/inc/customizer/sanitize.php';

    /**
     * Controls
     */
    //require get_template_directory() . '/inc/customizer/controls/typography/class_sydney_typography.php';
    require get_template_directory() . '/inc/customizer/controls/repeater/class_sydney_repeater.php';
    require get_template_directory() . '/inc/customizer/controls/alpha-color/class_sydney_alpha_color.php';
    require get_template_directory() . '/inc/customizer/controls/radio-images/class_sydney_radio_images.php';
    require get_template_directory() . '/inc/customizer/controls/radio-buttons/class_sydney_radio_buttons.php';
    require get_template_directory() . '/inc/customizer/controls/responsive-slider/class_sydney_responsive_slider.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_tab_control.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_text_control.php';
    //require get_template_directory() . '/inc/customizer/controls/class_sydney_tinymce_control.php';
    require get_template_directory() . '/inc/customizer/controls/class_sydney_divider_control.php';
    require get_template_directory() . '/inc/customizer/controls/toggle/class_sydney_toggle_control.php';
    //require get_template_directory() . '/inc/customizer/controls/color-palettes/class_sydney_color_palettes_control.php';
    //require get_template_directory() . '/inc/customizer/controls/color-palettes/class_sydney_custom_palettes_control.php';
    //require get_template_directory() . '/inc/customizer/controls/accordion/class_sydney_accordion_control.php';    

    require get_template_directory() . '/inc/customizer/controls/control-checkbox-multiple.php';
    require get_template_directory() . '/inc/customizer/controls/multiple-select/class-control-multiple-select.php';
    $wp_customize->register_control_type( 'Sydney_Select2_Custom_Control' 	);
    $wp_customize->register_control_type( '\Kirki\Control\sortable' );
    
    /**
     * Options
     */
    require get_template_directory() . '/inc/customizer/options/general.php';
    require get_template_directory() . '/inc/customizer/options/footer.php';
    require get_template_directory() . '/inc/customizer/options/blog.php';
    require get_template_directory() . '/inc/customizer/options/blog-single.php';

    //___Header area___//
    $wp_customize->add_panel( 'sydney_header_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header area', 'sydney'),
    ) );
    //___Header type___//
    $wp_customize->add_section(
        'sydney_header_type',
        array(
            'title'         => __('Header type', 'sydney'),
            'priority'      => 10,
            'panel'         => 'sydney_header_panel', 
            'description'   => __('You can select your header type from here. After that, continue below to the next two tabs (Header Slider and Header Image) and configure them.', 'sydney'),
        )
    );
    //Front page
    $wp_customize->add_setting(
        'front_header_type',
        array(
            'default'           => 'nothing',
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'front_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Front page header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the header type for your front page', 'sydney'),
            'choices' => array(
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'core-video'=> __('Video', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            ),
        )
    );
    //Site
    $wp_customize->add_setting(
        'site_header_type',
        array(
            'default'           => 'image',
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'site_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Site header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the header type for all pages except the front page', 'sydney'),
            'choices' => array(
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'core-video'=> __('Video', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            ),
        )
    );    
    //___Slider___//
    $wp_customize->add_section(
        'sydney_slider',
        array(
            'title'         => __('Header Slider', 'sydney'),
            'description'   => __('You can add up to 5 images in the slider. Make sure you select where to display your slider from the Header Type section found above. You can also add a Call to action button (scroll down to find the options)', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_header_panel',
        )
    );
    //Mobile slider
    $wp_customize->add_setting(
        'mobile_slider',
        array(
            'default'           => 'responsive',
            'sanitize_callback' => 'sydney_sanitize_mslider',
        )
    );
    $wp_customize->add_control(
        'mobile_slider',
        array(
            'type'        => 'radio',
            'label'       => __('Slider mobile behavior', 'sydney'),
            'section'     => 'sydney_slider',
            'priority'    => 99,
            'choices' => array(
                'fullscreen'    => __('Full screen', 'sydney'),
                'responsive'    => __('Responsive', 'sydney'),
            ),
        )
    );    
    //Speed
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default' => __('4000','sydney'),
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'slider_speed',
        array(
            'label' => __( 'Slider speed', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'number',
            'description'   => __('Slider speed in miliseconds. Use 0 to disable [default: 4000]', 'sydney'),       
            'priority' => 7
        )
    );
    $wp_customize->add_setting(
        'textslider_slide',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'textslider_slide',
        array(
            'type'      => 'checkbox',
            'label'     => __('Stop the text slider?', 'sydney'),
            'section'   => 'sydney_slider',
            'priority'  => 9,
        )
    );
    //Image 1
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's1', array(
        'label' => __('First slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_1',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            //'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_1',
            array(
               'label'          => __( 'Upload your first image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_1',
               'priority'       => 11,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_1',
        array(
            'default'           => __('Click the pencil icon to change this text','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'slider_title_1',
        array(
            'label' => __( 'Title for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_1',
        array(
            'default' => __('or go to the Customizer','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_1',
        array(
            'label' => __( 'Subtitle for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 13
        )
    );           
    //Image 2
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's2', array(
        'label' => __('Second slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 14
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_2',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            //'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_2',
            array(
               'label'          => __( 'Upload your second image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_2',
               'priority'       => 15,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_2',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_2',
        array(
            'label' => __( 'Title for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 16
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_2',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_2',
        array(
            'label' => __( 'Subtitle for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 17
        )
    );    
    //Image 3
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's3', array(
        'label' => __('Third slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 18
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_3',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_3',
            array(
               'label'          => __( 'Upload your third image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_3',
               'priority'       => 19,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_3',
        array(
            'label' => __( 'Title for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 20
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_3',
        array(
            'label' => __( 'Subtitle for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 21
        )
    );            
    //Image 4
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's4', array(
        'label' => __('Fourth slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 22
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_4',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_4',
            array(
               'label'          => __( 'Upload your fourth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_4',
               'priority'       => 23,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_4',
        array(
            'label' => __( 'Title for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 24
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_4',
        array(
            'label' => __( 'Subtitle for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 25
        )
    );    
    //Image 5
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's5', array(
        'label' => __('Fifth slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 26
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_5',
        array(
            'default-image'     => '',
            'sanitize_callback'  => 'esc_url_raw',
             'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_5',
            array(
               'label'          => __( 'Upload your fifth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_5',
               'priority'       => 27,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_5',
        array(
            'default'           => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_title_5',
        array(
            'label' => __( 'Title for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 28
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_5',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_5',
        array(
            'label' => __( 'Subtitle for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 29
        )
    );
    //Header button
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'hbutton', array(
        'label' => __('Call to action button', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 30
        ) )
    );     
    $wp_customize->add_setting(
        'slider_button_url',
        array(
            'default' => '#primary',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'                        
        )
    );
    $wp_customize->add_control(
        'slider_button_url',
        array(
            'label' => __( 'URL for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 31
        )
    );
    $wp_customize->add_setting(
        'slider_button_text',
        array(
            'default' => __('Click to begin','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        'slider_button_text',
        array(
            'label' => __( 'Text for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 32
        )
    );         
    //___Menu style___//
    $wp_customize->add_section(
        'sydney_menu_style',
        array(
            'title'         => __('Menu layout', 'sydney'),
            'priority'      => 15,
            'panel'         => 'sydney_header_panel', 
        )
    );
    //Sticky menu
    $wp_customize->add_setting(
        'sticky_menu',
        array(
            'default'           => 'sticky',
            'sanitize_callback' => 'sydney_sanitize_sticky',
        )
    );
    $wp_customize->add_control(
        'sticky_menu',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Sticky menu', 'sydney'),
            'section' => 'sydney_menu_style',
            'choices' => array(
                'sticky'   => __('Sticky', 'sydney'),
                'static'   => __('Static', 'sydney'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_style',
        array(
            'default'           => 'inline',
            'sanitize_callback' => 'sydney_sanitize_menu_style',
        )
    );
    $wp_customize->add_control(
        'menu_style',
        array(
            'type'      => 'radio',
            'priority'  => 11,
            'label'     => __('Menu style', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'inline'     => __('Inline', 'sydney'),
                'centered'   => __('Centered (menu and site logo)', 'sydney'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_container',
        array(
            'default'           => 'container',
            'sanitize_callback' => 'sydney_sanitize_menu_container',
        )
    );
    $wp_customize->add_control(
        'menu_container',
        array(
            'type'      => 'select',
            'priority'  => 11,
            'label'     => __('Menu container', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'container'         => __('Contained', 'sydney'),
                'fw-menu-container' => __('Full width', 'sydney'),
            ),
        )
    );    
    //Custom menu item
    $wp_customize->add_setting(
        'header_button_html',
        array(
            'default'           => 'nothing',
            'sanitize_callback' => 'sydney_sanitize_header_custom_item',
        )
    );
    $wp_customize->add_control(
        'header_button_html',
        array(
            'type'      => 'select',
            'priority'  => 11,
            'label'     => __('Header custom item', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'nothing'   => __( 'Nothing', 'sydney'  ),
                'button'    => __( 'Button', 'sydney'  ),
                'html'      => __( 'HTML', 'sydney'   ),
            ),
        )
    );    

    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Divider( $wp_customize, 'hcs_sep', array(
            'section' => 'sydney_menu_style',
            'settings' => 'sydney_options[info]',
            'priority' => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        ) )
    ); 

    $wp_customize->add_setting(
        'header_custom_item_btn_link',
        array(
            'default' => 'https://example.org/',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'header_custom_item_btn_link',
        array(
            'label'     => __( 'Button link', 'sydney' ),
            'section'   => 'sydney_menu_style',
            'type'      => 'text',
            'priority'  => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        )
    );
    $wp_customize->add_setting(
        'header_custom_item_btn_text',
        array(
            'default'           => __( 'Get in touch', 'sydney' ),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'header_custom_item_btn_text',
        array(
            'label'     => __( 'Button text', 'sydney' ),
            'section'   => 'sydney_menu_style',
            'type'      => 'text',
            'priority'  => 11,
            'active_callback' => 'sydney_header_custom_btn_active_callback'
        )
    );
    $wp_customize->add_setting(
        'header_custom_item_btn_target',
        array(
            'default'           => 1,
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'header_custom_item_btn_target',
        array(
            'type'              => 'checkbox',
            'label'             => __('Open link in a new tab?', 'sydney'),
            'section'           => 'sydney_menu_style',
            'priority'          => 11,
            'active_callback'   => 'sydney_header_custom_btn_active_callback'
        )
    );  
    $wp_customize->add_setting(
        'header_custom_item_btn_tb_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_tb_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Top/bottom button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 40,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );
    $wp_customize->add_setting(
        'header_custom_item_btn_lr_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '35',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_lr_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Left/right button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );
    //Font size
    $wp_customize->add_setting(
        'header_custom_item_btn_font_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '13',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_font_size', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Button font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) ); 
    //Border radius
    $wp_customize->add_setting(
        'header_custom_item_btn_radius',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '3',
            'transport'         => 'postMessage'
        )       
    );
    $wp_customize->add_control( 'header_custom_item_btn_radius', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Button border radius', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
        'active_callback'   => 'sydney_header_custom_btn_active_callback'
    ) );

    //Custom header html
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Divider( $wp_customize, 'hcs_html_sep', array(
            'section' => 'sydney_menu_style',
            'settings' => 'sydney_options[info]',
            'priority' => 11,
            'active_callback' => 'sydney_header_custom_html_active_callback'
        ) )
    );     
    $wp_customize->add_setting(
        'header_custom_item_html',
        array(
            'sanitize_callback' => 'sydney_sanitize_text',
            'default'           => '<a href="#">Your content</a>',
        )       
    );
    $wp_customize->add_control( 'header_custom_item_html', array(
        'type'        => 'textarea',
        'priority'    => 11,
        'section'     => 'sydney_menu_style',
        'label'       => __('Custom HTML', 'sydney'),
        'active_callback'   => 'sydney_header_custom_html_active_callback'
    ) );


    //Header image size
    $wp_customize->add_setting(
        'header_bg_size',
        array(
            'default'           => 'cover',
            'sanitize_callback' => 'sydney_sanitize_bg_size',
        )
    );
    $wp_customize->add_control(
        'header_bg_size',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Header background size', 'sydney'),
            'section' => 'header_image',
            'choices' => array(
                'cover'     => __('Cover', 'sydney'),
                'contain'   => __('Contain', 'sydney'),
            ),
        )
    );
    //Header height
    $wp_customize->add_setting(
        'header_height',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '300',
        )       
    );
    $wp_customize->add_control( 'header_height', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'header_image',
        'label'       => __('Header height [default: 300px]', 'sydney'),
        'input_attrs' => array(
            'min'   => 250,
            'max'   => 600,
            'step'  => 5,
        ),
    ) );
    //Disable overlay
    $wp_customize->add_setting(
        'hide_overlay',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_overlay',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable the overlay?', 'sydney'),
            'section'   => 'header_image',
            'priority'  => 12,
        )
    );    
    //Logo Upload
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'sydney' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 12,
            )
        )
    );

    //___Fonts___//
    $wp_customize->add_section(
        'sydney_fonts',
        array(
            'title' => __('Fonts', 'sydney'),
            'priority' => 15,
            'description' => sprintf( __( 'You can check out previews of the Google Fonts %s', 'sydney' ), '<a target="_blank" href="https://fonts.google.com">' . __( 'here', 'sydney' ) . '</a>' ),
        )
    );

    //Body fonts title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'general_fonts', array(
        'label' => __('General', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    
    //Body font subsets
    $wp_customize->add_setting(
        'font_subsets',
        array(
            'default'   => array( 'latin' ),
            'sanitize_callback' => 'sydney_sanitize_font_weights',
        )
    );

    $wp_customize->add_control( new Sydney_Select2_Custom_Control( $wp_customize, 'font_subsets', array(
        'label'     => __( 'Font subsets', 'sydney' ),
        'section'   => 'sydney_fonts',
        'priority'  => 10,
        'type'      => 'sydney-multiple-select',
        'input_attrs' => array(
            'multiple' => true,
        ),        
        'choices' => array( 
            'latin'         => 'Latin',
            'latin-ext'     => 'Latin Extended',
            'cyrillic'      => 'Cyrillic',
            'cyrillic-ext'  => 'Cyrillic Extended',
            'greek'         => 'Greek',
            'greek-ext'     => 'Greek Extended',
            'vietnamese'    => 'Vietnamese',
        ),
        ) )
    );   

    //Body fonts title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'body_fonts', array(
        'label' => __('Body fonts', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    
    //Body fonts
    $fonts = sydney_get_google_fonts();
    $fonts = array_combine( $fonts, $fonts );

    $wp_customize->add_setting(
        'body_font',
        array(
            'default'           => 'Raleway',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );

    $wp_customize->add_control( new Sydney_Select2_Custom_Control( $wp_customize, 'body_font', array(
        'label'     => __( 'Font family', 'sydney' ),
        'section'   => 'sydney_fonts',
        'type'      => 'sydney-multiple-select',      
        'priority' => 12,
        'choices' => $fonts  
        ) )
    );   



    $wp_customize->add_setting(
        'body_font_weights',
        array(
            'default'           =>  array('400', '600'),
            'sanitize_callback' => 'sydney_sanitize_font_weights',
        )
    );

    $wp_customize->add_control( new Sydney_Select2_Custom_Control( $wp_customize, 'body_font_weights', array(
        'label'         => __('Font weights', 'sydney'),
        'description'   => sprintf( __( 'Please make sure your selected font weights are actually available for your font. You can check %s', 'sydney' ), '<a target="_blank" href="https://fonts.google.com">' . __( 'here', 'sydney' ) . '</a>' ),
        'section' => 'sydney_fonts',
        'priority' => 13,
        'input_attrs' => array(
            'multiple' => true,
        ),        
        'choices' => array( 
            '100' => '100',
            '200' => '200',
            '300' => '300',
            '400' => '400',
            '500' => '500',
            '600' => '600',
            '700' => '700',
            '800' => '800',
            '900' => '900',
        ),
        ) )
    );   
    
    //Headings fonts title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'headings_fonts', array(
        'label' => __('Headings fonts', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 13
        ) )
    );      

    //Temp test headings font
    $wp_customize->add_setting(
        'headings_font',
        array(
            'default'           => 'Raleway',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );

    $wp_customize->add_control( new Sydney_Select2_Custom_Control( $wp_customize, 'headings_font', array(
        'label' => __( 'Font family', 'sydney' ),
        'section' => 'sydney_fonts',
        'type' => 'select',      
        'priority' => 14,
        'type'      => 'sydney-multiple-select',      
        'choices' => $fonts  
        ) )
    );      

    $wp_customize->add_setting(
        'headings_font_weights',
        array(
            'default'           => array( '600' ),
            'sanitize_callback' => 'sydney_sanitize_font_weights',
        )
    );

    $wp_customize->add_control( new Sydney_Select2_Custom_Control( $wp_customize, 'headings_font_weights', array(
        'label' => __('Font weights', 'sydney'),
        'description'   => sprintf( __( 'Please make sure your selected font weights are actually available for your font. You can check %s', 'sydney' ), '<a target="_blank" href="https://fonts.google.com">' . __( 'here', 'sydney' ) . '</a>' ),
        'section' => 'sydney_fonts',
        'priority' => 14,
        'input_attrs' => array(
            'multiple' => true,
        ),           
        'choices' => array( 
            '100' => '100',
            '200' => '200',
            '300' => '300',
            '400' => '400',
            '500' => '500',
            '600' => '600',
            '700' => '700',
            '800' => '800',
            '900' => '900',
        ),
        ) )
    );     

    //Font sizes title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'font_sizes', array(
        'label' => __('Font sizes', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 16
        ) )
    );
    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '32',
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Site title', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1,
        ),
    ) ); 
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Site description', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );  
    // Nav menu
    $wp_customize->add_setting(
        'menu_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
        )       
    );
    $wp_customize->add_control( 'menu_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Menu items', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );           
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '52',
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('H1 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '42',
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'sydney_fonts',
        'label'       => __('H2 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '32',
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'sydney_fonts',
        'label'       => __('H3 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '25',
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'sydney_fonts',
        'label'       => __('H4 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '20',
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'sydney_fonts',
        'label'       => __('H5 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'sydney_fonts',
        'label'       => __('H6 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'sydney_fonts',
        'label'       => __('Body font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
        ),
    ) );
    // Single post tiles
    $wp_customize->add_setting(
        'single_post_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '36',
        )       
    );
    $wp_customize->add_control( 'single_post_title_size', array(
        'type'        => 'number',
        'priority'    => 24,
        'section'     => 'sydney_fonts',
        'label'       => __('Single post title size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1,
        ),
    ) ); 
    //___Colors___//
    $wp_customize->add_panel( 'sydney_colors_panel', array(
        'priority'       => 19,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Colors', 'sydney'),
    ) );
    $wp_customize->add_section(
        'colors_header',
        array(
            'title'         => __('Header', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_colors_panel',
        )
    );
    $wp_customize->add_section(
        'colors_sidebar',
        array(
            'title'         => __('Sidebar', 'sydney'),
            'priority'      => 12,
            'panel'         => 'sydney_colors_panel',
        )
    );   
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#d65050',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'sydney'),
                'section'       => 'colors',
                'settings'      => 'primary_color',
                'priority'      => 11
            )
        )
    );
    //Menu bg
    $wp_customize->add_setting(
        'menu_bg_color',
        array(
            'default'           => '#263246',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_bg_color',
            array(
                'label' => __('Menu background', 'sydney'),
                'section' => 'colors_header',
                'priority' => 12
            )
        )
    );     
    //Site title
    $wp_customize->add_setting(
        'site_title_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title_color',
            array(
                'label' => __('Site title', 'sydney'),
                'section' => 'colors_header',
                'settings' => 'site_title_color',
                'priority' => 13
            )
        )
    );
    //Site desc
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' => __('Site description', 'sydney'),
                'section' => 'colors_header',
                'priority' => 14
            )
        )
    );
    //Top level menu items
    $wp_customize->add_setting(
        'top_items_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_items_color',
            array(
                'label' => __('Top level menu items', 'sydney'),
                'section' => 'colors_header',
                'priority' => 15
            )
        )
    );
    //Menu items hover
    $wp_customize->add_setting(
        'menu_items_hover',
        array(
            'default'           => '#d65050',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
        	'menu_items_hover',
            array(
                'label' => __('Menu items hover', 'sydney'),
                'section' => 'colors_header',
                'priority' => 15
            )
        )
    );

    //Sub menu items color
    $wp_customize->add_setting(
        'submenu_items_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'submenu_items_color',
            array(
                'label' => __('Sub-menu items', 'sydney'),
                'section' => 'colors_header',
                'priority' => 16
            )
        )
    );
    //Sub menu background
    $wp_customize->add_setting(
        'submenu_background',
        array(
            'default'           => '#1c1c1c',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'submenu_background',
            array(
                'label' => __('Sub-menu background', 'sydney'),
                'section' => 'colors_header',
                'priority' => 17
            )
        )
    );
    //Mobile menu
    $wp_customize->add_setting(
        'mobile_menu_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mobile_menu_color',
            array(
                'label' => __('Mobile menu button', 'sydney'),
                'section' => 'colors_header',
                'priority' => 17
            )
        )
    );    
    //Slider text
    $wp_customize->add_setting(
        'slider_text',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'slider_text',
            array(
                'label' => __('Header slider text', 'sydney'),
                'section' => 'colors_header',
                'priority' => 18
            )
        )
    );
    //Body
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#47425d',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Body text', 'sydney'),
                'section' => 'colors',
                'priority' => 19
            )
        )
    );    
    //Sidebar backgound
    $wp_customize->add_setting(
        'sidebar_background',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sidebar_background',
            array(
                'label' => __('Sidebar background', 'sydney'),
                'section' => 'colors_sidebar',
                'priority' => 20
            )
        )
    );
    //Sidebar color
    $wp_customize->add_setting(
        'sidebar_color',
        array(
            'default'           => '#767676',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sidebar_color',
            array(
                'label' => __('Sidebar color', 'sydney'),
                'section' => 'colors_sidebar',
                'priority' => 21
            )
        )
    );

    //___Theme info___//
    $wp_customize->add_section(
        'sydney_themeinfo',
        array(
            'title' => __('Theme info', 'sydney'),
            'priority' => 139,
            'description' => '<p style="padding-bottom: 10px;border-bottom: 1px solid #d3d2d2">' . __('1. Documentation for Sydney can be found ', 'sydney') . '<a target="_blank" href="https://docs.athemes.com/category/8-sydney">here</a></p><p style="padding-bottom: 10px;border-bottom: 1px solid #d3d2d2">' . __('2. A full theme demo can be found ', 'sydney') . '<a target="_blank" href="https://demo.athemes.com/sydney/">here</a></p>',         
        )
    );
    $wp_customize->add_setting('sydney_theme_docs', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Theme_Info( $wp_customize, 'documentation', array(
        'section' => 'sydney_themeinfo',
        'settings' => 'sydney_theme_docs',
        'priority' => 10
        ) )
    );  

    /* Woocommerce */
    //Sidebar
    $wp_customize->add_setting(
        'swc_sidebar_archives',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_sidebar_archives',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable sidebar on shop archive pages?', 'sydney'),
            'section'   => 'woocommerce_product_catalog',
            'priority'  => 14,
        )
    );  
    //Show cart button on hover
    $wp_customize->add_setting(
        'wc_button_hover',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'wc_button_hover',
        array(
            'type'      => 'checkbox',
            'label'     => __('Show add to cart button on hover?', 'sydney'),
            'section'   => 'woocommerce_product_catalog',
            'priority'  => 14,
        )
    );      
    //Sidebar
    $wp_customize->add_section(
        'sydney_wc_singles',
        array(
            'title'         => __('Single products', 'sydney'),
            'panel'         => 'woocommerce',
            'priority'      => 14,
        )
    );    
    $wp_customize->add_setting(
        'swc_sidebar_products',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
            'default'           => 1
        )       
    );
    $wp_customize->add_control(
        'swc_sidebar_products',
        array(
            'type'      => 'checkbox',
            'label'     => __('Remove sidebar from single products?', 'sydney'),
            'section'   => 'sydney_wc_singles',
            'priority'  => 14,
        )
    );    
    //YITH
    $wp_customize->add_setting(
        'yith_buttons_visible',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'yith_buttons_visible',
        array(
            'type'          => 'checkbox',
            'label'         => __('Always show buttons for YITH quick view, wishlist and compare?', 'sydney'),
            'description'   => __('If you\'re using the plugins above, checking this option will keep their respective buttons always visible', 'sydney'),
            'section'       => 'woocommerce_product_catalog',
            'priority'      => 15,
        )
    );
    //Disable overlay shop
    $wp_customize->add_setting(
        'hide_overlay_shop',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_overlay_shop',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable header image overlay on shop main page?', 'sydney'),
            'section'   => 'woocommerce_product_catalog',
            'priority'  => 16,
        )
    );              

}
add_action( 'customize_register', 'sydney_customize_register' );

/**
 * Sanitize
 */
//Header type
function sydney_sanitize_layout( $input ) {
    $valid = array(
        'slider'    => __('Full screen slider', 'sydney'),
        'image'     => __('Image', 'sydney'),
        'core-video'=> __('Video', 'sydney'),
        'nothing'   => __('Nothing (only menu)', 'sydney')
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

//Background size
function sydney_sanitize_bg_size( $input ) {
    $valid = array(
        'cover'     => __('Cover', 'sydney'),
        'contain'   => __('Contain', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Footer widget areas
function sydney_sanitize_fw( $input ) {
    $valid = array(
        '1'     => __('One', 'sydney'),
        '2'     => __('Two', 'sydney'),
        '3'     => __('Three', 'sydney'),
        '4'     => __('Four', 'sydney')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Sticky menu
function sydney_sanitize_sticky( $input ) {
    $valid = array(
        'sticky'     => __('Sticky', 'sydney'),
        'static'   => __('Static', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Blog Layout
function sydney_sanitize_blog( $input ) {
    $valid = array(
        'classic'    => __( 'Classic', 'sydney' ),
        'classic-alt'    => __( 'Classic (alternative)', 'sydney' ),
        'modern'    => __( 'Modern', 'sydney' ),
        'fullwidth'  => __( 'Full width (no sidebar)', 'sydney' ),
        'masonry-layout'    => __( 'Masonry (grid style)', 'sydney' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Mobile slider
function sydney_sanitize_mslider( $input ) {
    $valid = array(
        'fullscreen'    => __('Full screen', 'sydney'),
        'responsive'    => __('Responsive', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Menu style
function sydney_sanitize_menu_style( $input ) {
    $valid = array(
        'inline'     => __('Inline', 'sydney'),
        'centered'   => __('Centered (menu and site logo)', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Checkboxes
function sydney_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function sydney_sanitize_font_weights( $input ) {
    if ( is_array( $input ) ) {
        return $input;
    }
}
function sydney_sanitize_header_custom_item( $input ) {
    if ( in_array( $input, array( 'nothing', 'button', 'html' ), true ) ) {
        return $input;
    }
}
function sydney_sanitize_menu_container( $input ) {
    if ( in_array( $input, array( 'container', 'fw-menu-container' ), true ) ) {
        return $input;
    }
}
/**
 * Selects
 */
function sydney_sanitize_selects( $input, $setting ){
          
    $input = sanitize_key($input);

    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
      
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sydney_customize_preview_js() {
	wp_enqueue_script( 'sydney_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20210917', true );
}
add_action( 'customize_preview_init', 'sydney_customize_preview_js' );

/**
 * Customizer assets
 */
function sydney_customize_footer_scripts() {
    
    wp_enqueue_style( 'sydney-customizer-styles', get_template_directory_uri() . '/css/customizer.css', '', '20210917' );
    wp_enqueue_script( 'sydney-customizer-scripts', get_template_directory_uri() . '/js/customize-controls.js', array( 'jquery', 'jquery-ui-core' ), '20210917', true );

}
add_action( 'customize_controls_print_footer_scripts', 'sydney_customize_footer_scripts' );




/**
 * Partials callbacks
 */
//Slider titles
function sydney_partial_slider_title_1() {
    return get_theme_mod('slider_title_1', __('Click the pencil icon to change this text','sydney'));
}
function sydney_partial_slider_title_2() {
    return get_theme_mod('slider_title_2');
}
function sydney_partial_slider_title_3() {
    return get_theme_mod('slider_title_3');
}
function sydney_partial_slider_title_4() {
    return get_theme_mod('slider_title_4');
}
function sydney_partial_slider_title_5() {
    return get_theme_mod('slider_title_5');
}
//Slider subtitles
function sydney_partial_slider_subtitle_1() {
    return get_theme_mod('slider_subtitle_1', __('or go to the Customizer','sydney'));
}
function sydney_partial_slider_subtitle_2() {
    return get_theme_mod('slider_subtitle_2');
}
function sydney_partial_slider_subtitle_3() {
    return get_theme_mod('slider_subtitle_3');
}
function sydney_partial_slider_subtitle_4() {
    return get_theme_mod('slider_subtitle_4');
}
function sydney_partial_slider_subtitle_5() {
    return get_theme_mod('slider_subtitle_5');
}
function sydney_partial_slider_button_text() {
    return get_theme_mod('slider_button_text');
}
//Header custom items active callbacks
function sydney_header_custom_btn_active_callback() {
    $type = get_theme_mod( 'header_button_html' );

    if ( 'button' == $type ) {
        return true;
    } else {
        return false;
    }
}

function sydney_header_custom_html_active_callback() {
    $type = get_theme_mod( 'header_button_html' );

    if ( 'html' == $type ) {
        return true;
    } else {
        return false;
    }
}