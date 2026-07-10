<?php

/**
 * Site header.
 *
 * @package AluProDynamic
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo esc_url(get_theme_file_uri('images/favicon.png')); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class('pt-[104px]'); ?>>
	<?php wp_body_open(); ?>
	<?php $logo_url = alupro_dynamic_get_logo_url(); ?>

	<!-- Header Starts -->
	<nav
		id="navbar"
		class="bg-[#180f5e] backdrop-blur-md border-b border-[#190E5D]/10 fixed top-0 left-0 right-0 z-50 shadow-sm">
		<div class="xl:max-w-7xl mx-auto px-6 2xl:px-0">
		<div class=" flex items-center justify-between py-5">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
				<img
					src="<?php echo esc_url($logo_url); ?>"
					alt="<?php esc_attr_e('AluPro Logo', 'alupro-dynamic'); ?>"
					class="h-16 w-auto">
			</a>

			<!-- Desktop Menu -->
			<div class="hidden md:flex items-center gap-x-4 lg:gap-x-8 text-sm font-medium">
				<?php
				if (has_nav_menu('primary')) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'walker'         => new AluPro_Dynamic_Desktop_Menu_Walker(),
							'fallback_cb'    => false,
						)
					);
				} else {
					alupro_dynamic_static_desktop_menu();
				}
				?>
			</div>

			<button
				type="button"
				class="js-quote-modal-open hidden md:block bg-[#00a2e0] hover:bg-[#0091c9] text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all shadow-sm shadow-[#190E5D]/20 cursor-pointer">
				Get Instant Quote
			</button>

			<button
				id="mobile-menu-button"
				class="md:hidden text-2xl text-[#fff]"
				type="button"
				aria-label="<?php esc_attr_e('Open navigation menu', 'alupro-dynamic'); ?>">
				<i class="fas fa-bars"></i>
			</button>
		</div>
		</div>

		<!-- Mobile Menu -->
		<div
			id="mobile-menu"
			class="hidden md:hidden bg-white border-t border-[#190E5D]/10 max-h-[calc(100vh-105px)] overflow-y-auto overscroll-contain">
			<div class="px-6 py-8 flex flex-col gap-6 text-base">
				<?php
				if (has_nav_menu('primary')) {
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'walker'         => new AluPro_Dynamic_Mobile_Menu_Walker(),
							'fallback_cb'    => false,
						)
					);
				} else {
					alupro_dynamic_static_mobile_menu();
				}
				?>

				<button
					type="button"
					class="js-quote-modal-open mt-4 bg-[#190E5D] text-white py-4 rounded-xl font-semibold cursor-pointer">
					Get Instant Quote
				</button>
			</div>
		</div>
	</nav>
	<!-- Header Ends -->