<?php
defined('ABSPATH') or die();

    global $wp_filesystem;

    if (empty($wp_filesystem)) {
        require_once(ABSPATH .'/wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
        WP_Filesystem();
    }       


    // Internataionalization
    if(is_admin()){
        $locale = get_locale();
        $load=load_textdomain( 'lapindos', untrailingslashit(get_template_directory()). '/languages/' . $locale . '.mo' );
    }

    $opt_name = redux_opt_name();

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'lapindos' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'lapindos' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'lapindos' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'lapindos' )
        )
    );


    // Set the help sidebar
    $content = "<p>".esc_html__( 'This is the sidebar content, HTML is allowed.', 'lapindos' )."</p>";
    $post_types = get_post_types( array( 'public' => true ));

    // -> START Identity
    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Site Identity', 'lapindos' ),
        'id'               => 'identity',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-cog',
        'fields'           => array(
                array(
                    'id'=>'logo_image',
                    'type' => 'media', 
                    'title' => esc_html__('Image Logo', 'lapindos'),
                    'subtitle'=>esc_html__('Select image for the logo','lapindos'),
                    'compiler' => true,
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'logo_image_alt',
                    'type' => 'media', 
                    'title' => esc_html__('Image Logo Alt', 'lapindos'),
                    'subtitle'=>esc_html__('Alt logo will displayed on sticky menu.','lapindos'),
                    'compiler' => true,
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'       => 'site-title',
                    'type'     => 'text',
                    'default'  => get_bloginfo('name','raw'),
                    'value'    => get_bloginfo('name','raw'),
                    'title'    => esc_html__( 'Site Title','lapindos'),
                ),
                array(
                    'id'       => 'site-tagline',
                    'type'     => 'text',
                    'value'    => get_bloginfo( 'description','raw'),
                    'default'  => get_bloginfo( 'description','raw'),
                    'title'    => esc_html__( 'Tagline','lapindos'),
                ),
                array(
                    'id'=>'show-tagline',
                    'type' => 'switch', 
                    'title' => esc_html__('Show Tagline', 'lapindos'),
                    'subtitle'=> esc_html__('Show or hide tagline', 'lapindos'),
                    "default"=> 1,
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos')
                ),  
                array(
                    'id'=>'logo-type',
                    'type' => 'button_set',
                    'title' => esc_html__('Logo Type', 'lapindos'), 
                    'subtitle'=>esc_html__('Select logo type shown as site name','lapindos'),
                    'options'=>array(
                        'auto'=>esc_html__('Auto', 'lapindos'),
                        'image'=>esc_html__('Image Logo', 'lapindos'),
                        'title'=>esc_html__('Site Title', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'auto'
                ),
                array(
                    'id'=>'logo-position',
                    'type' => 'button_set',
                    'title' => esc_html__('Logo Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select logo placement','lapindos'),
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),

                array(
                    'title'            => esc_html__( 'Social Link', 'lapindos' ),
                    'id'               => 'social_link',
                    'type' => 'section',
                    'indent'   => false,
                    'description'=> esc_html__('Social link data. Field blank will not display.' ,'lapindos'),
                ),
                array(
                    'id'=>'social_fb',
                    'type' => 'text', 
                    'title' => esc_html__('Facebook Link', 'lapindos'),
                    'description'=>esc_html__( '( example: https://www.facebook.com/themegum/ )','lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_twitter',
                    'type' => 'text', 
                    'title' => esc_html__('Twitter Link', 'lapindos'),
                    'description'=> esc_html__('( example: https://twitter.com/temegum )' ,'lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_gplus',
                    'type' => 'text', 
                    'title' => esc_html__('Google Plus Link', 'lapindos'),
                    'description'=> esc_html__('( example: https://plus.google.com/u/0/1234567890123456789 )' ,'lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_linkedin',
                    'type' => 'text', 
                    'title' => esc_html__('Linkedin Link', 'lapindos'),
                    'description'=> esc_html__('( example: https://www.linkedin.com/ )' ,'lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_pinterest',
                    'type' => 'text', 
                    'title' => esc_html__('Pinterest Link', 'lapindos'),
                    'description'=> esc_html__('( example: https://id.pinterest.com/temegum/ )' ,'lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'social_instagram',
                    'type' => 'text', 
                    'title' => esc_html__('Instagram Link', 'lapindos'),
                    'description'=> esc_html__('( example: https://www.instagram.com/themegum_team/ )' ,'lapindos'),
                    'default'=>"",
                 ),
                array(
                    'id'=>'custom_socials',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Custom Social Links', 'lapindos'),
                    'subtitle'=> wp_kses( __('Add social link with custom icon.','lapindos'), array('strong'=>array())),
                    'sortable' => true,
                    'fields'=> array(
                        'link' => esc_html__('Link', 'lapindos'),
                        'label' => esc_html__('Label', 'lapindos'),
                        ),
                    'default' => array('facebook'=>array('label'=>'','link'=>''))
                )
             )
    ) );

    // -> START Heading
    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header', 'lapindos' ),
        'id'               => 'heading',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-tasks',
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'header-preset-section',
        'subsection' => true,
        'title'    => esc_html__( 'Pre-Sets', 'lapindos' ),
        'fields'           => array(
                array(
                    'id'         => 'header-presets',
                    'type'       => 'image_select',
                    'presets'    => true,
                    'title'      => esc_html__( 'HEADER LAYOUT PRESET', 'lapindos' ),
                    'subtitle'   => esc_html__( 'Select pre-define a header layout. Becareful! your last configuration will be lost.', 'lapindos' ),
                    'default'    => 0,
                    'options'    => array(
                        '15' => array(
                            'alt'     => esc_html__( 'Preset 15','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset15.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"0","header-layout":{"topbar":{"placebo":"placebo","social":"social","iconflat":"iconflat"},"middle":{"placebo":"placebo","search":"search","toggle":"toggle"},"bottom":{"placebo":"placebo","mainmenu":"mainmenu","button":"button"},"Disabled":{"placebo":"placebo","text":"text","menu1":"menu1","icongraphic":"icongraphic"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#222222","topbar-border-color":{"color":"#000000","alpha":"0.3","rgba":"rgba(0,0,0,0.3)"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"5px","padding-bottom":"5px"},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"#222222","bottom-border-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"0","padding-bottom":"0"},"header-shape":"0","sticky_menu_shape":"0","heading_position":"fixed","heading-height":"350","heading-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"page-title-offset":"-100px","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#222222","menu_iconflat_value_color":"#222222","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"#222222","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '16' => array(
                            'alt'     => esc_html__( 'Preset 16','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset16.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"0","header-layout":{"topbar":{"placebo":"placebo","social":"social","iconflat":"iconflat","search":"search","toggle":"toggle"},"middle":{"placebo":"placebo","icongraphic":"icongraphic"},"bottom":{"placebo":"placebo","mainmenu":"mainmenu","button":"button"},"Disabled":{"placebo":"placebo","text":"text","menu1":"menu1"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#222222","topbar-border-color":{"color":"#000000","alpha":"0.3","rgba":"rgba(0,0,0,0.3)"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"5px","padding-bottom":"5px"},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"#222222","bottom-border-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"0","padding-bottom":"0"},"header-shape":"0","sticky_menu_shape":"0","heading_position":"fixed","heading-height":"350","heading-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"page-title-offset":"-100px","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#222222","menu_icon_label_color":"#222222","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#222222","menu_iconflat_value_color":"#222222","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"#222222","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"1px","border-left":"0","border-style":"solid","border-color":"#5b5b5b"},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"5px","border-left":"0","border-style":"solid","border-color":"transparent"},"hover-menu-border":{"color":"#000000","alpha":"0.3","rgba":"rgba(0,0,0,0.3)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '17' => array(
                            'alt'     => esc_html__( 'Preset 17','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset17.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"0","header-layout":{"topbar":{"placebo":"placebo","social":"social","iconflat":"iconflat"},"middle":{"placebo":"placebo","icongraphic":"icongraphic","search":"search","toggle":"toggle"},"bottom":{"placebo":"placebo","mainmenu":"mainmenu","button":"button"},"Disabled":{"placebo":"placebo","text":"text","menu1":"menu1"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"25","topbar-section-spacing":{"padding-top":"5px","padding-bottom":"5px"},"topbar-radius":"0","topbar-bgcolor":{"color":"#002d5c","alpha":"1","rgba":"rgba(0,45,92,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#ffffff","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"half","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"navbar-color":"#ffffff","bottom-border-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"0","padding-bottom":"0"},"header-shape":"0","sticky_menu_shape":"0","heading_position":"fixed","heading-height":"350","heading-background-color":{"color":"#000000","alpha":"0.3","rgba":"rgba(0,0,0,0.3)"},"page-title-offset":"-100px","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Support? Drop us an email","text":"support@domain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#ffffff","menu_icon_label_color":"#ffffff","menu_icon_value_color":"#ffffff","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"#ffffff","hover":"#fde428"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"sticky-menu-color":{"regular":"#222222","hover":"#5aace2","active":"#5aace2"},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '18' => array(
                            'alt'     => esc_html__( 'Preset 18','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset18.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","header-layout":{"topbar":{"placebo":"placebo","social":"social","iconflat":"iconflat"},"middle":{"placebo":"placebo","mainmenu":"mainmenu","search":"search","toggle":"toggle"},"bottom":{"placebo":"placebo","button":"button","icongraphic":"icongraphic"},"Disabled":{"placebo":"placebo","text":"text","menu1":"menu1"}},"show_top_bar":"0","middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#2e96db","alpha":"0.8","rgba":"rgba(46,150,219,0.8)"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#ffffff","middle-section-height":"50","middle-section-radius":"0","middle-section-spacing":{"padding-top":"0px","padding-bottom":"0px"},"show_bottom_section":"0","header-shape":"0","sticky_menu_shape":"0","heading_position":"fixed","heading-height":"300","heading-background-color":{"color":"#000000","alpha":"0.3","rgba":"rgba(0,0,0,0.3)"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"sticky-menu-color":{"regular":"#222222","hover":"#5aace2","active":"#5aace2"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"sticky-menu-color":{"regular":"#222222","hover":"#5aace2","active":"#5aace2"},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '1' => array(
                            'alt'     => esc_html__( 'Preset 1','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset1.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"social","text":"text","menu1":"menu1","button":"button"},"middle":{"placebo":"placebo","icongraphic":"icongraphic"},"bottom":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"Disabled":{"placebo":"placebo","iconflat":"iconflat","toggle":"toggle"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"25","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"#","icon":"fa-star-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#1e73be","menu_iconflat_label_color":"#1e73be","menu_iconflat_value_color":"#1e73be","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '2' => array(
                            'alt'     => esc_html__( 'Preset 2','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset2.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info"},"middle":{"placebo":"placebo","button":"Button Link"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","icongraphic":"Icons Info","text":"Custom Text","menu1":"Menu 1"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '3' => array(
                            'alt'     => esc_html__( 'Preset 3','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset3.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","text":"Custom Text","menu1":"Menu 1"},"middle":{"placebo":"placebo","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"Disabled":{"placebo":"placebo","search":"Search Bar","iconflat":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"#","icon":"fa-star-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#1e73be","menu_iconflat_label_color":"#1e73be","menu_iconflat_value_color":"#1e73be","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '4' => array(
                            'alt'     => esc_html__( 'Preset 4','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset4.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"social","text":"text","menu1":"menu1","button":"button"},"middle":{"placebo":"placebo","icongraphic":"icongraphic"},"bottom":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"Disabled":{"placebo":"placebo","iconflat":"iconflat","toggle":"toggle"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"25","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"full","navbar-outer-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-inner-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"#","icon":"fa-star-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#1e73be","menu_iconflat_label_color":"#1e73be","menu_iconflat_value_color":"#1e73be","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '5' => array(
                            'alt'     => esc_html__( 'Preset 5','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset5.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","text":"Custom Text","menu1":"Menu 1"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","button":"Button Link"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"Disabled":{"placebo":"placebo","iconflat":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"full","navbar-outer-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-inner-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"#","icon":"fa-star-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#1e73be","menu_iconflat_label_color":"#1e73be","menu_iconflat_value_color":"#1e73be","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '6' => array(
                            'alt'     => esc_html__( 'Preset 6','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset6.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","text":"Custom Text","menu1":"Menu 1"},"middle":{"placebo":"placebo","icongraphic":"Icons Info","search":"Search Bar"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"Disabled":{"placebo":"placebo","iconflat":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#2e96db","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"full","navbar-outer-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-inner-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-color":"transparent","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"#","icon":"fa-star-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#1e73be","menu_iconflat_label_color":"#1e73be","menu_iconflat_value_color":"#1e73be","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '7' => array(
                            'alt'     => esc_html__( 'Preset 7','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset7.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar","button":"Button Link"},"middle":{"placebo":"placebo","mainmenu":"Main Menu"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1","icongraphic":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"25","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"0","header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '13' => array(
                            'alt'     => esc_html__( 'Preset 13','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset13.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar"},"middle":{"placebo":"placebo","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#fde428","alpha":"1","rgba":"rgba(253,228,40,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"transparent","bottom-border-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#222222","menu_icon_label_color":"#222222","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"#ffffff","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '14' => array(
                            'alt'     => esc_html__( 'Preset 14','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset14.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar"},"middle":{"placebo":"placebo","icongraphic":"Icons Info"},"bottom":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#fde428","alpha":"1","rgba":"rgba(253,228,40,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#222222","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#ffffff","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"transparent","bottom-border-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#ffffff","menu_icon_label_color":"#ffffff","menu_icon_value_color":"#ffffff","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#222222","menu_iconflat_label_color":"#222222","menu_iconflat_value_color":"#222222","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"#222222","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '8' => array(
                            'alt'     => esc_html__( 'Preset 8','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset8.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","text":"Custom Text","menu1":"Menu 1","icongraphic":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"0","header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '9' => array(
                            'alt'     => esc_html__( 'Preset 9','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset9.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar"},"middle":{"placebo":"placebo","mainmenu":"Main Menu"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","button":"Button Link","text":"Custom Text","menu1":"Menu 1","icongraphic":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"0","header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '10' => array(
                            'alt'     => esc_html__( 'Preset 10','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset10.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","menu1":"Menu 1"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","search":"Search Bar"},"bottom":{"placebo":"placebo"},"Disabled":{"placebo":"placebo","button":"Button Link","text":"Custom Text","icongraphic":"Icons Info"}},"show_top_bar":"1","topbar-layout-mode":"","topbar-responsiveness":"","topbar-height":"30","topbar-section-spacing":{"padding-top":"0","padding-bottom":"0"},"topbar-radius":"0","topbar-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"topbar-inner-bgcolor":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"0","header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '11' => array(
                            'alt'     => esc_html__( 'Preset 11','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset11.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1"},"middle":{"placebo":"placebo","mainmenu":"Main Menu"},"bottom":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar","button":"Button Link"},"Disabled":{"placebo":"placebo","text":"Custom Text","icongraphic":"Icons Info"}},"show_top_bar":"0","middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"#ffffff","bottom-border-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),
                        '12' => array(
                            'alt'     => esc_html__( 'Preset 12','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/preset12.png',
                            'presets' =>'{"show-tagline":"0","logo-type":"image","logo-position":"","social_fb":"#","social_twitter":"#","social_gplus":"#","social_linkedin":"#","social_pinterest":"","social_instagram":"#","custom_socials":[{"link":"","label":"","icon":""}],"header_shadow":"1","header-layout":{"topbar":{"placebo":"placebo","menu1":"Menu 1"},"middle":{"placebo":"placebo","mainmenu":"Main Menu","button":"Button Link"},"bottom":{"placebo":"placebo","social":"Social Icons","iconflat":"Icons Info","search":"Search Bar"},"Disabled":{"placebo":"placebo","text":"Custom Text","icongraphic":"Icons Info"}},"show_top_bar":"0","middle-layout-mode":"","middle-responsiveness":"xs","iconbar-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"iconbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"iconbar-color":"#222222","middle-section-height":"40","middle-section-radius":"0","middle-section-spacing":{"padding-top":"","padding-bottom":""},"show_bottom_section":"1","bottom-layout-mode":"","bottom-layout-indent":"","navbar-outer-bgcolor":{"color":"#2e96db","alpha":"1","rgba":"rgba(46,150,219,1)"},"navbar-inner-background-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"navbar-color":"#ffffff","bottom-border-color":{"color":"#000000","alpha":"0","rgba":"rgba(0,0,0,0)"},"bottom-section-height":"40","bottom-section-radius":"0","bottom-section-spacing":{"padding-top":"","padding-bottom":""},"header-shape":"0","sticky_menu_shape":"0","heading_position":"","heading-height":"250","heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-offset":"","sticky_menu":"1","sticky-layout-mode":"","sticky-mobile":"1","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"stickybar-spacing":{"padding-top":"5px","padding-bottom":"5px"},"sticky_shadow":"1","sticky-layout":{"active":{"placebo":"placebo","mainmenu":"mainmenu","search":"search"},"modules":{"placebo":"placebo","text":"text","button":"button","social":"social","toggle":"toggle","iconflat":"iconflat","menu1":"menu1","icongraphic":"icongraphic"}},"menu_icon_fields":[{"label":"Have a question? Call us now","text":"+62 123 456 789","url":"#","icon":"simple-line-earphones-alt"},{"label":"We are open Monday - Friday","text":"08:00 - 17:00","url":"#","icon":"simple-line-clock"},{"label":"Need support? Drop us an email","text":"support@yourdomain.com","url":"#","icon":"simple-line-envelope-letter"}],"icon_align":"right","icongraphic-responsiveness":"","menu_icon_color":"#2e96db","menu_icon_label_color":"#2e96db","menu_icon_value_color":"#747578","sticky_icongraphic_skin":"0","menu_iconflat_fields":[{"label":"Call Us:","text":"(+62) 445-2808","url":"#","icon":"fa-phone"},{"label":"99 S.t Jomblo Park Banyuwangi","text":"","url":"","icon":"fa-map-marker"},{"label":"Monday to Friday:","text":"7:00 AM - 5:00 PM","url":"","icon":"fa-clock-o"}],"iconflat_align":"right","iconflat-responsiveness":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","sticky_iconflat_skin":"0","text-module":"24/7 Support Service","text-responsiveness":"","quote_menu_label":"Get a Quote","quote_menu_link":"#","quote_menu_link_target":"blank","button-responsiveness":"mobile","button_skin":"secondary-thirdy","button_shape":"rectangle","button_size":"btn-sm","button-radius":"0","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"sticky_menu_skin":"0","social_link_target":"","social_show_label":"0","social-responsiveness":"","social_color":{"regular":"","hover":"#ffffff"},"social_bg_color":{"regular":"","hover":""},"sticky_social_skin":"0","menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5aace2","alpha":"1","rgba":"rgba(90,172,226,1)"},"menu-color":{"regular":"#222222","hover":"#2e96db","active":"#2e96db"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"top-bar-menu-1":"55","menu1-responsiveness":"mobile","short_menu_color":{"regular":"","hover":""},"sticky_short_menu_skin":"0","toggle-icon":"fa-sign-in","toggle-slide-color":{"regular":"","hover":""},"sliding_size":""}'
                        ),

                    ),
                ),
        )));



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'header-layout-section',
        'subsection' => true,
        'title'    => esc_html__( 'Layout', 'lapindos' ),
        'fields'           => array(
                array(
                    'id'        => 'header_shadow',
                    'title'     => esc_html__('Bottom Shadow', 'lapindos'), 
                    'subtitle'      => esc_html__('Add shadow on header bottom.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos'),
                    'default'   => 0
                ),
                 array(
                    'id'       => 'header-layout',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'HEADER CUSTOM LAYOUT','lapindos'),
                    'subtitle' => esc_html__( 'Select the module and to section available.','lapindos'),
                    'full_width' => true,
                    'options'  => array(
                        'topbar'  => array(
                            'title'=> esc_html__('Top Section','lapindos'),
                            'desc' => esc_html__( 'Drag module from modules box.', 'lapindos' ),
                            'fields'=>array(
                                'text' => esc_html__( 'Free Text','lapindos'),
                                'social'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-social.png', 'title'=>esc_html__( 'Social Icons','lapindos'))
                            )
                        ),
                        'middle' => array(
                            'title'=> esc_html__('Middle Section','lapindos'),
                            'desc' => esc_html__( 'The logo automatic displayed at this section.', 'lapindos' ),
                            'fields'=>array(
                                'mainmenu'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-menu.png', 'title'=>esc_html__( 'Main Menu','lapindos'))
                            )
                        ),
                        'bottom' => array(
                            'title'=> esc_html__('Bottom Section','lapindos'),
                            'desc' => esc_html__( 'Drag module from modules box. This section usualy for navigation menu.', 'lapindos' ),
                            'fields'=>array()
                        ),
                        'modules'   => array(
                            'title'=> esc_html__('Modules Available','lapindos'),
                            'desc' => esc_html__( 'Select the module by dragging on module name and drop on section box.', 'lapindos' ),
                            'fields'=>array(
                                'button'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-button.png', 'title'=>esc_html__( 'Button Link','lapindos')),
                                'icongraphic'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-icongraphic.png', 'title'=>esc_html__( 'Icons Info', 'lapindos' )),                                
                                'iconflat' => array('thumb'=> get_template_directory_uri().'/lib/images/module-iconflat.png', 'title'=>esc_html__( 'Icons Info (Flat)','lapindos')),
                                'search' => array('thumb'=> get_template_directory_uri().'/lib/images/module-search.png', 'title'=>esc_html__( 'Search & Cart','lapindos')),
                                'menu1' => array('thumb'=> get_template_directory_uri().'/lib/images/module-shortmenu.png', 'title'=>esc_html__( 'Short Menu','lapindos')),
                                'toggle' => array('title'=>esc_html__( 'Side Menu Toggle','lapindos'), 'thumb'     => get_template_directory_uri().'/lib/images/module-toggle.png'),

                                )
                        ),
                    )
                ),
                array(
                    'id'   => 'header-info',
                    'type' => 'info',
                    'desc' => esc_html__( 'Element style option see header elements section.', 'lapindos' ),
                ),


        )));



    ThemegumRedux::setSection( $opt_name, array(
        'title'    => esc_html__( 'Top Section Settings', 'lapindos' ),
        'id'               => 'topbar-header-start',
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'        => 'show_top_bar',
                    'title'     => esc_html__('Active', 'lapindos'), 
                    'subtitle'      => esc_html__('Enable or disable top header section.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos'),
                    'default'   => 1
                ),
                array(
                    'id'=>'topbar-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'wide'=>esc_html__('Wide', 'lapindos'),
                        'boxed'=>esc_html__('Boxed', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'topbar-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'topbar-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','lapindos'),
                    'subtitle' => esc_html__( 'Minimum top bar height in px', 'lapindos' ),
                    'default'       => 35,
                    'min'           => 20,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'topbar-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'lapindos' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'lapindos' ),
                    'default'        => array(
                        'padding-top'    => '5px',
                        'padding-bottom' => '5px',
                    )
                ),

                array(
                    'id'       => 'topbar-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','lapindos'),
                    'desc' => esc_html__( 'Border radius in px', 'lapindos' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'topbar-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#2e96db',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'topbar-inner-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#000000',
                        'alpha' => '0'
                    ),
                ),
                array(
                    'id'       => 'topbar-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'default'  => '#ffffff',
                ),
                array(
                    'id'       => 'topbar-border-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Bottom', 'lapindos' ),
                    'default'  => array(
                        'color'  => '',
                        'alpha' => ''
                    )
                ),

                )
            )
        );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'icon-header-start',
        'title'    => esc_html__( 'Middle Section Settings', 'lapindos' ),
        'desc'     => esc_html__( 'This section will collapse when screen below 768px ( mobile ).','lapindos'),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'=>'middle-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'wide'=>esc_html__('Wide', 'lapindos'),
                        'boxed'=>esc_html__('Boxed', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'middle-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'iconbar-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'iconbar-inner-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#000000',
                        'alpha' => '0'
                    ),
                ),
                array(
                    'id'       => 'iconbar-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'default'  => '#2e96db',

                ),
                array(
                    'id'       => 'middle-section-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','lapindos'),
                    'subtitle' => esc_html__( 'Minimum middle section height in px', 'lapindos' ),
                    'default'       => 40,
                    'min'           => 40,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'middle-section-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','lapindos'),
                    'desc' => esc_html__( 'Border radius in px', 'lapindos' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'middle-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'lapindos' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'lapindos' ),
                    'default'        => array(
                        'padding-top'    => '20px',
                        'padding-bottom' => '20px',
                    )
                ),
            )
        )
    );

 ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'navigation-header-start',
        'title'    => esc_html__( 'Bottom Section Settings', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'        => 'show_bottom_section',
                    'title'     => esc_html__('Active', 'lapindos'), 
                    'subtitle'      => esc_html__('Enable or disable bottom header section.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos'),
                    'default'   => 0
                ),
                array(
                    'id'=>'bottom-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'wide'=>esc_html__('Wide', 'lapindos'),
                        'boxed'=>esc_html__('Boxed', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'bottom-layout-indent',
                    'type' => 'button_set',
                    'title' => esc_html__('Hang Down Mode', 'lapindos'), 
                    'subtitle'=> esc_html__('Half section hang down.', 'lapindos'),
                    'options'=>array(
                        ''=>esc_html__('No', 'lapindos'),
                        'half'=>esc_html__('Half of Height', 'lapindos'),
                        'full'=>esc_html__('Full of Height', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>0
                ),
                array(
                    'id'       => 'navbar-outer-bgcolor',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),

                array(
                    'id'       => 'navbar-inner-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background Color', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'navbar-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'default'  => '#222222',
                    'transparent' => false,
                ),
                array(
                    'id'       => 'bottom-border-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Border Top', 'lapindos' ),
                    'default'  => array(
                        'color'  => '#333333',
                        'alpha' => '1'
                    )
                ),
                array(
                    'id'       => 'bottom-section-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','lapindos'),
                    'desc' => esc_html__( 'Minimum bottom section height in px', 'lapindos' ),
                    'default'       => 40,
                    'min'           => 40,
                    'step'          => 5,
                    'max'           => 300,
                    'display_value' => 'text'
                ),
                array(
                    'id'       => 'bottom-section-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','lapindos'),
                    'desc' => esc_html__( 'Border radius in px', 'lapindos' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text'
                ),
                array(
                    'id'             => 'bottom-section-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'lapindos' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'lapindos' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-bottom' => '',
                    )
                ),

            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'header-shape-section',
        'subsection' => true,
        'title'    => esc_html__( 'Bottom Shape', 'lapindos' ),
        'fields'           => array(

                array(
                    'id'       => 'header-shape',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shape','lapindos'),
                    'subtitle' => esc_html__( 'Select bottom shape for header.','lapindos'),
                    'default'    => 0,
                    'options'  => array(
                        '0'  => array(
                            'alt'     => esc_html__( 'None','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/shape_normal.png',
                        ),
                        '1' => array(
                            'alt'     => esc_html__( 'Triangle','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/shape_triangle.png',
                        ),
                        '2' => array(
                            'alt'     => esc_html__( 'Curve','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/shape_curve.png',
                        ),
                        )
                    ),
                    array(
                        'id'        => 'sticky_menu_shape',
                        'title'     => esc_html__('Stickybar Shape', 'lapindos'), 
                        'description'      => esc_html__('Activated shape in sticky bar.','lapindos'),
                        'type'      => 'switch',
                        'on' => esc_html__('Yes', 'lapindos'),
                        'off' => esc_html__('No', 'lapindos'),
                        'default'   => '0'
                    ),

                    array(
                        'title'    => esc_html__( 'Shape Height','lapindos'),
                        'id'       => 'height',
                        'type'     => 'text',
                        'default'  => '',
                        'description' => esc_html__('Type the height in px. The default is 100px.','lapindos'),
                        'value'    => '',
                    ),
                    array(
                        'title'    => esc_html__( 'Height Wave','lapindos'),
                        'id'       => 'height_wave',
                        'type'     => 'text',
                        'default'  => '',
                        'description' => esc_html__('Enter value 0 - 100.','lapindos'),
                        'value'    => '',
                    ),
                    array(
                        'title'    => esc_html__( 'Peak Position','lapindos'),
                        'id'       => 'peak_position',
                        'type'     => 'text',
                        'subtitle' => esc_html__( 'Peak position fron leftside','lapindos'),
                        'default'  => '',
                        'description' => esc_html__('Enter value 0 - 100. 50 mean center.','lapindos'),
                        'value'    => '',
                        'required' => array( 'header-shape', '=', array( '1') ),
                    ),
                    array(
                        'title'    => esc_html__( 'Control Point','lapindos'),
                        'id'       => 'control_point',
                        'type'     => 'text',
                        'default'  => '',
                        'description' => esc_html__('Enter value -100 - 100.','lapindos'),
                        'value'    => '',
                        'required' => array( 'header-shape', '=', array( '2') ),
                    ),
                    array(
                        'title'    => esc_html__( 'Repeat Pattern #','lapindos'),
                        'id'       => 'repeat_pattern',
                        'type'     => 'text',
                        'default'  => '',
                        'description' => esc_html__('How many pattern repeated.','lapindos'),
                        'value'    => '',
                    ),
                    array(
                        'id'       => 'pattern_color',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Pattern Color', 'lapindos' ),
                        'subtitle' => esc_html__( 'Pick a color shape pattern.', 'lapindos' ),
                        'default'  => '#ffffff',
                        'transparent'=> false,
                        'validate' => 'color',
                    ),

    )));

 ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'heading-header-start',
        'title'    => esc_html__( 'Page Heading', 'lapindos' ),
        'desc' => esc_html__( 'Page Heading Settings.', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(

                array(
                    'id'=>'heading_image',
                    'type' => 'media', 
                    'title' => esc_html__('Heading Image', 'lapindos'),
                    'subtitle'=>esc_html__('Select image using for heading background.','lapindos'),
                    'compiler' => true,
                    'description' => esc_html__('Recomended 1500px wide.','lapindos'),
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'heading_position',
                    'type' => 'radio',
                    'title' => esc_html__('Image Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select image position','lapindos'),
                    'desc'=>esc_html__('Default position is relative, image following page scrolling.','lapindos'),
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'fixed'=>esc_html__('Fixed', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'heading-height',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Minimum Height','lapindos'),
                    'subtitle' => esc_html__( 'Minimum height in px.', 'lapindos' ),
                    'default'       => 205,
                    'min'           => 145,
                    'step'          => 5,
                    'max'           => 600,
                    'display_value' => 'text',
                ),
                array(
                    'id'       => 'heading-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for heading background', 'lapindos' ),
                    'default'  => array(
                        'color' => '#212635',
                        'alpha' => '0.1'
                    ),
                ),
                array(
                    'id'       => 'page-style-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Page Title & Breadcrumb', 'lapindos' ),
                    'subtitle' => esc_html__( 'Title & breadcrumb configuration.', 'lapindos' ),
                    'indent'   => false, 
                ),
                array(
                    'id'=>'page_title',
                    'type' => 'switch', 
                    'title' => esc_html__('Page Title', 'lapindos'),
                    'subtitle'=> esc_html__('Show or hidden page title at heading', 'lapindos'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'lapindos'),
                    'off' => esc_html__('Hidden', 'lapindos')
                ),  
                array(
                    'id'=>'use_breadcrumb',
                    'type' => 'switch', 
                    'title' => esc_html__('Breadcrumb', 'lapindos'),
                    'subtitle'=> esc_html__('Show or hidden breadcrumb at heading', 'lapindos'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'lapindos'),
                    'off' => esc_html__('Hidden', 'lapindos')
                ),  
                array(
                    'id'       => 'heading_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Placement', 'lapindos' ),
                    'subtitle' => esc_html__( 'Page title and breadcrumb alignment.', 'lapindos' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'lapindos' ),
                        'center' => esc_html__( 'Center', 'lapindos' ),
                        'right' => esc_html__( 'Right', 'lapindos' ),
                    ),
                    'default'  => 'center'
                ),
                array(
                    'title'    => esc_html__( 'Vertical Offset','lapindos'),
                    'id'       => 'page-title-offset',
                    'type'     => 'text',
                    'default'  => '',
                    'description' => esc_html__('Adjust vertical placement. Positive value for more up or minus for more down.','lapindos'),
                    'value'    => '',
                ),
                array(
                    'id'       => 'page-title-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Page Title Color', 'lapindos' ),
                    'default'  => '#333333',
                    'transparent' => false
                ),
                array(
                    'id'       => 'breadcrumb-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Breadcrumb Color', 'lapindos' ),
                    'default'  => '#333333',
                    'transparent' => false
                ),
                array(
                    'id'       => 'breadcrumb-link-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Breadcrumb Link Color', 'lapindos' ),
                    'default'  => '#333333',
                    'transparent' => false
                ),
            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'sticky-section',
        'title'    => esc_html__( 'Sticky Bar', 'lapindos' ),
        'desc' => esc_html__( 'Sticky navigation bar', 'lapindos' ),
        'icon'             => 'el el-minus',
        'subsection' => false,
        'fields'           => array(
                array(
                    'id'        => 'sticky_menu',
                    'title'     => esc_html__('Active', 'lapindos'), 
                    'description'      => esc_html__('Menu position when screen scroll down','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos'),
                    'default'   => 0
                ),
                array(
                    'id'=>'sticky-layout-mode',
                    'type' => 'button_set',
                    'title' => esc_html__('Layout Mode', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Default', 'lapindos'),
                        'wide'=>esc_html__('Wide', 'lapindos'),
                        'boxed'=>esc_html__('Boxed', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'sticky-mobile',
                    'type' => 'switch',
                    'title' => esc_html__('Sticky for Mobile', 'lapindos'), 
                    'subtitle'=> esc_html__('Sticky mode on 600px screen.', 'lapindos'),
                    'on'=> esc_html__('Enable', 'lapindos'),
                    'off'=> esc_html__('Disable', 'lapindos'),
                    'default'=> 0
                ),
                array(
                    'id'       => 'sticky-color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'lapindos' ),
                    'default'  => '',
                    'desc' => esc_html__( 'Default color. Each element can customized in element styles section.', 'lapindos' ),
                    'transparent' => false,
                ),
                array(
                    'id'       => 'mobile-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Outer Background', 'lapindos' ),
                    'desc' => esc_html__( 'Background color for stickybar', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1',
                    ),
                ), 
               array(
                    'id'       => 'mobile-inside-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Inner Background', 'lapindos' ),
                    'desc' => esc_html__( 'Background color for inner sticky menu also for mobile menu top bar.', 'lapindos' ),
                    'default'  => array(
                        'color' => '',
                        'alpha' => '0',
                    ),
                ),
                array(
                    'id'             => 'stickybar-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'left'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Vertical Padding', 'lapindos' ),
                    'desc'           => esc_html__( 'You can adjust content position by set padding top/bottom.', 'lapindos' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-bottom' => '',
                    )
                ),
                array(
                    'id'        => 'sticky_shadow',
                    'title'     => esc_html__('Stickybar Shadow', 'lapindos'), 
                    'description'      => esc_html__('Add shadow to stickybar','lapindos'),
                    'type'      => 'button_set',
                    'options' => array(
                        '1' => esc_html__('Yes', 'lapindos'),
                        '2' => esc_html__('Inner only', 'lapindos'),
                        '0' => esc_html__('No', 'lapindos')
                    ),
                    'default'   => '0'
                ),
                 array(
                    'id'       => 'sticky-layout',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'LAYOUT','lapindos'),
                    'subtitle' => esc_html__( 'Select the module and to section available.','lapindos'),
                    'full_width' => true,
                    'options'  => array(
                        'active'  => array(
                            'title'=> esc_html__('Modules Selected','lapindos'),
                            'desc' => esc_html__( 'Drag module from modules box.', 'lapindos' ),
                            'fields'=>array(
                                'mainmenu'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-menu.png', 'title'=>esc_html__( 'Main Menu','lapindos'))
                            )
                        ),
                        'modules'   => array(
                            'title'=> esc_html__('Modules Available','lapindos'),
                            'desc' => esc_html__( 'Select the module by dragging on module name and drop on section box.', 'lapindos' ),
                            'fields'=>array(
                                'text' => esc_html__( 'Free Text','lapindos'),
                                'social'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-social.png', 'title'=>esc_html__( 'Social Icons','lapindos')),
                                'button'     => array('thumb'=> get_template_directory_uri().'/lib/images/module-button.png', 'title'=>esc_html__( 'Button Link','lapindos')),
                                'icongraphic'   => array('thumb'=> get_template_directory_uri().'/lib/images/module-icongraphic.png', 'title'=>esc_html__( 'Icons Info', 'lapindos' )),                                
                                'iconflat' => array('thumb'=> get_template_directory_uri().'/lib/images/module-iconflat.png', 'title'=>esc_html__( 'Icons Info (Flat)','lapindos')),
                                'search' => array('thumb'=> get_template_directory_uri().'/lib/images/module-search.png', 'title'=>esc_html__( 'Search & Cart','lapindos')),
                                'menu1' => array('thumb'=> get_template_directory_uri().'/lib/images/module-shortmenu.png', 'title'=>esc_html__( 'Short Menu','lapindos')),
                                'toggle' => array('title'=>esc_html__( 'Side Menu Toggle','lapindos'), 'thumb'     => get_template_directory_uri().'/lib/images/module-toggle.png'),

                                )
                        ),
                    )
                ),
                array(
                    'id'   => 'sticky-bar-info',
                    'type' => 'info',
                    'desc' => esc_html__( 'Element style option see header elements section.', 'lapindos' ),
                ),


            )
        )
    );


    // -> START Heading Element
    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Element Styles', 'lapindos' ),
        'id'               => 'heading-element',
        'customizer_width' => '400px',
        'customizer'=> false,
        'icon'             => 'el el-tasks',
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menuicon-header-section',
        'subsection' => true,
        'title'    => esc_html__( 'Icons Info', 'lapindos' ),
        'desc' => esc_html__( 'Configure navigation icon items.', 'lapindos' ),
        'fields'           => array(
                array(
                    'id'=>'menu_icon_fields',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Source Icons', 'lapindos'),
                    'sortable' => true,
                    'fields'=> array(
                        'label' => esc_html__('Label', 'lapindos'),
                        'text' => esc_html__('Text', 'lapindos'),
                        'url' => esc_html__('Link', 'lapindos'),
                        )
                ),
                array(
                    'id'       => 'icon_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Align', 'lapindos' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'lapindos' ),
                        'center' => esc_html__( 'Center', 'lapindos' ),
                        'right' => esc_html__( 'Right', 'lapindos' ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'=>'icongraphic-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'menu_icon_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'lapindos' ),
                    'default'  => '#2e96db',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_icon_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'default'  => '#2e96db',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_icon_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for text.', 'lapindos' ),
                    'default'  => '#747578',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'        => 'sticky_icongraphic_skin',
                    'title'     => esc_html__('STICKY STYLE', 'lapindos'), 
                    'description'      => esc_html__('Icons info style for sticky element.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Other Color', 'lapindos'),
                    'off' => esc_html__('Normal', 'lapindos'),
                    'default'   => 0
                ),

                array(
                    'id'       => 'icongraphic_sticky_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_icongraphic_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'icongraphic_sticky_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_icongraphic_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'icongraphic_sticky_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_icongraphic_skin', '=', 1 ),
                )


        )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menuiconflat-header-section',
        'subsection' => true,
        'title'    => esc_html__( 'Icons Info (Flat)', 'lapindos' ),
        'desc' => esc_html__( 'Configure navigation icon items. The icon will showing inline', 'lapindos' ),
        'fields'           => array(
                array(
                    'id'=>'menu_iconflat_fields',
                    'type' => 'icon_multi_text',
                    'title' => esc_html__('Source Icons', 'lapindos'),
                    'sortable' => true,
                    'fields'=> array(
                        'label' => esc_html__('Label', 'lapindos'),
                        'text' => esc_html__('Text', 'lapindos'),
                        'url' => esc_html__('Link', 'lapindos'),
                        )
                ),
                array(
                    'id'       => 'iconflat_align',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Align', 'lapindos' ),
                    'options'  => array(
                        'left' => esc_html__( 'Left', 'lapindos' ),
                        'center' => esc_html__( 'Center', 'lapindos' ),
                        'right' => esc_html__( 'Right', 'lapindos' ),
                    ),
                    'default'  => 'right'
                ),
                array(
                    'id'=>'iconflat-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'       => 'menu_iconflat_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'lapindos' ),
                    'default'  => '#fde428',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_iconflat_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'default'  => '#ffffff',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'       => 'menu_iconflat_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Text Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for text.', 'lapindos' ),
                    'default'  => '#ffffff',
                    'transparent'=> false,
                    'validate' => 'color',
                ),
                array(
                    'id'        => 'sticky_iconflat_skin',
                    'title'     => esc_html__('STICKY STYLE', 'lapindos'), 
                    'description'      => esc_html__('Flat icons style for sticky element.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Other Color', 'lapindos'),
                    'off' => esc_html__('Normal', 'lapindos'),
                    'default'   => 0
                ),

                array(
                    'id'       => 'iconflat_sticky_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Icon Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for icon.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_iconflat_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'iconflat_sticky_label_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_iconflat_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'iconflat_sticky_value_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for label.', 'lapindos' ),
                    'transparent'=> false,
                    'validate' => 'color',
                    'default'  => '',
                    'required' => array( 'sticky_iconflat_skin', '=', 1 ),
                )


        )));



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'text-module-section',
        'subsection' => true,
        'title'    => esc_html__( 'Custom Text','lapindos'),
        'fields'           => array(
                array(
                    'id'           => 'text-module',
                    'type'         => 'textarea',
                    'title'        => esc_html__( 'Free Content', 'lapindos' ),
                    'subtitle'     => esc_html__( 'Custom HTML Allowed (wp_kses)', 'lapindos' ),
                    'desc'         => esc_html__( 'This content just allow simple html content.', 'lapindos' ),
                    'validate'     => 'html_custom',
                    'default'      => '',
                    'allowed_html' => array(
                        'a'      => array(
                            'href'  => array(),
                            'title' => array(),
                            'target'=>array(),
                            'class' => array()
                        ),
                        'br'     => array(),
                        'em'     => array(),
                        'strong' => array(),
                        'span'   => array(
                            'class' => array()
                        ),
                        'img'    => array(
                            'src' => array(),
                            'class' => array()
                        )
                    ) //see http://codex.wordpress.org/Function_Reference/wp_kses
                ),
                array(
                    'id'=>'text-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'button-section',
        'subsection' => true,
        'title'    => esc_html__( 'Button','lapindos'),
        'fields'           => array(
                array(
                    'title'    => esc_html__( 'Label','lapindos'),
                    'id'       => 'quote_menu_label',
                    'type'     => 'text',
                    'default'  => esc_html__('Get a Quote', 'lapindos'),
                    'value'    => '',
                ),
                array(
                    'title'    => esc_html__( 'Link','lapindos'),
                    'id'       => 'quote_menu_link',
                    'type'     => 'text',
                    'default'  => '#',
                    'value'    => '',
                ),
                array(
                    'id'=>'quote_menu_link_target',
                    'type' => 'button_set',
                    'title' => esc_html__('Link Target','lapindos'),
                    'options'=>array(
                          'self'=>esc_html__("Same frame", 'lapindos'),
                          'blank'=>esc_html__("New window", 'lapindos'),
                          'parent'=> esc_html__("Parent frameset", 'lapindos'),
                          'top'=> esc_html__("Full body of the window", 'lapindos'),
                        ),
                    'default'=> 'blank',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'=>'button-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),
                array(
                    'id'=>'button_skin',
                    'type' => 'button_set',
                    'title' => esc_html__('Button Skin','lapindos'),
                    'options'=>lapindos_wp_landing_button_skin(),
                    'default'=> 'default',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'=>'button_shape',
                    'type' => 'button_set',
                    'title' => esc_html__('Button Shape','lapindos'),
                    'options'=> array(
                            ''=>esc_html__('Default','lapindos'),
                            'rectangle'=>esc_html__('Rectangular','lapindos'),
                            'rounded'=>esc_html__('Rounded','lapindos'),
                            'custom'=>esc_html__('Custom','lapindos')
                    ),
                    'default'=> '',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'=>'button_size',
                    'type' => 'button_set',
                    'title' => esc_html__('Button Size','lapindos'),
                    'options'=> array(
                            ''=>esc_html__('Default','lapindos'),
                            'btn-lg'=>esc_html__('Large','lapindos'),
                            'btn-md'=>esc_html__('Medium','lapindos'),
                            'btn-sm'=>esc_html__('Small','lapindos'),
                            'btn-xs'=>esc_html__('Extra small','lapindos'),
                    ),
                    'default'=> '',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'       => 'button-radius',
                    'type'     => 'slider',
                    'title'    => esc_html__( 'Border Radius','lapindos'),
                    'desc' => esc_html__( 'Border radius in px', 'lapindos' ),
                    'default'       => 0,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required' => array( 'button_shape', '=', array( 'custom') ),
                ),
                array(
                    'id'       => 'quote_menu_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button label.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                ),
                array(
                    'id'       => 'quote_menu_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),

                ),
                array(
                    'id'       => 'quote_menu_border_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Border Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button border color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),

                ),
                array(
                    'id'        => 'sticky_menu_skin',
                    'title'     => esc_html__('STICKY STYLE', 'lapindos'), 
                    'description'      => esc_html__('Button style for sticky element.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Other Color', 'lapindos'),
                    'off' => esc_html__('Normal', 'lapindos'),
                    'default'   => 0
                ),
                array(
                    'id'       => 'quote_menu_sticky_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Label Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button label.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_menu_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'quote_menu_sticky_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_menu_skin', '=', 1 ),


                ),
                array(
                    'id'       => 'quote_menu_sticky_border_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Button Border Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom button border color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_menu_skin', '=', 1 ),

                ),

            )
        )
    );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'social-link-section',
        'subsection' => true,
        'title'    => esc_html__( 'Social Link','lapindos'),
        'fields'           => array(
                array(
                    'id'=>'social_link_target',
                    'type' => 'button_set',
                    'title' => esc_html__('Link Target','lapindos'),
                    'options'=>array(
                          ''=>esc_html__("None", 'lapindos'),
                          'self'=>esc_html__("Same frame", 'lapindos'),
                          'blank'=>esc_html__("New window", 'lapindos'),
                          'parent'=> esc_html__("Parent frameset", 'lapindos'),
                          'top'=> esc_html__("Full body of the window", 'lapindos'),
                        ),
                    'default'=> '',
                    'multi_layout'=>'inline',
                ),
                array(
                    'id'        => 'social_show_label',
                    'title'     => esc_html__('Show Label', 'lapindos'), 
                    'subtitle'      => esc_html__('Show or hidden social label.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos'),
                    'default'   => 0
                ),
                array(
                    'id'=>'social-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),

                array(
                    'id'       => 'social_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for social icon.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'       => 'social_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Background Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for background.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    )
                ),
                array(
                    'id'        => 'sticky_social_skin',
                    'title'     => esc_html__('STICKY STYLE', 'lapindos'), 
                    'description'      => esc_html__('Button style for sticky element.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Other Color', 'lapindos'),
                    'off' => esc_html__('Normal', 'lapindos'),
                    'default'   => 0
                ),

                array(
                    'id'       => 'social_sticky_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for social icon.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_social_skin', '=', 1 ),
                ),
                array(
                    'id'       => 'social_sticky_bg_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Background Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for background.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_social_skin', '=', 1 ),
                )
            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'mainmenu-section',
        'title'    => esc_html__( 'Main Menu', 'lapindos' ),
        'desc' => esc_html__( 'Main menu settings.', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(
                array(
                    'id'       => 'menu-bar-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Navbar', 'lapindos' ),
                    'subtitle' => esc_html__( 'Navigation bat styles.', 'lapindos' ),
                    'indent'   => false, 
                ),
                array(
                    'id'       => 'menubar-border',
                    'type'     => 'border',
                    'title'    => esc_html__( 'Border', 'lapindos' ),
                    'desc'     => esc_html__( 'Border the navbar.', 'lapindos' ),
                    'all'      => false,  
                    'top'      => true,
                    'bottom'   => true,
                    'style'    => true,
                    'color'    => true,
                    'left'     => true,
                    'right'    => true,
                ),
                array(
                    'id'       => 'dropdown-background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Dropdown Background Color', 'lapindos' ),
                    'desc' => esc_html__( 'Pick a color for dropdown background', 'lapindos' ),
                    'default'  => array(
                        'color' => '#5aace2',
                        'alpha' => '1',
                    ),
                ),

                array(
                    'id'       => 'menu-style-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Menu Item', 'lapindos' ),
                    'subtitle' => esc_html__( 'Menu styles.', 'lapindos' ),
                    'indent'   => false, 
                ),
                array(
                    'id'       => 'menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for menu color.', 'lapindos' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '#222222',
                        'hover'   => '#2e96db',
                        'active'   => '#2e96db',
                    )
                ),
                array(
                    'id'       => 'sticky-menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Sticky Color', 'lapindos' ),
                    'subtitle'    => esc_html__( '( Sticky Bar )', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for menu color on sticky bar.', 'lapindos' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                        'active'   => '',
                    )
                ),
                array(
                    'id'       => 'menu-border',
                    'type'     => 'border',
                    'title'    => esc_html__( 'Border', 'lapindos' ),
                    'desc'     => esc_html__( 'Border each menu.', 'lapindos' ),
                    'all'      => false,  
                    'top'      => true,
                    'bottom'   => true,
                    'style'    => true,
                    'color'    => true,
                    'left'     => true,
                    'right'    => true,
                ),
                array(
                    'id'       => 'hover-menu-border',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Hover Menu Border Color', 'lapindos' ),
                    'desc' => esc_html__( 'Border color when menu hover.', 'lapindos' ),
                    'default'  => array(
                        'color' => '',
                        'alpha' => '0',
                    ),
                ),
                array(
                    'id'       => 'sub-menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Dropdown Menu Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for dropdown menu color.', 'lapindos' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '#ffffff',
                        'hover'   => '#fde428',
                        'active'   => '#fde428',
                    )
                ),
                array(
                    'id'       => 'mobile-menu-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Mobile Menu Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for mobile menu color.', 'lapindos' ),
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                        'active'   => '',
                    )
                ),
                array(
                    'id'       => 'mobile-menu-bg',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Mobile Menu Background', 'lapindos' ),
                    'desc' => esc_html__( 'Background color for mobile menu.', 'lapindos' ),
                    'default'  => array(
                        'color' => '#f7f7f7',
                        'alpha' => '0',
                    ),
                ),

            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'menu-module1-section',
        'subsection' => true,
        'title'    => esc_html__('Short Menu', 'lapindos'),
        'fields'           => array(
                array(
                    'id'=>'top-bar-menu-1',
                    'type' => 'select',
                    'title' => esc_html__('Source Menu', 'lapindos'), 
                    'data' =>'menu',
                    'subtitle'=>esc_html__('Select menu source','lapindos'),
                    ),
                array(
                    'id'=>'menu1-responsiveness',
                    'type' => 'button_set',
                    'title' => esc_html__('Responsivity', 'lapindos'), 
                    'subtitle'=> '',
                    'options'=>array(
                        ''=>esc_html__('Show Forever', 'lapindos'),
                        'xs'=>esc_html__('Hidden since 768px', 'lapindos'),
                        'mobile'=>esc_html__('Hidden since 480px', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>''
                ),

                array(
                    'id'       => 'short_menu_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Menu Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                ),
                array(
                    'id'        => 'sticky_short_menu_skin',
                    'title'     => esc_html__('STICKY STYLE', 'lapindos'), 
                    'description'      => esc_html__('Menu style for sticky element.','lapindos'),
                    'type'      => 'switch',
                    'on' => esc_html__('Other Color', 'lapindos'),
                    'off' => esc_html__('Normal', 'lapindos'),
                    'default'   => 0
                ),
                array(
                    'id'       => 'short_menu_sticky_color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Menu Color', 'lapindos' ),
                    'desc'     => esc_html__( 'Pick a color for custom color.', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                    'required' => array( 'sticky_short_menu_skin', '=', 1 ),
                ),

            )
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'slidingbar-section-start',
        'title'    => esc_html__( 'Sliding Bar', 'lapindos' ),
        'desc' => esc_html__( 'Sliding navigation bar.', 'lapindos' ),
        'icon'  => 'el el-arrow-right',
        'fields' => array(
                array(
                    'id'=>'slidingbar',
                    'type' => 'switch',
                    'title' => esc_html__('Show Sliding Bar', 'lapindos'), 
                    'subtitle'=>esc_html__('Hide or show slidingbar.','lapindos'),
                    "default"=> 1,
                    'on' => esc_html__('Show', 'lapindos'),
                    'off' => esc_html__('Hidden', 'lapindos')
                ),
                array(
                    'id'=>'slidingbar-type',
                    'type' => 'button_set', 
                    'title' => esc_html__('Content Source', 'lapindos'),
                    'subtitle'=> esc_html__('Selec the slidingbar content source.', 'lapindos'),
                    "default"=> 'option',
                    'options'=>array(
                        'slidingbar-widget' => esc_html__('Slidingbar Widget', 'lapindos'),
                        'sidebar-widget' => esc_html__('Sidebar Widget', 'lapindos'),
                        'page' => esc_html__('Page', 'lapindos'),
                    )
                ),  
                array(
                    'id'       => 'slidingbar-page',
                    'type'     => 'select',
                    'data'     => 'pages',
                    'title'    => esc_html__( 'Page Source', 'lapindos' ),
                    'subtitle' => esc_html__( 'Content will displayed as slidingbar content', 'lapindos' ),
                    'desc'     => esc_html__( 'Create a page first.', 'lapindos' ),
                    'required' => array( 'slidingbar-type', '=', array( 'page') )
                ),
                array(
                    'id'=>'slidingbar-position',
                    'type' => 'button_set', 
                    'title' => esc_html__('Sliding Bar Placement', 'lapindos'),
                    'subtitle'=> esc_html__('The position of slidingbar.', 'lapindos'),
                    "default"=> 'right',
                    'multi_layout'=>'inline',
                    'options'  => array(
                        'left'     => esc_html__('Left', 'lapindos'),
                        'right' => esc_html__('Right', 'lapindos'),
                        'top' => esc_html__('Top', 'lapindos'),
                        'bottom' => esc_html__('Bottom', 'lapindos'),
                        ),
                ),  
                array(
                    'id'=>'slidingbar_bg',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Background Color', 'lapindos'), 
                    'subtitle' => esc_html__('Select color for background slidingbar.', 'lapindos'),
                    'default' => '#ffffff',
                    'validate' => 'color'
                ),  
                array(
                  'title'    => esc_html__( 'Overlay Darkness', 'lapindos' ),
                  'subtitle'     => esc_html__( 'Offset content transparency. 0 for no transparency and 20 for maximum ( dark )', 'lapindos' ),
                  'id'       => 'sliding_overlay',
                  'default'  => '',
                  'type'     => 'text',
                ),
                array(
                    'id'       => 'sliding-toggle-section',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Toggle Menu', 'lapindos' ),
                    'subtitle' => esc_html__( 'Toggle menu styles.', 'lapindos' ),
                    'indent'   => false, 
                ),
                array(
                    'id'         => 'toggle-icon',
                    'type'       => 'image_select',
                    'presets'    => false,
                    'title'      => esc_html__( 'Select Type', 'lapindos' ),
                    'subtitle'   => esc_html__( 'Select toggle view.', 'lapindos' ),
                    'default'    => 'fa-sign-in',
                    'options'    => array(
                        'fa-sign-in' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_in.png',
                        ),
                        'fa-sign-out' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_sign_out.png',
                        ),
                        'fa-ellipsis-v' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_v.png',
                        ),
                        'fa-ellipsis-h' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_ellipsis_h.png',
                        ),
                        'fa-navicon' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_navicon.png',
                        ),
                        'fa-th-large' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_th_large.png',
                        ),
                        'fa-power-off' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_power_off.png',
                        ),
                        'fa-gear' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_gear.png',
                        ),
                        'fa-shopping-cart' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_shopping_cart.png',
                        ),
                        'fa-user-o' => array(
                            'img'     => get_template_directory_uri().'/lib/images/fa_user_o.png',
                        ),

                    ),
                ),
                array(
                    'id'       => 'toggle-slide-color',
                    'type'     => 'link_color',
                    'title'    => esc_html__( 'Color', 'lapindos' ),
                    'active'    => false, 
                    'visited'   => false,  
                    'default'  => array(
                        'regular' => '',
                        'hover'   => '',
                    ),
                ),
                array(
                  'title'    => esc_html__( 'Font Size', 'lapindos' ),
                  'subtitle'     => esc_html__( 'Font size the toggle', 'lapindos' ),
                  'id'       => 'sliding_size',
                  'default'  => '',
                  'type'     => 'text',
                ),

            )
        )
    );


    // style section

    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Blog', 'lapindos' ),
        'id'               => 'blog',
        'customizer_width' => '400px',
        'icon'             => 'el el-pencil',
        'fields'           =>array(
        )
    ) );


    // -> START Blog
    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'blog-layout-start',
        'subsection' => true,
        'title'    => esc_html__( 'Layout', 'lapindos' ),
        'desc' => esc_html__( 'Blog column  settings.', 'lapindos' ),
        'fields'           =>array(
            array(
                'id'=>'grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Blog Layout','lapindos'),
                'subtitle'=>esc_html__('The number of grid columns for default blog','lapindos'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'lapindos'),
                      2=>esc_html__("2 Columns", 'lapindos'),
                      3=> esc_html__("3 Columns", 'lapindos'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'=>'author_grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Author Blog Layout','lapindos'),
                'subtitle'=>esc_html__('The number of grid columns for author blog','lapindos'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'lapindos'),
                      2=>esc_html__("2 Columns", 'lapindos'),
                      3=> esc_html__("3 Columns", 'lapindos'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'=>'category_grid_column',
                'type' => 'button_set',
                'title' => esc_html__('Category Blog Layout','lapindos'),
                'subtitle'=>esc_html__('The number of grid columns for category & archive blog','lapindos'), 
                'options'=>array(
                      1=>esc_html__("1 Columns", 'lapindos'),
                      2=>esc_html__("2 Columns", 'lapindos'),
                      3=> esc_html__("3 Columns", 'lapindos'),
                    ),
                'default'=> 1,
                'multi_layout'=>'inline',
            ),
            array(
                'id'=>'post_menu_id',
                'type' => 'select',
                'title' => esc_html__('Main Menu ( Optional )', 'lapindos'), 
                'data' =>'menu',
                'subtitle'=>esc_html__('Select main menu source ( optional ).','lapindos'),
                'description'=>esc_html__('Leave blank if same as default.','lapindos'),
            ),
            array(
                'id'       => 'post-style-section',
                'type'     => 'section',
                'title'    => esc_html__( 'Single Post', 'lapindos' ),
                'indent'   => false, 
            ),
            array(
                'id'=>'post_title_position',
                'type' => 'button_set', 
                'title' => esc_html__('Title Placement', 'lapindos'),
                'subtitle'=> esc_html__('Single post title placement.', 'lapindos'),
                "default"=> 'content',
                'options'=>array(
                      'header'=>esc_html__("Header", 'lapindos'),
                      'content'=>esc_html__("Content", 'lapindos'),
                      'hidden'=> esc_html__("Hidden", 'lapindos'),
                    ),
                'multi_layout'=>'inline',
            ),  
            array(
                'id'=>'blog_featured_image',
                'type' => 'switch',
                'title' => esc_html__('Featured Image as Heading', 'lapindos'), 
                'subtitle'=>esc_html__('Using featured image as header image.','lapindos'),
                "default"=> 0,
                'on' => esc_html__('Yes', 'lapindos'),
                'off' => esc_html__('No', 'lapindos')
            ),

             array(
                'id'       => 'blog-layout',
                'type'     => 'sorter',
                'title'    => esc_html__( 'Layout','lapindos'),
                'subtitle' => esc_html__( 'Drag up/down for reoder the element.','lapindos'),
                'options'  => array(
                    'active'   => array(
                        'title'=> esc_html__('Used Elements','lapindos'),
                        'desc' => esc_html__( 'Element will show in detail post.', 'lapindos' ),
                        'vertical'=> true,
                        'fields'=>array(
                            'image' => esc_html__('Featured Image','lapindos'),
                            'title' => esc_html__('Post Title','lapindos'),
                            'meta' => esc_html__('Post Meta','lapindos'),
                            'content' => esc_html__('Post Content','lapindos'),
                            'author' => esc_html__('Post Author','lapindos'),
                        )
                    ),
                    'Disabled'   => array(
                        'title'=> esc_html__('Available Elements','lapindos'),
                        'desc' => esc_html__( 'Element below not show in detail post.', 'lapindos' ),
                        'vertical'=> true,
                        'fields'=>array(
                            'tags' => esc_html__('Post Tag','lapindos'),
                        )
                    )

                )
            )
    )));

    $sidebar_args= array(
        array(
            'id'            => 'post_grid',
            'type'          => 'select',
            'title'         => esc_html__( 'Sidebar Width', 'lapindos' ),
            'description'   => esc_html__( '1 grid it\'s mean 8.33% of page width.', 'lapindos' ),
            'default'       => 3,
            'options'=>array(
                  2=>esc_html__("2 grids ( 16.66%)", 'lapindos'),
                  3=>esc_html__("3 grids ( 25.00%)", 'lapindos'),
                  4=> esc_html__("4 grids ( 33.33%)", 'lapindos'),
                  5=> esc_html__("5 grids ( 41.66%)", 'lapindos'),
                  6=> esc_html__("6 grids ( 50.00%)", 'lapindos'),
                ),
        ),
        array(
            'id'=>'sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Sidebar Position', 'lapindos'), 
            'subtitle'=>esc_html__('Select sidebar position as default','lapindos'),
            'options'=>array(
                'left'=>esc_html__('Left', 'lapindos'),
                'right'=>esc_html__('Right', 'lapindos'),
                'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'post_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Post Sidebar Position', 'lapindos'), 
            'subtitle'=>esc_html__('Select sidebar position for single post','lapindos'),
            'options'=>array(
                'left'=>esc_html__('Left', 'lapindos'),
                'right'=>esc_html__('Right', 'lapindos'),
                'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'author_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Author Sidebar Position', 'lapindos'), 
            'subtitle'=>esc_html__('Select sidebar position for author blog','lapindos'),
            'options'=>array(
                'left'=>esc_html__('Left', 'lapindos'),
                'right'=>esc_html__('Right', 'lapindos'),
                'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        ),
        array(
            'id'=>'category_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Category Sidebar Position', 'lapindos'), 
            'subtitle'=>esc_html__('Select sidebar position for post category','lapindos'),
            'options'=>array(
                'left'=>esc_html__('Left', 'lapindos'),
                'right'=>esc_html__('Right', 'lapindos'),
                'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                ),
            'multi_layout'=>'inline',
            'default'=>'left'
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'sidebar-section-start',
        'title'    => esc_html__( 'Sidebar', 'lapindos' ),
        'desc' => esc_html__( 'Sidebar Settings.', 'lapindos' ),
        'subsection' => true,
        'fields'           => $sidebar_args
    ) );

     ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Search Page', 'lapindos' ),
        'icon'  => 'el el-search',
        'customizer_width' => '400px',
        'id'    =>'search_page',
        'fields'=>array(
                array(
                'id'=>'search_sidebar_position',
                'type' => 'button_set',
                'title' => esc_html__('Sidebar Position', 'lapindos'), 
                'subtitle'=>esc_html__('Select sidebar position for search page','lapindos'),
                'options'=>array(
                    'left'=>esc_html__('Left', 'lapindos'),
                    'right'=>esc_html__('Right', 'lapindos'),
                    'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'left'
                ),
                array(
                    'id'=>'search_form_position',
                    'type' => 'button_set', 
                    'title' => esc_html__('Search Form Placement', 'lapindos'),
                    'subtitle'=> esc_html__('Search form placement.', 'lapindos'),
                    "default"=> 'content',
                    'options'=>array(
                          'header'=>esc_html__("Header", 'lapindos'),
                          'content'=>esc_html__("Content", 'lapindos'),
                          'hidden'=> esc_html__("Hidden", 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                ),  
                array(
                    'id'=>'search_heading_image',
                    'type' => 'media', 
                    'title' => esc_html__('Heading Image', 'lapindos'),
                    'subtitle'=>esc_html__('Select image using for heading background.','lapindos'),
                    'compiler' => true,
                    'description' => esc_html__('Recomended 1500px wide.','lapindos'),
                    'default'=>array('url'=>''),
                ),
                array(
                    'id'=>'search_heading_title',
                    'type' => 'text',
                    'title' => esc_html__('Page Title','lapindos'),
                    'subtitle'=>esc_html__('Page title on search page result.','lapindos'),
                    'description'=>esc_html__('Leave blank for no title.','lapindos'),  
                    'default'=> '',
                ),
                array(
                    'id'       => 'search_hide_post_types',
                    'type'     => 'checkbox',
                    'title'    => esc_html__( 'Hidden From Search', 'lapindos' ),
                    'subtitle' => esc_html__( 'The selected post type will hidden from search result.', 'lapindos' ),
                    'desc'     => esc_html__( 'Checked for select', 'lapindos' ),
                    'data'     => 'post_type',
                    'args'    => array(
                        'exclude_from_search'=> false,
                    )
                ),
                array(
                    'id'=>'search-empty-text',
                    'type' => 'editor',
                    'title' => esc_html__('Custom Result Not Found Text', 'lapindos'), 
                    'subtitle' => esc_html__('Type in the text that will be show on empty search result if no Result Not Found Page selected.','lapindos'),
                    'default' => '',
                    'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                ),

            )
    ));


   if (function_exists('is_shop')){
         ThemegumRedux::setSection( $opt_name, array(
            'title' => esc_html__( 'Shop', 'lapindos' ),
            'icon'  => 'el el-shopping-cart',
            'customizer_width' => '400px',
            'id'    =>'woocommerce',
            'fields'=>array(

                    array(
                    'id'=>'shop_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Sidebar Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select sidebar position for shop page','lapindos'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'product_cat_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Category Sidebar Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select sidebar position for single shop category','lapindos'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'product_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Product Sidebar Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select sidebar position for single product','lapindos'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                        'id'=>'shop_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Shop Products Show at Most','lapindos'),
                        'subtitle'=>esc_html__('Number of product on shop page.','lapindos'), 
                        'default'=> get_option('posts_per_page'),
                    ),
                    array(
                        'id'=>'shop_column',
                        'type' => 'select',
                        'title' => esc_html__('Shop Columns','lapindos'),
                        'subtitle'=>esc_html__('Number of columns on shop and shop category page.','lapindos'), 
                        'options'=>array(
                              2=>esc_html__("2 Columns", 'lapindos'),
                              3=> esc_html__("3 Columns", 'lapindos'),
                              4=> esc_html__("4 Columns", 'lapindos'),
                              5=> esc_html__("5 Columns", 'lapindos')
                            ),
                        'default'=> 3,
                    ),
                    array(
                      'title'    => esc_html__( 'Num Related/Upsell Product Show', 'lapindos' ),
                      'subtitle'     => esc_html__( 'This controls num related/Cross-sell product show', 'lapindos' ),
                      'id'       => 'loop_related_per_page',
                      'default'  => 3,
                      'type'     => 'slider',
                      'min'           => 1,
                      'step'          => 1,
                      'max'           => 12,
                    ),
                    array(
                    'title'    => esc_html__( 'Related/Upsell Product Display Columns', 'lapindos' ),
                    'subtitle'     => esc_html__( 'This controls num column related/upsell product display', 'lapindos' ),
                    'id'       => 'loop_related_columns',
                    'default'  => 3,
                    'type'     => 'select',
                    'options'  => array(
                              1=>esc_html__("1 Column", 'lapindos'),
                              2=>esc_html__("2 Columns", 'lapindos'),
                              3=> esc_html__("3 Columns", 'lapindos'),
                              4=> esc_html__("4 Columns", 'lapindos'),
                              5=> esc_html__("5 Columns", 'lapindos')
                    ),
                  ),
                    array(
                        'title'    => esc_html__( 'Cross Sell Display Product', 'lapindos' ),
                        'subtitle'     => esc_html__( 'This controls num cross sell product display', 'lapindos' ),
                        'id'       => 'loop_cross_sells_total',
                        'default'  => 3,
                        'type'     => 'slider',
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 12,
                  ),
                    array(
                        'title'    => esc_html__( 'Cross Sell Display Columns', 'lapindos' ),
                        'subtitle'     => esc_html__( 'This controls num column cross sell display', 'lapindos' ),
                        'id'       => 'loop_cross_sells_columns',
                        'default'  => 3,
                        'type'     => 'select',
                        'options'  => array(
                              1=>esc_html__("1 Column", 'lapindos'),
                              2=>esc_html__("2 Columns", 'lapindos'),
                              3=> esc_html__("3 Columns", 'lapindos'),
                              4=> esc_html__("4 Columns", 'lapindos'),
                              5=> esc_html__("5 Columns", 'lapindos')
                        ),
                  ),
                    array(
                        'id'=>'product_menu_id',
                        'type' => 'select',
                        'title' => esc_html__('Main Menu ( Optional )', 'lapindos'), 
                        'data' =>'menu',
                        'subtitle'=>esc_html__('Select main menu source ( optional ).','lapindos'),
                        'description'=>esc_html__('Leave blank if same as default.','lapindos'),
                    ),
                    array(
                        'id'=>'product_title_position',
                        'type' => 'button_set', 
                        'title' => esc_html__('Title Placement', 'lapindos'),
                        'subtitle'=> esc_html__('Single product title placement.', 'lapindos'),
                        "default"=> 'content',
                        'options'=>array(
                              'header'=>esc_html__("Header", 'lapindos'),
                              'content'=>esc_html__("Content", 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                    ),  
                    array(
                        'id'=>'shop_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Product Heading Image ( optional )', 'lapindos'),
                        'subtitle'=>esc_html__('Select image using for heading background.','lapindos'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','lapindos'),
                        'default'=>array('url'=>''),
                    )


                )
        ));
    }

    if (class_exists('TG_Custom_Post')){
         ThemegumRedux::setSection( $opt_name, array(
            'title' => esc_html__( 'Portfolio', 'lapindos' ),
            'icon'  => 'el el-book',
            'customizer_width' => '400px',
            'id'    =>'portfolio',
            'fields'=>array(
                    array(
                        'id'=>'portfolio_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Heading Image ( optional )', 'lapindos'),
                        'subtitle'=>esc_html__('Select image using for heading background.','lapindos'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','lapindos'),
                        'default'=>array('url'=>''),
                    ),
                    array(
                        'id'=>'tg_custom_post_menu_id',
                        'type' => 'select',
                        'title' => esc_html__('Main Menu ( Optional )', 'lapindos'), 
                        'data' =>'menu',
                        'subtitle'=>esc_html__('Select main menu source ( optional ).','lapindos'),
                        'description'=>esc_html__('Leave blank if same as default.','lapindos'),
                    ),
                    array(
                        'id'=>'tg_custom_post_sidebar_position',
                        'type' => 'button_set',
                        'title' => esc_html__('Sidebar Position', 'lapindos'), 
                        'subtitle'=>esc_html__('Select sidebar position for portfolio widget','lapindos'),
                        'description'=>esc_html__('Portfolio detail have same place with widget. Since page no sidebar, portfolio detail placed below main content.','lapindos'),
                        'options'=>array(
                            'left'=>esc_html__('Left', 'lapindos'),
                            'right'=>esc_html__('Right', 'lapindos'),
                            'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'left'
                    ),
                    array(
                        'id'=>'portfolio_fields',
                        'type' => 'icon_multi_text',
                        'title' => esc_html__('Portfolio Fields', 'lapindos'),
                        'subtitle'=> wp_kses( __('Manage the portfolio field. Must have field with name <strong>"url"</strong> for site project or <strong>"download"</strong> for download button link.','lapindos'), array('strong'=>array())),
                        'sortable' => true,
                        'fields'=> array(
                            'name' => esc_html__('Name', 'lapindos'),
                            'label' => esc_html__('Label', 'lapindos'),
                            ),
                        'default' => array('url'=>array('name'=>'url','label'=>esc_html__('Link Project','lapindos')))
                    ),
                    array(
                        'id'=>'hide_detail',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Detail', 'lapindos'), 
                        'subtitle'=>esc_html__('Hide project detail field.','lapindos'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'lapindos'),
                            '1'=>esc_html__('Yes', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'hide_date',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Date', 'lapindos'), 
                        'subtitle'=>esc_html__('Hide date field.','lapindos'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'lapindos'),
                            '1'=>esc_html__('Yes', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'hide_category',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Category', 'lapindos'), 
                        'subtitle'=>esc_html__('Hide category field.','lapindos'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'lapindos'),
                            '1'=>esc_html__('Yes', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),

                    array(
                        'id'=>'hide_empty',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Empty Field', 'lapindos'), 
                        'subtitle'=>esc_html__('Hide the field if no value.','lapindos'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'lapindos'),
                            '1'=>esc_html__('Yes', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),
                    array(
                        'id'=>'tg_custom_post_title_position',
                        'type' => 'button_set', 
                        'title' => esc_html__('Title Placement', 'lapindos'),
                        'subtitle'=> esc_html__('Single portfolio title placement.', 'lapindos'),
                        "default"=> 'content',
                        'options'=>array(
                              'header'=>esc_html__("Header", 'lapindos'),
                              'content'=>esc_html__("Content", 'lapindos'),
                              'hidden'=> esc_html__("Hidden", 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                    ),  

                )
        ));

    }

    if (class_exists('petro_service')){

         ThemegumRedux::setSection( $opt_name, array(
            'title' => ucfirst(esc_html__('service','lapindos') ),
            'icon'  => 'el el-slideshare',
            'customizer_width' => '400px',
            'id'    =>'superclean_service',
            'fields'=>array(
                    array(
                    'id'=>'petro_service_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Sidebar Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select sidebar position for widget','lapindos'),
                    'description'=>esc_html__('Service detail have same place with widget. Since page no sidebar, service detail placed below main content.','lapindos'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                    'id'=>'service_cat_sidebar_position',
                    'type' => 'button_set',
                    'title' => esc_html__('Category Sidebar Position', 'lapindos'), 
                    'subtitle'=>esc_html__('Select sidebar position for widget','lapindos'),
                    'options'=>array(
                        'left'=>esc_html__('Left', 'lapindos'),
                        'right'=>esc_html__('Right', 'lapindos'),
                        'nosidebar'=>esc_html__('No Sidebar', 'lapindos'),
                        ),
                    'multi_layout'=>'inline',
                    'default'=>'left'
                    ),
                    array(
                        'id'=>'service_cat_grid_column',
                        'type' => 'button_set',
                        'title' => esc_html__('Category Layout','lapindos'),
                        'subtitle'=>esc_html__('The number of grid columns for category & archive','lapindos'), 
                        'options'=>array(
                              1=>esc_html__("1 Columns", 'lapindos'),
                              2=>esc_html__("2 Columns", 'lapindos'),
                              3=> esc_html__("3 Columns", 'lapindos'),
                            ),
                        'default'=> 1,
                        'multi_layout'=>'inline',
                    ),
                    array(
                        'id'=>'petro_service_menu_id',
                        'type' => 'select',
                        'title' => esc_html__('Main Menu ( Optional )', 'lapindos'), 
                        'data' =>'menu',
                        'subtitle'=>esc_html__('Select main menu source ( optional ).','lapindos'),
                        'description'=>esc_html__('Leave blank if same as default.','lapindos'),
                    ),
                    array(
                        'id'=>'petro_service_title_position',
                        'type' => 'button_set', 
                        'title' => esc_html__('Title Placement', 'lapindos'),
                        'subtitle'=> esc_html__('Single service title placement.', 'lapindos'),
                        "default"=> 'content',
                        'options'=>array(
                              'header'=>esc_html__("Header", 'lapindos'),
                              'content'=>esc_html__("Content", 'lapindos'),
                              'hidden'=> esc_html__("Hidden", 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                    ),  
                    array(
                        'id'=>'petro_service_featured_image',
                        'type' => 'switch',
                        'title' => esc_html__('Featured Image as Heading', 'lapindos'), 
                        'subtitle'=>esc_html__('Using featured image as header image.','lapindos'),
                        "default"=> 0,
                        'on' => esc_html__('Yes', 'lapindos'),
                        'off' => esc_html__('No', 'lapindos')
                    ),
                    array(
                        'id'=>'petro_service_heading_image',
                        'type' => 'media', 
                        'title' => esc_html__('Heading Image ( optional )', 'lapindos'),
                        'subtitle'=>esc_html__('Select image using for heading background.','lapindos'),
                        'compiler' => true,
                        'description' => esc_html__('Recomended 1500px wide.','lapindos'),
                        'default'=>array('url'=>''),
                    ),
                    array(
                        'id'=>'petro_service_hide_featured_image',
                        'type' => 'button_set',
                        'title' => esc_html__('Hide Featured Image', 'lapindos'), 
                        'subtitle'=>esc_html__('Hide featured image in service detail.','lapindos'),
                        'options'=>array(
                            '0'=>esc_html__('No', 'lapindos'),
                            '1'=>esc_html__('Yes', 'lapindos'),
                            ),
                        'multi_layout'=>'inline',
                        'default'=>'0'
                    ),

                )
        ));


    }


    ThemegumRedux::setSection( $opt_name, array(
        'title'      => esc_html__( 'Slides', 'lapindos' ),
        'id'         => 'slides-show',
        'desc'       => esc_html__( 'Slides show.', 'lapindos' ),
        'fields'     => array(
            array(
                'id'          => 'nuno-slides',
                'type'        => 'petro_slides',
//                'show' => array('btn'),
                'title'       => esc_html__( 'Slides Options', 'lapindos' ),
                'subtitle'    => esc_html__( 'Unlimited slides with drag and drop sortings.', 'lapindos' ),
                'placeholder' => array(
                    'title'       => esc_html__( 'Title text', 'lapindos' ),
                    'description' => esc_html__( 'Description text', 'lapindos' ),
                    'url'         => esc_html__( '1st button link!', 'lapindos' ),
                    'url2'         => esc_html__( '2nd button link!', 'lapindos' ),
                ),
            ),
        )
    ) );


    ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Footer', 'lapindos' ),
        'icon'  => 'el el-photo',
        'customizer_width' => '400px',
        'id'    =>'footer'
    ));

    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'prefooter-section-start',
        'title'    => esc_html__( 'Footer Option', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(
            array(
                'id'=>'footer-type',
                'type' => 'button_set', 
                'title' => esc_html__('Footer Source', 'lapindos'),
                'subtitle'=> esc_html__('Selec the footer content source.', 'lapindos'),
                "default"=> 'option',
                'options'=>array(
                    'page' => esc_html__('Page', 'lapindos'),
                    'option' => esc_html__('Options', 'lapindos')
                )
            ),  
            array(
                'id'       => 'footer-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Footer Page (default)', 'lapindos' ),
                'subtitle' => esc_html__( 'Content will displayed as footer section', 'lapindos' ),
                'desc'     => esc_html__( 'Create a page first.', 'lapindos' ),
                'required' => array( 'footer-type', '=', array( 'page') )
            ),
            array(
                'id'       => 'footer-pages',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Footer Template', 'lapindos' ),
                'subtitle' => esc_html__( 'Footer option will show in each page. You can assigned different footer each page.', 'lapindos' ),
                'desc'     => esc_html__( 'Create a page first.', 'lapindos' ),
                'required' => array( 'footer-type', '=', array( 'page') )
            ),
            array(
                'id'       => 'pre-footer-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Pre Footer Page (default)', 'lapindos' ),
                'subtitle' => esc_html__( 'Content will displayed before footer section', 'lapindos' ),
                'desc'     => esc_html__( 'If no page selected, system will display Pre-Footer Text.', 'lapindos' ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'pre-footer-pages',
                'type'     => 'select',
                'data'     => 'pages',
                'multi'    => true,
                'sortable' => true,
                'title'    => esc_html__( 'Pre Footer Template', 'lapindos' ),
                'subtitle' => esc_html__( 'Option will show in each page. You can assigned different pre footer each page.', 'lapindos' ),
                'desc'     => esc_html__( 'Create a page first.', 'lapindos' ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'pre-footer-text',
                'type' => 'editor',
                'title' => esc_html__('Pre-Footer Text', 'lapindos'), 
                'subtitle' => esc_html__('Type in the text that will be show on side of bottom widget area. You also can using shortcode ex: [tags] for display tag widget.','lapindos'),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'prefooter-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Pre-Footer Area Background Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a background color for the pre-footer area', 'lapindos' ),
                'default'  => array('color'=>'#2e96db','alpha'=>1),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'prefooter-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Pre-Footer Area Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a color for the pre-footer area', 'lapindos' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            )

        )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'widget-section-start',
        'title'    => esc_html__( 'Widget Section', 'lapindos' ),
        'desc' => esc_html__( 'The content will show on bottom of footer area. This option only for footer source "option"', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(
            array(
                'id'=>'showwidgetarea',
                'type' => 'switch', 
                'title' => esc_html__('Widget Area', 'lapindos'),
                'subtitle'=> esc_html__('Enable or Disable footer', 'lapindos'),
                "default"=> 1,
                'on' => esc_html__('On', 'lapindos'),
                'off' => esc_html__('Off', 'lapindos'),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),  
            array(
                'id'=>'footer-widget-layout-mode',
                'type' => 'button_set',
                'title' => esc_html__('Layout Mode', 'lapindos'), 
                'subtitle'=> '',
                'options'=>array(
                    ''=>esc_html__('Default', 'lapindos'),
                    'wide'=>esc_html__('Wide', 'lapindos'),
                    'boxed'=>esc_html__('Boxed', 'lapindos'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'',
                'required' => array( 'showwidgetarea', '=', array( '1') ),
            ),
            array(
                'id'=>'footer-widget-column',
                'type' => 'button_set',
                'title' => esc_html__('Footer Widget Columns', 'lapindos'), 
                'subtitle'=> wp_kses_post( __('Select number of column for the footer widget <br>You can set the footer widget on Appearance > Widgets > Bottom Widget Area','lapindos')),
                'options'=>array(1=>esc_html__('One Column', 'lapindos'),
                    2=>esc_html__('Two Columns', 'lapindos'),
                    3=>esc_html__('Three Columns', 'lapindos'),
                    4=>esc_html__('Four Columns', 'lapindos')
                    ),
                'multi_layout'=>'inline',
                'required' => array( 'showwidgetarea', '=', array( '1') ),
                'default'=>3
            ),
            array(
                'id'            => 'footer-text-grid',
                'type'          => 'slider',
                'title'         => esc_html__( 'Footer Text Width', 'lapindos' ),
                'description'      => esc_html__( '12 grids it\'s mean 100% of page width.', 'lapindos' ),
                'default'       => 3,
                'min'           => 1,
                'step'          => 1,
                'max'           => 12,
                'display_value' => 'text',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'footer-text-position',
                'type' => 'button_set', 
                'title' => esc_html__('Footer Text Position', 'lapindos'),
                'subtitle'=> esc_html__('The position of text, on left widget area or right widget area.', 'lapindos'),
                "default"=> 'left',
                'multi_layout'=>'inline',
                'options'  => array(
                    'left'     => esc_html__('Left', 'lapindos'),
                    'right' => esc_html__('Right', 'lapindos'),
                    ),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),  
            array(
                'id'=>'footer-text',
                'type' => 'editor',
                'title' => esc_html__('Footer Text', 'lapindos'), 
                'subtitle' => wp_kses( __('Type in the text that will be show on side of bottom widget area. You also can using shortcode ex: [tags][socials] for display tag widget.','lapindos'),array('a'=>array('href'=>array(),'target'=>array()))),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'bottom-widget-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Bottom Widget Background Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a background color for the bottom widget area', 'lapindos' ),
                'required' => array( 'footer-type', '=', array( 'option') ),
                'default'  => array('color'=>'#2e96db','alpha'=>1),
            ),
            array(
                'id'       => 'bottom-widget-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Bottom Widget Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a color for the bottom widget area', 'lapindos' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            )

    )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'copyright-section-start',
        'title'    => esc_html__( 'Copyright Section', 'lapindos' ),
        'desc' => esc_html__( 'The content will show on bottom of footer area. This option only for footer source "option"', 'lapindos' ),
        'subsection' => true,
        'fields'           => array(            
            array(
                'id'=>'footer-copyright-layout-mode',
                'type' => 'button_set',
                'title' => esc_html__('Layout Mode', 'lapindos'), 
                'subtitle'=> '',
                'options'=>array(
                    ''=>esc_html__('Default', 'lapindos'),
                    'wide'=>esc_html__('Wide', 'lapindos'),
                    'boxed'=>esc_html__('Boxed', 'lapindos'),
                    ),
                'multi_layout'=>'inline',
                'default'=>'',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'footer-copyright-text',
                'type' => 'editor',
                'title' => esc_html__('Left Content', 'lapindos'), 
                'subtitle' => esc_html__('Type in the text that will be show on footer area. You also can using shortcode ex: [tags][socials] for display tag widget.','lapindos'),
                'default' => '&copy; '.date('Y').' '.sprintf(esc_html__('%s, The Awesome Theme. All right reserved.','lapindos'),get_template()),
                'editor_options'=>array( 'media_buttons' => false, 'tinymce' => false,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'=>'right-copyright-text',
                'type' => 'editor',
                'title' => esc_html__('Right Content', 'lapindos'), 
                'subtitle' => esc_html__('Type in the text that will be show on footer area. You also can using shortcode ex: [tags][socials] for display tag widget.','lapindos'),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => false, 'tinymce' => false,'wpautop' => true),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'            => 'footer-copyright-grid',
                'type'          => 'slider',
                'title'         => esc_html__( 'Left Content Width', 'lapindos' ),
                'description'      => esc_html__( '12 grids it\'s mean 100% of page width.', 'lapindos' ),
                'default'       => 12,
                'min'           => 1,
                'step'          => 1,
                'max'           => 12,
                'display_value' => 'text',
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'footer-bgcolor',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Footer Background Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a background color for the footer area', 'lapindos' ),
                'default'  => array('color'=>'#356a9c','alpha'=>1),
                'required' => array( 'footer-type', '=', array( 'option') )
            ),
            array(
                'id'       => 'footer-text-color',
                'type'     => 'color',
                'transparent' => false,
                'title'    => esc_html__( 'Footer Text Color', 'lapindos' ),
                'subtitle' => esc_html__( 'Pick a color for the footer text.', 'lapindos' ),
                'default'  => '#ffffff',
                'required' => array( 'footer-type', '=', array( 'option') )
            )

        )
    ) );


    ThemegumRedux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Styles', 'lapindos' ),
        'id'               => 'style',
        'customizer_width' => '400px',
        'icon'             => 'el el-adjust-alt',
    ) );


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'color-preset-section',
        'subsection' => true,
        'title'    => esc_html__( 'Pre-Set Colors', 'lapindos' ),
        'fields'           => array(
                array(
                    'id'         => 'color-presets',
                    'type'       => 'image_select',
                    'presets'    => true,
                    'title'      => esc_html__( 'COLOR PRESETS', 'lapindos' ),
                    'subtitle'   => esc_html__( 'Select pre-define a color set. Becareful! your last color will be overwriten.', 'lapindos' ),
                    'default'    => 0,
                    'options'    => array(
                        '1' => array(
                            'alt'     => esc_html__( 'Yellow Egg','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset1.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#e95095","alpha":"1","rgba":"rgba(233,80,149,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#e95095","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#e95095","menu_icon_label_color":"#e95095","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#e95095","alpha":"1","rgba":"rgba(233,80,149,1)"},"menu-color":{"regular":"#222222","hover":"#e95095","active":"#e95095"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#e95095","alpha":"1","rgba":"rgba(233,80,149,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#e95095","secondary_color":"#fde428","third_color":"#eeeeee","link-color":"#e95095","link-hover-color":"#e87dad","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '2' => array(
                            'alt'     => esc_html__( 'Egg Plant','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset2.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#7049ba","alpha":"1","rgba":"rgba(112,73,186,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#7049ba","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#7049ba","menu_icon_label_color":"#7049ba","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#e95095","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#7049ba","alpha":"1","rgba":"rgba(112,73,186,1)"},"menu-color":{"regular":"#222222","hover":"#7049ba","active":"#7049ba"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#e95095","active":"#e95095"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#7049ba","alpha":"1","rgba":"rgba(112,73,186,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#7049ba","secondary_color":"#e95095","third_color":"#eeeeee","link-color":"#7049ba","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '3' => array(
                            'alt'     => esc_html__( 'Blue Sea','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset3.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#337195","alpha":"1","rgba":"rgba(51,113,149,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#337195","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#337195","menu_icon_label_color":"#337195","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#49ade6","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#337195","alpha":"1","rgba":"rgba(51,113,149,1)"},"menu-color":{"regular":"#222222","hover":"#337195","active":"#337195"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#49ade6","active":"#49ade6"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#337195","alpha":"1","rgba":"rgba(51,113,149,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#337195","secondary_color":"#49ade6","third_color":"#eeeeee","link-color":"#337195","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '4' => array(
                            'alt'     => esc_html__( 'Green','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset4.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#fab356","alpha":"1","rgba":"rgba(250,179,86,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#fab356","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#fab356","menu_icon_label_color":"#fab356","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#fde428","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#fab356","alpha":"1","rgba":"rgba(250,179,86,1)"},"menu-color":{"regular":"#222222","hover":"#fab356","active":"#fab356"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fde428","active":"#fde428"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#fab356","alpha":"1","rgba":"rgba(250,179,86,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#fab356","secondary_color":"#fde428","third_color":"#eeeeee","link-color":"#fab356","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '5' => array(
                            'alt'     => esc_html__( 'Yellow Pine','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset5.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#5c5c5c","alpha":"1","rgba":"rgba(92,92,92,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#5c5c5c","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#5c5c5c","menu_icon_label_color":"#5c5c5c","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#fab356","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#5c5c5c","alpha":"1","rgba":"rgba(92,92,92,1)"},"menu-color":{"regular":"#222222","hover":"#5c5c5c","active":"#5c5c5c"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fab356","active":"#fab356"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#5c5c5c","alpha":"1","rgba":"rgba(92,92,92,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#5c5c5c","secondary_color":"#fab356","third_color":"#eeeeee","link-color":"#5c5c5c","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '6' => array(
                            'alt'     => esc_html__( 'Nerazuri','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset6.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#626466","alpha":"1","rgba":"rgba(98,100,102,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#626466","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#626466","menu_icon_label_color":"#626466","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#5296ee","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#626466","alpha":"1","rgba":"rgba(98,100,102,1)"},"menu-color":{"regular":"#222222","hover":"#626466","active":"#626466"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#5296ee","active":"#5296ee"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#626466","alpha":"1","rgba":"rgba(98,100,102,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#626466","secondary_color":"#5296ee","third_color":"#eeeeee","link-color":"#626466","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '7' => array(
                            'alt'     => esc_html__( 'Pastal','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset7.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#fe6b67","alpha":"1","rgba":"rgba(254,107,103,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#fe6b67","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#fe6b67","menu_icon_label_color":"#fe6b67","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#fdb752","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#fe6b67","alpha":"1","rgba":"rgba(254,107,103,1)"},"menu-color":{"regular":"#222222","hover":"#fe6b67","active":"#fe6b67"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fdb752","active":"#fdb752"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#fe6b67","alpha":"1","rgba":"rgba(254,107,103,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#fe6b67","secondary_color":"#fdb752","third_color":"#eeeeee","link-color":"#fe6b67","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '8' => array(
                            'alt'     => esc_html__( 'Beach Sand','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset8.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#686260","alpha":"1","rgba":"rgba(104,98,96,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#686260","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#686260","menu_icon_label_color":"#686260","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#e1b6a1","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#686260","alpha":"1","rgba":"rgba(104,98,96,1)"},"menu-color":{"regular":"#222222","hover":"#686260","active":"#686260"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#e1b6a1","active":"#e1b6a1"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#686260","alpha":"1","rgba":"rgba(104,98,96,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#686260","secondary_color":"#e1b6a1","third_color":"#eeeeee","link-color":"#686260","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '9' => array(
                            'alt'     => esc_html__( 'Royalls','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset9.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#a8416a","alpha":"1","rgba":"rgba(168,65,106,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#a8416a","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#a8416a","menu_icon_label_color":"#a8416a","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#f6b867","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#a8416a","alpha":"1","rgba":"rgba(168,65,106,1)"},"menu-color":{"regular":"#222222","hover":"#a8416a","active":"#a8416a"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#F6B867","active":"#F6B867"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#a8416a","alpha":"1","rgba":"rgba(168,65,106,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#a8416a","secondary_color":"#f6b867","third_color":"#eeeeee","link-color":"#686260","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '10' => array(
                            'alt'     => esc_html__( 'Mint','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset10.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#33cc99","alpha":"1","rgba":"rgba(51,204,153,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#33cc99","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#33cc99","menu_icon_label_color":"#33cc99","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#5cc9ff","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#33cc99","alpha":"1","rgba":"rgba(51,204,153,1)"},"menu-color":{"regular":"#222222","hover":"#33cc99","active":"#33cc99"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#5cc9ff","active":"#5cc9ff"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#33cc99","alpha":"1","rgba":"rgba(51,204,153,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#33cc99","secondary_color":"#5cc9ff","third_color":"#eeeeee","link-color":"#33cc99","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '11' => array(
                            'alt'     => esc_html__( 'Ello','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset11.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#a18dc6","alpha":"1","rgba":"rgba(161,141,198,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#a18dc6","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#a18dc6","menu_icon_label_color":"#a18dc6","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#ffd33b","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#a18dc6","alpha":"1","rgba":"rgba(161,141,198,1)"},"menu-color":{"regular":"#222222","hover":"#a18dc6","active":"#a18dc6"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#ffd33b","active":"#ffd33b"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#a18dc6","alpha":"1","rgba":"rgba(161,141,198,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#a18dc6","secondary_color":"#ffd33b","third_color":"#eeeeee","link-color":"#a18dc6","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '12' => array(
                            'alt'     => esc_html__( 'Black Ello','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset12.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#000000","alpha":"1","rgba":"rgba(0,0,0,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#000000","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#000000","menu_icon_label_color":"#000000","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#eeeeee","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#000000","alpha":"1","rgba":"rgba(0,0,0,1)"},"menu-color":{"regular":"#222222","hover":"#000000","active":"#000000"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#eeeeee","active":"#eeeeee"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#000000","alpha":"1","rgba":"rgba(0,0,0,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#000000","secondary_color":"#eeeeee","third_color":"#eeeeee","link-color":"#000000","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '13' => array(
                            'alt'     => esc_html__( 'Retro','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset13.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#f58974","alpha":"1","rgba":"rgba(245,137,116,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#f58974","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#f58974","menu_icon_label_color":"#f58974","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#6cc9d5","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#f58974","alpha":"1","rgba":"rgba(245,137,116,1)"},"menu-color":{"regular":"#222222","hover":"#f58974","active":"#f58974"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#6cc9d5","active":"#6cc9d5"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#f58974","alpha":"1","rgba":"rgba(245,137,116,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#F58974","secondary_color":"#6cc9d5","third_color":"#eeeeee","link-color":"#F58974","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '14' => array(
                            'alt'     => esc_html__( 'Modern','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset14.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#ff5579","alpha":"1","rgba":"rgba(255,85,121,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#ff5579","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#ff5579","menu_icon_label_color":"#ff5579","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#8990a2","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#ff5579","alpha":"1","rgba":"rgba(255,85,121,1)"},"menu-color":{"regular":"#222222","hover":"#ff5579","active":"#ff5579"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#8990a2","active":"#8990a2"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#ff5579","alpha":"1","rgba":"rgba(255,85,121,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#ff5579","secondary_color":"#8990a2","third_color":"#eeeeee","link-color":"#ff5579","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '15' => array(
                            'alt'     => esc_html__( 'Nautica','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset15.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#fd696d","alpha":"1","rgba":"rgba(253,105,109,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#fd696d","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#fd696d","menu_icon_label_color":"#fd696d","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#69bada","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#fd696d","alpha":"1","rgba":"rgba(253,105,109,1)"},"menu-color":{"regular":"#222222","hover":"#fd696d","active":"#fd696d"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#69bada","active":"#69bada"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#fd696d","alpha":"1","rgba":"rgba(253,105,109,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#fd696d","secondary_color":"#69bada","third_color":"#eeeeee","link-color":"#fd696d","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}'
                        ),
                        '16' => array(
                            'alt'     => esc_html__( 'Mild','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset16.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#34a6b9","alpha":"1","rgba":"rgba(52,166,185,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#34a6b9","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#34a6b9","menu_icon_label_color":"#34a6b9","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#54c1a5","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#34a6b9","alpha":"1","rgba":"rgba(52,166,185,1)"},"menu-color":{"regular":"#222222","hover":"#34a6b9","active":"#34a6b9"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#34a6b9","active":"#34a6b9"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#34a6b9","alpha":"1","rgba":"rgba(52,166,185,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#34a6b9","secondary_color":"#54C1A5","third_color":"#eeeeee","link-color":"#34a6b9","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '17' => array(
                            'alt'     => esc_html__( 'Midnight Pastal','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset17.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#e77169","alpha":"1","rgba":"rgba(231,113,105,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#e77169","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#e77169","menu_icon_label_color":"#e77169","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#87b9c9","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#e77169","alpha":"1","rgba":"rgba(231,113,105,1)"},"menu-color":{"regular":"#222222","hover":"#e77169","active":"#e77169"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#87b9c9","active":"#87b9c9"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#e77169","alpha":"1","rgba":"rgba(231,113,105,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#e77169","secondary_color":"#87b9c9","third_color":"#eeeeee","link-color":"#e77169","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '18' => array(
                            'alt'     => esc_html__( 'Modern Cyan','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset18.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#858585","alpha":"1","rgba":"rgba(133,133,133,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#858585","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#858585","menu_icon_label_color":"#858585","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#5bcbef","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#858585","alpha":"1","rgba":"rgba(133,133,133,1)"},"menu-color":{"regular":"#222222","hover":"#858585","active":"#858585"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#5bcbef","active":"#5bcbef"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#858585","alpha":"1","rgba":"rgba(133,133,133,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#858585","secondary_color":"#5bcbef","third_color":"#eeeeee","link-color":"#858585","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '19' => array(
                            'alt'     => esc_html__( 'Light Wood','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset19.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#bbb1a0","alpha":"1","rgba":"rgba(187,177,160,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#bbb1a0","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#bbb1a0","menu_icon_label_color":"#bbb1a0","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#b1c8b3","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#bbb1a0","alpha":"1","rgba":"rgba(187,177,160,1)"},"menu-color":{"regular":"#222222","hover":"#bbb1a0","active":"#bbb1a0"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#b1c8b3","active":"#b1c8b3"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#bbb1a0","alpha":"1","rgba":"rgba(187,177,160,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#bbb1a0","secondary_color":"#b1c8b3","third_color":"#eeeeee","link-color":"#bbb1a0","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '20' => array(
                            'alt'     => esc_html__( 'Moist Wood','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset20.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#b1b691","alpha":"1","rgba":"rgba(177,182,145,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#b1b691","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#b1b691","menu_icon_label_color":"#b1b691","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#d2b7a1","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#b1b691","alpha":"1","rgba":"rgba(177,182,145,1)"},"menu-color":{"regular":"#222222","hover":"#b1b691","active":"#b1b691"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#d2b7a1","active":"#d2b7a1"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#b1b691","alpha":"1","rgba":"rgba(177,182,145,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#b1b691","secondary_color":"#d2b7a1","third_color":"#eeeeee","link-color":"#b1b691","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '21' => array(
                            'alt'     => esc_html__( 'Twilight','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset21.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#a996cc","alpha":"1","rgba":"rgba(169,150,204,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#a996cc","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#a996cc","menu_icon_label_color":"#a996cc","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#8db9dc","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#a996cc","alpha":"1","rgba":"rgba(169,150,204,1)"},"menu-color":{"regular":"#222222","hover":"#a996cc","active":"#a996cc"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#8db9dc","active":"#8db9dc"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#a996cc","alpha":"1","rgba":"rgba(169,150,204,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#a996cc","secondary_color":"#8db9dc","third_color":"#eeeeee","link-color":"#a996cc","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '22' => array(
                            'alt'     => esc_html__( 'Brazillian','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset22.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#48c9b0","alpha":"1","rgba":"rgba(72,201,176,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#48c9b0","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#48c9b0","menu_icon_label_color":"#48c9b0","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#fbc739","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#48c9b0","alpha":"1","rgba":"rgba(72,201,176,1)"},"menu-color":{"regular":"#222222","hover":"#48c9b0","active":"#48c9b0"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#fbc739","active":"#fbc739"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#48c9b0","alpha":"1","rgba":"rgba(72,201,176,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#48c9b0","secondary_color":"#fbc739","third_color":"#eeeeee","link-color":"#48c9b0","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '23' => array(
                            'alt'     => esc_html__( 'City Scape','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset23.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#fd8681","alpha":"1","rgba":"rgba(253,134,129,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#fd8681","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#fd8681","menu_icon_label_color":"#fd8681","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#a5e0f7","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#fd8681","alpha":"1","rgba":"rgba(253,134,129,1)"},"menu-color":{"regular":"#222222","hover":"#fd8681","active":"#fd8681"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#a5e0f7","active":"#a5e0f7"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#fd8681","alpha":"1","rgba":"rgba(253,134,129,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#fd8681","secondary_color":"#a5e0f7","third_color":"#eeeeee","link-color":"#fd8681","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),
                        '24' => array(
                            'alt'     => esc_html__( 'Golden Eyes','lapindos'),
                            'img'     => get_template_directory_uri().'/lib/images/color_preset24.png',
                            'presets' =>'{"topbar-bgcolor":{"color":"#4d4b49","alpha":"1","rgba":"rgba(77,75,73,1)"},"topbar-inner-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"topbar-color":"#ffffff","topbar-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"iconbar-color":"#4d4b49","navbar-outer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-inner-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"navbar-color":"#222222","bottom-border-color":{"color":"","alpha":"","rgba":"0,0,0"},"heading-background-color":{"color":"","alpha":"","rgba":"0,0,0"},"page-title-color":"#333333","breadcrumb-color":"#333333","breadcrumb-link-color":"#333333","sticky-color":"","mobile-background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"mobile-inside-background-color":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"menu_icon_color":"#4d4b49","menu_icon_label_color":"#4d4b49","menu_icon_value_color":"#747578","icongraphic_sticky_color":"","icongraphic_sticky_label_color":"","icongraphic_sticky_value_color":"","menu_iconflat_color":"#be9934","menu_iconflat_label_color":"#ffffff","menu_iconflat_value_color":"#ffffff","iconflat_sticky_color":"#eeee22","iconflat_sticky_label_color":"#81d742","iconflat_sticky_value_color":"#dd3333","quote_menu_color":{"regular":"","hover":""},"quote_menu_bg_color":{"regular":"","hover":""},"quote_menu_border_color":{"regular":"","hover":""},"quote_menu_sticky_color":{"regular":"#ffffff","hover":""},"quote_menu_sticky_bg_color":{"regular":"#1e73be","hover":""},"quote_menu_sticky_border_color":{"regular":"#1e73be","hover":""},"social_color":{"regular":"","hover":""},"social_bg_color":{"regular":"","hover":""},"social_sticky_color":{"regular":"#167a89","hover":"#ffffff"},"social_sticky_bg_color":{"regular":"#dd9933","hover":"#1e73be"},"menubar-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"dropdown-background-color":{"color":"#4d4b49","alpha":"1","rgba":"rgba(77,75,73,1)"},"menu-color":{"regular":"#222222","hover":"#4d4b49","active":"#4d4b49"},"sticky-menu-color":{"regular":"","hover":"","active":""},"menu-border":{"border-top":"0","border-right":"0","border-bottom":"0","border-left":"0","border-style":"solid","border-color":""},"hover-menu-border":{"color":"","alpha":"0","rgba":"rgba(0,0,0,0)"},"sub-menu-color":{"regular":"#ffffff","hover":"#be9934","active":"#be9934"},"mobile-menu-color":{"regular":"","hover":"","active":""},"mobile-menu-bg":{"color":"#f7f7f7","alpha":"0","rgba":"rgba(247,247,247,0)"},"short_menu_color":{"regular":"","hover":""},"short_menu_sticky_color":{"regular":"","hover":""},"slidingbar_bg":"#ffffff","sliding_overlay":"","toggle-slide-color":{"regular":"","hover":""},"bottom-widget-bgcolor":{"color":"#4d4b49","alpha":"1","rgba":"rgba(77,75,73,1)"},"bottom-widget-color":"#ffffff","footer-bgcolor":{"color":"","alpha":"","rgba":"0,0,0"},"footer-text-color":"#ffffff","textcolor":"#4f4f4f","heading_color":"#333333","primary_color":"#4d4b49","secondary_color":"#be9934","third_color":"#eeeeee","link-color":"#4d4b49","link-hover-color":"#1f7ab7","content-background":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"},"background-color":{"color":"#ffffff","alpha":"1","rgba":"rgba(255,255,255,1)"}}'
                        ),

                    ),
                ),
        )));


    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'general-style-section-start',
        'type'     => 'section',
        'title'    => esc_html__( 'General Colors', 'lapindos' ),
        'desc' => esc_html__( 'General Style Settings.', 'lapindos' ),
        'subsection' => true,
        'fields' => array(
                array(
                    'id'=>'textcolor',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Body Text Color', 'lapindos'), 
                    'subtitle' => esc_html__('The color for body and all text.', 'lapindos'),
                    'default' => '#4f4f4f',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'heading_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Heading Color', 'lapindos'), 
                    'subtitle' => esc_html__('Color for heading. sualy with h1,h2,h3,h4,h5,h6,.h1) tags or .h1,.h2,.h3,.h4,.h5,.h6,.heading-color classes.', 'lapindos'),
                    'default' => '#333333',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'primary_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Primary Color', 'lapindos'), 
                    'subtitle' => esc_html__('Select color for primary brand', 'lapindos'),
                    'default' => '#2e96db',
                    'validate' => 'color'
                    ),  
                array(
                    'id'=>'secondary_color',
                    'type' => 'color',
                    'transparent'=>false,
                    'output' => '',
                    'title' => esc_html__('Secondary Color', 'lapindos'), 
                    'subtitle' => esc_html__('Select color for secondary brand', 'lapindos'),
                    'default' => '#fde428',
                    'validate' => 'color'
                    ),  
                array(
                    'id'       => 'third_color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Third Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a color for decoration color', 'lapindos' ),
                    'default'  => '#eeeeee',
                ),
                array(
                    'id'       => 'link-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Link Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a link color', 'lapindos' ),
                    'default'  => '#2e96db',
                ),
                array(
                    'id'       => 'link-hover-color',
                    'type'     => 'color',
                    'transparent' => false,
                    'title'    => esc_html__( 'Link Hover Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Pick a link hover color', 'lapindos' ),
                    'default'  => '#1f7ab7',
                ),
                array(
                    'id'       => 'content-background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Content Background', 'lapindos' ),
                    'subtitle' => esc_html__( 'Background for content area.', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
                array(
                    'id'       => 'background-color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Body Background Color', 'lapindos' ),
                    'subtitle' => esc_html__( 'Background for body area.', 'lapindos' ),
                    'default'  => array(
                        'color' => '#ffffff',
                        'alpha' => '1'
                    ),
                ),
            )
        )
    );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'typography-section-start',
        'title'    => esc_html__( 'Typography', 'lapindos' ),
        'desc' => esc_html__( 'Font Style Settings.', 'lapindos' ),
        'subsection' => true,
        'fields' => array(
                array(
                    'id'       => 'body-font',
                    'type'     => 'typography',
                    'title'    => esc_html__( 'Body Font', 'lapindos' ),
                    'subtitle' => esc_html__( 'Specify the body font properties.', 'lapindos' ),
                    'font-style'    => false,
                    'full_width' => true,
                    'font-family' => true,
                    'google' => true,
                    'subsets'  => true,
                    'font-size'=> true,
                    'line-height'   => true,
                    'word-spacing'  => false, 
                    'letter-spacing'=> true,
                    'color'         => false,
                    'font-weight' => true,
                    'text-align'=> false,
                    'preview' => true, 
                    'output'   => false,
                    'default'  => array(),
//                    'output'   => array( 'body' ),
                ),
                array(
                    'id'          => 'heading-font',
                    'type'        => 'typography',
                    'title'       => esc_html__( 'Heading Font', 'lapindos' ),
                    'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'lapindos' ),
                    'font-style'    => false,
                    'full_width' => true,
                    'font-weight' => true,
                    'subsets'  => true,
                    'font-size'=> false,
                    'line-height'   => true,
                    'word-spacing'  => false, 
                    'letter-spacing'=> true,
                    'color'         => false, 
                    'text-align'=> false, 
                    'output'   => false,
                    'default'     => array()
                ),
                array(
                    'id'          => 'sub-heading-font',
                    'type'        => 'typography',
                    'title'       => esc_html__( 'Sub Heading Font', 'lapindos' ),
                    'subtitle'    => esc_html__( 'Typography option with each property can be called individually.', 'lapindos' ),
                    'font-style'    => false,
                    'full_width' => true,
                    'font-weight' => true,
                    'subsets'  => true,
                    'font-size'=> false,
                    'line-height'   => true,
                    'word-spacing'  => false, 
                    'letter-spacing'=> true,
                    'color'         => false, 
                    'text-align'=> false, 
                    'output'   => false,
                    'default'     => array()
                ),
            )
        )
    );

    ThemegumRedux::setSection( $opt_name, array(
        'title' => esc_html__( 'Advanced', 'lapindos' ),
        'icon'  => 'el el-wrench',
        'customizer_width' => '400px',
        'id'    =>'advance',
        'fields'=>array(
            array(
                'id'=>'purchase_number',
                'type' => 'password', 
                'title' => esc_html__('Item Purchase Number', 'lapindos'),
                'description'=>sprintf(esc_html__('purchase number from %s. ex:xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'lapindos'),"themeforest.net"),
                'default'=>"",
             ),
            array(
                'id'       => '404-page',
                'type'     => 'select',
                'data'     => 'pages',
                'title'    => esc_html__( 'Custom 404 Page', 'lapindos' ),
                'subtitle' => esc_html__( 'Select a page as 404 error message', 'lapindos' ),
            ),
            array(
                'id'=>'404-text',
                'type' => 'editor',
                'title' => esc_html__('Custom 404 Text', 'lapindos'), 
                'subtitle' => esc_html__('Type in the text that will be show on error 404 page if  no Custom 404 Page selected. If both custom 404 page and custom 404 text empty, default 404 given.','lapindos'),
                'default' => '',
                'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => true),
            ),
             array(
                'id'=>'js-code',
                'type' => 'ace_editor',
                'title' => esc_html__('Javascript Code', 'lapindos'), 
                'subtitle' => esc_html__('Put your javascript code here.', 'lapindos'),
                'mode' => 'javascript',
                'description'=>esc_html__('Code only ( without tag )', 'lapindos'),
                'theme' => 'monokai',
                'default' => ""
                ),
            array(
                'id'=>'devmode',
                'type' => 'switch', 
                'title' => esc_html__('Development Mode', 'lapindos'),
                'subtitle'=> esc_html__('Custom css style and custom style will embed in-page.', 'lapindos'),
                "default"=> 0,
                'on' => esc_html__('Yes', 'lapindos'),
                'off' => esc_html__('No', 'lapindos')
            ),  

        )
    ) );



    ThemegumRedux::setSection( $opt_name, array(
        'id'       => 'bootstrap-section-start',
        'title'    => esc_html__( 'Body Settings', 'lapindos' ),
        'subsection' => true,
        'fields' => array(
                array(
                    'id'=>'gutter-width',
                    'type' => 'text',
                    'title' => esc_html__('Gutter Width','lapindos'),
                    'subtitle'=>esc_html__('Padding between columns. Gets divided in half for the left and right','lapindos'),
                    'description'=>esc_html__('The default is 30px','lapindos'),  
                    'default'=> '',
                ),
                array(
                    'id'=>'screen-tablet',
                    'type' => 'text',
                    'title' => esc_html__('Tablet Breakpoint','lapindos'),
                    'description'=>esc_html__('The default is 768px','lapindos'), 
                    'default'=> '',
                ),
                array(
                    'id'=>'screen-desktop',
                    'type' => 'text',
                    'title' => esc_html__('Desktop Breakpoint','lapindos'),
                    'description'=>esc_html__('The default is 992px','lapindos'), 
                    'default'=> '',
                ),
                array(
                    'id'=>'screen-lg-desktop',
                    'type' => 'text',
                    'title' => esc_html__('Wide Desktop Breakpoint','lapindos'),
                    'description'=>esc_html__('The default is 1200px','lapindos'), 
                    'default'=> '',
                ),
                array(
                    'id'             => 'body-spacing',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'all'            => false,
                    'right'        => false,     
                    'bottom'          => false,     
                    'units'          => 'px',      
                    'units_extended' => 'true',    
                    'title'          => esc_html__( 'Body Padding', 'lapindos' ),
                    'default'        => array(
                        'padding-top'    => '',
                        'padding-left' => '',
                    )
                ),
                array(
                    'id'=>'mobile-responsive',
                    'type' => 'switch', 
                    'title' => esc_html__('Turn Off Mobile Responsive', 'lapindos'),
                    'subtitle'=> esc_html__('Responsiveness.', 'lapindos'),
                    "default"=> 0,
                    'on' => esc_html__('Yes', 'lapindos'),
                    'off' => esc_html__('No', 'lapindos')
                ),  
                array(
                    'id'=>'viewport-with',
                    'type' => 'text',
                    'title' => esc_html__('Screen Width','lapindos'),
                    'description'=>esc_html__('Custom page width. Leave blank if not defined.','lapindos'), 
                    'default'=> '',
                    'required' => array( 'mobile-responsive', '=', true )
                ),
            )
        )
    );




function lapindos_translateable_config(){

    return array(
        'footer-text',
        '404-text',
        'footer-copyright-text',
        'right-copyright-text',
        'pre-footer-text',
        'icon-text-module',
        'text-module',
        'search-empty-text',
        'search_heading_title',
        'quote_menu_label'
    );
}


function lapindos_custom_variable($options=array()){

    global $wp_filesystem;


    $blog_id="";
    if ( is_multisite()){
        $blog_id="-site".get_current_blog_id();
    }

    if(isset($options['logo_image'])){
        $logo_id = isset($options['logo_image']['id']) ? $options['logo_image']['id'] : '';
        set_theme_mod( 'custom_logo', $logo_id );
    }

    if(isset($options['logo_image_alt'])){
        $logo_alt_id = isset($options['logo_image_alt']['id']) ? $options['logo_image_alt']['id'] : '';
        set_theme_mod( 'custom_logo_alt', $logo_alt_id );
    }

    if(isset($options['heading_image'])){

        $header_image_data =  wp_parse_args($options['heading_image'] , array('id'=>'','url'=>''));
        $header_image_data['attachment_id'] = $header_image_data['id'] ;

        set_theme_mod( 'header_image', esc_url_raw( $header_image_data['url'] ) );
        set_theme_mod( 'header_image_data', (object) $header_image_data );
    }

  
    $filename = get_template_directory() . '/css/style'.$blog_id.'.css';

    ob_start();

    if(isset($options['site-title'])){
        $sitetitle = isset($options['site-title']) ? $options['site-title'] : '';
        update_option( 'blogname', $sitetitle );
    }

    if(isset($options['site-tagline'])){
        $blogdescription = isset($options['site-tagline']) ? $options['site-tagline'] : '';
        update_option( 'blogdescription', $blogdescription );
    }

    do_action('lapindos_change_style', $options);
    $cssline = ob_get_clean();

    set_theme_mod( 'custom_css', $cssline );

    if ( !$wp_filesystem->put_contents( $filename, $cssline) ) {
        $error = $wp_filesystem->errors;

        update_option( 'css_folder_writeable', false);

        if('empty_hostname'==$error->get_error_code()){
            $wp_filesystem=new WP_Filesystem_Direct(array());
            if($wp_filesystem){
                if(!$wp_filesystem->put_contents( $filename, $cssline)){
                        $error = $wp_filesystem->errors;
                        return new WP_Error('fs_error', esc_html__('Filesystem error.','lapindos'), $error);
                }

            }else{
                return new WP_Error('fs_error', esc_html__('Filesystem error.','lapindos'), $wp_filesystem->errors);
            }


        }else{

            return new WP_Error('fs_error', esc_html__('Filesystem error.','lapindos'), $error);
        }
    }
    else{
        update_option( 'css_folder_writeable', true);
    }

}

add_action('redux-saved-'.redux_opt_name(), 'lapindos_custom_variable', 1);


?>