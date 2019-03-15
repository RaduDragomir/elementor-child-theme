<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header id="site-header" class="site-header" role="banner">
	<div id="top">
		<div class="rd-container d-flex">
			<div class="social">
				<?php
					global $rdTheme;
					$networks = $rdTheme->networks;
					foreach($networks as $slug => $network) {
					    $url = get_theme_mod( $slug.'_url' );
					    if ($url) {
					        printf('<a href="%s" title="%s%s" target="_blank"><i class="fa fa-%s"></i></a>', $url, __('Follow us on ', 'rdfw'), $network['title'], $network['icon']);
					    }
					}
				?>
			</div>
			<div class="secondary-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'top', 'depth' => 1, 'container' => false ) ); ?>
			</div>
		</div>
	</div>
	<div class="main-navigation">
		<div class="d-flex rd-container">
			<div id="logo">
				<?php the_custom_logo(); ?>
			</div>

			<a href="#" class="open-menu">
				<span class="lines"></span>
			</a>

			<div class="rd-nav">
				<nav id="primary-menu" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'depth' => 2, 'container' => false ) ); ?>
				</nav>
				<div id="secondary-menu">
					<?php wp_nav_menu( array( 'theme_location' => 'top', 'depth' => 1, 'container' => false ) ); ?>
				</div>
			</div>
		</div>
	</div>

</header>
