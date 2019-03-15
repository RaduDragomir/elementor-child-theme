<?php

global $rdTheme;
$rdTheme = new rdTheme();

class rdTheme {

	public $networks = [
		'facebook' => [
			'title' => 'Facebook', 
			'icon' => 'facebook-f',
		],
		'twitter' => [
			'title' => 'Twitter', 
			'icon' => 'twitter',
		],
		'linkedin' => [
			'title' => 'LinkedIn', 
			'icon' => 'linkedin',
		],
		'youtube' => [
			'title' => 'YouTube', 
			'icon' => 'youtube',
		],
		'vimeo' => [
			'title' => 'Vimeo', 
			'icon' => 'vimeo',
		],
		'instagram' => [
			'title' => 'Instagram', 
			'icon' => 'instagram',
		],
	];

	public $colors = [
		'background' => 'Background',
		'color' => 'Color',
		'accent' => 'Accent',
	];

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_styles'] );	
		add_action( 'init', [$this, 'init'], 10 );
		add_action( 'customize_register', [$this, 'customizer'] );
		add_action( 'wp_head', [$this, 'print_styles'] );
	}

	
	public function enqueue_styles() {
		//$ver = wp_get_theme()->get('Version');
		$ver = rand(1, 9999);
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'child-style',
			get_stylesheet_directory_uri() . '/style.css',
			array( 'parent-style' ),
			$ver
		);
		wp_enqueue_script('child-theme-scripts', get_stylesheet_directory_uri().'/scripts.js', ['jquery'], $ver);
	}

	
	public function init() {
		register_nav_menu( 'top', 'Top Location' );
	}


	
	public function customizer($wp_customize) {
		// social links
		$wp_customize->add_section( 'rdfw_social', [
			'title' => __('Social Links', 'rdfw'),
			'priority' => 30,
		]);
		foreach ($this->networks as $slug => $network) {
			$wp_customize->add_setting( $slug.'_url' , array(
				'default'   => '',
				'transport' => 'refresh',
			) );
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					$slug.'_url',
					array(
						'label'	  => $network['title'],
						'section'	=> 'rdfw_social',
						'settings'   => $slug.'_url',
						'type'	   => 'url',
					)
				)
			);  
		}
		// header
		$wp_customize->add_section( 'rdfw_header', [
			'title' => __('Header', 'rdfw'),
			'priority' => 20,
		]);
		foreach ($this->colors as $key => $label) {
			$wp_customize->add_setting( 'header_'.$key , array(
				'default'   => '',
				'transport' => 'refresh',
			) ); 
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'header_'.$key,
					array(
						'label'	  => $label,
						'section'	=> 'rdfw_header',
						'settings'   => 'header_'.$key,
					)
				)
			);  
		}

		$wp_customize->add_setting( 'header_line_color' , array(
			'default'   => '#000',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'header_line_color',
				array(
					'label'	  => 'Menu separator line color',
					'section'	=> 'rdfw_header',
					'settings'   => 'header_line_color',
				)
			)
		);  

		$wp_customize->add_setting( 'menu_icon_color' , array(
			'default'   => '#000',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'menu_icon_color',
				array(
					'label'	  => 'Menu icon color',
					'section'	=> 'rdfw_header',
					'settings'   => 'menu_icon_color',
				)
			)
		);  

		/*$wp_customize->add_setting( 'menu_underline' , array(
			'default'   => true,
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'menu_underline',
				array(
					'label'	  => 'Underline menu items on hover',
					'section'	=> 'rdfw_header',
					'settings'   => 'menu_underline',
					'type'	   => 'checkbox',
				)
			)
		);  */

		$wp_customize->add_setting( 'header_breakpoint' , array(
			'default'   => '990',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'header_breakpoint',
				array(
					'label'	  => 'Collapse breakpoint in px',
					'section'	=> 'rdfw_header',
					'settings'   => 'header_breakpoint',
					'type'	   => 'number',
				)
			)
		);  

		$wp_customize->add_setting( 'logo_width' , array(
			'default'   => '200',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'logo_width',
				array(
					'label'	  => 'Logo width in px',
					'section'	=> 'rdfw_header',
					'settings'   => 'logo_width',
					'type'	   => 'number',
				)
			)
		);  

		$wp_customize->add_setting( 'primary_menu_padding' , array(
			'default'   => '15',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'primary_menu_padding',
				array(
					'label'	  => 'Top/bottom padding for primary menu',
					'section'	=> 'rdfw_header',
					'settings'   => 'primary_menu_padding',
					'type'	   => 'number',
				)
			)
		); 

		$wp_customize->add_setting( 'secondary_menu_padding' , array(
			'default'   => '10',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'secondary_menu_padding',
				array(
					'label'	  => 'Top/bottom padding for secondary menu',
					'section'	=> 'rdfw_header',
					'settings'   => 'secondary_menu_padding',
					'type'	   => 'number',
				)
			)
		); 

		$wp_customize->add_setting( 'primary_menu_distance' , array(
			'default'   => '60',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'primary_menu_distance',
				array(
					'label'	  => 'Distance between items for primary menu',
					'section'	=> 'rdfw_header',
					'settings'   => 'primary_menu_distance',
					'type'	   => 'number',
				)
			)
		); 

		$wp_customize->add_setting( 'secondary_menu_distance' , array(
			'default'   => '20',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'secondary_menu_distance',
				array(
					'label'	  => 'Distance between items for secondary menu',
					'section'	=> 'rdfw_header',
					'settings'   => 'secondary_menu_distance',
					'type'	   => 'number',
				)
			)
		); 

		$wp_customize->add_setting( 'logo_width_mobile' , array(
			'default'   => '200',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'logo_width_mobile',
				array(
					'label'	  => 'Logo width on mobile in px',
					'section'	=> 'rdfw_header',
					'settings'   => 'logo_width_mobile',
					'type'	   => 'number',
				)
			)
		);  

		$wp_customize->add_setting( 'header_font_size' , array(
			'default'   => '18',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'header_font_size',
				array(
					'label'	  => 'Menu font size in px',
					'section'	=> 'rdfw_header',
					'settings'   => 'header_font_size',
					'type'	   => 'number',
				)
			)
		); 
		// typography
		$wp_customize->add_section( 'rdfw_typography', [
			'title' => __('Typography', 'rdfw'),
			'priority' => 20,
		]);
		$base_size = 16;
		$m = 2;
		for ($i=1; $i<=6; $i++) {
			$wp_customize->add_setting( 'colors_heading_'.$i , array(
				'default'   => '#000000',
				'transport' => 'refresh',
			) ); 
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'colors_heading_'.$i,
					array(
						'label'	  => 'Heading '.$i.' Color',
						'section'	=> 'rdfw_typography',
						'settings'   => 'colors_heading_'.$i,
					)
				)
			);  
			$wp_customize->add_setting( 'sizes_heading_'.$i , array(
				'default'   => ceil($base_size*$m),
				'transport' => 'refresh',
			) ); 
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					'sizes_heading_'.$i,
					array(
						'label'	  => 'Heading '.$i.' size in px',
						'section'	=> 'rdfw_typography',
						'settings'   => 'sizes_heading_'.$i,
						'type' => 'number',
					)
				)
			);  
			$m -= 0.2;
		}
		$wp_customize->add_setting( 'colors_text' , array(
			'default'   => '#333333',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'colors_text',
				array(
					'label'	  => 'Paragraph/list Text',
					'section'	=> 'rdfw_typography',
					'settings'   => 'colors_text',
				)
			)
		);  
		$wp_customize->add_setting( 'text_font_size' , array(
			'default'   => '18',
			'transport' => 'refresh',
		) ); 
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'text_font_size',
				array(
					'label'	  => 'Text font size in px',
					'section'	=> 'rdfw_typography',
					'settings'   => 'text_font_size',
					'type'	   => 'number',
				)
			)
		); 
		foreach (['default', 'hover', 'visited', 'active'] as $link) {
			$wp_customize->add_setting( 'colors_link_'.$link , array(
				'default'   => '#000000',
				'transport' => 'refresh',
			) ); 
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'colors_link_'.$link,
					array(
						'label'	  => 'Link '.$link,
						'section'	=> 'rdfw_typography',
						'settings'   => 'colors_link_'.$link,
					)
				)
			);  
		}
		return $wp_customize;  
	}

	public function print_styles() {
		$color = get_theme_mod( 'header_color', '#646b71' );
		$background = get_theme_mod( 'header_background', '#ffffff' );
		$accent = get_theme_mod( 'header_accent', '#000000' );
		$mobileBreakpoint = get_theme_mod( 'header_breakpoint', '991' );
		$header_line_color = get_theme_mod( 'header_line_color', '#000' );

		$logo_width = get_theme_mod( 'logo_width', 200 );
		$logo_width_mobile = get_theme_mod( 'logo_width_mobile', 200 );
		$primary_menu_distance = get_theme_mod('primary_menu_distance', 60);
		$secondary_menu_distance = get_theme_mod('secondary_menu_distance', 20);

		$primary_menu_padding = get_theme_mod('primary_menu_padding', 10);
		$secondary_menu_padding = get_theme_mod('secondary_menu_padding', 15);

		$menu_underline = get_theme_mod( 'menu_underline', true );
		$menu_icon_color = get_theme_mod( 'menu_icon_color', '#000' );
		echo '<style id="rdThemeStyles">';
		echo "
			#site-header { background: {$background}; color: {$color}; }
			#site-header a { color: {$color}; }
			#site-header a:hover { color: {$accent}; }
			#site-header #primary-menu ul li { padding-left: {$primary_menu_distance}px }
			#site-header #primary-menu ul li.current-menu-parent > a, #site-header #primary-menu ul li.current-page-parent > a, #site-header #primary-menu ul li.current_page_parent > a, #site-header #primary-menu ul li.current-menu-item > a, #site-header #primary-menu ul li.current_page_item > a { color: {$accent}; }
			#site-header #primary-menu ul li ul { background: {$background} }
			#site-header #top .secondary-menu ul li { padding-left: {$secondary_menu_distance}px; }
			#site-header .rd-nav { background: {$background}; }
			#site-header #primary-menu ul li:hover { border-color: {$accent}; }
			#site-header #logo { padding: {$primary_menu_padding}px 0; }
			#site-header #logo img { width: {$logo_width}px; }
			#site-header #top { border-color: {$header_line_color}; padding-top: {$secondary_menu_padding}px;}
			#site-header .open-menu .lines,
			#site-header .open-menu .lines:before, 
			#site-header .open-menu .lines:after { background: {$menu_icon_color}};
			@media (max-width: {$mobileBreakpoint}px) {
				#site-header #logo img { width: {$logo_width_mobile}px; }
			}
		";
		if (!$menu_underline) {
			echo "#site-header #primary-menu ul li:hover {border-color: transparent;}";
		}
		for($i=1; $i<=6; $i++) {
			$color = get_theme_mod( 'colors_heading_'.$i );
			$size = get_theme_mod( 'sizes_heading_'.$i );
			if ($color || $size) {
				echo "h{$i} {";
				if ($color)  echo "color: {$color};";
				if ($size)  echo "font-size: {$size}px;";
				echo " } ";
			}
		}
		$header_size = get_theme_mod( 'header_font_size', 18);
		if ($header_size) {
			echo "#site-header { font-size: {$header_size}px; }";
		}
		$color = get_theme_mod( 'colors_text' );
		$text_size = get_theme_mod( 'text_font_size');
		if ($color || $text_size) {
			echo "p, ul, ol { ";
			if ($color) echo "color: {$color};";
			if ($text_size) echo "font-size: {$text_size}px;";
			echo " }";
		}
		foreach (['default', 'hover', 'visited', 'active'] as $link) {
			$color = get_theme_mod( 'colors_link_'.$link );
			if ($color) {
				$pseudo = $link == 'default' ? '' : ':'.$link;
				echo "a{$pseudo} { color: {$color}; }";
			}
		}
		echo '</style>';

		echo '<script>';
		echo "var mobileBreakpoint = {$mobileBreakpoint};";
		echo '</script>';
	}
}