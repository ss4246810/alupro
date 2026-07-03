<?php
/**
 * Dynamic site footer.
 *
 * @package AluProDynamic
 */

$footer_settings = alupro_dynamic_get_footer_settings();
$footer_logo = alupro_dynamic_get_logo_url();

$footer_1_fallback = array(
	array('label' => __('Home', 'alupro-dynamic'), 'url' => home_url('/')),
	array('label' => __('About Us', 'alupro-dynamic'), 'url' => home_url('/about-us/')),
	array('label' => __('Contact', 'alupro-dynamic'), 'url' => home_url('/contact/')),
);

$footer_2_fallback = function_exists('alupro_dynamic_product_category_nav_items') ? alupro_dynamic_product_category_nav_items() : array();

$footer_3_fallback = array(
	array('label' => __('Custom Services', 'alupro-dynamic'), 'url' => function_exists('alupro_dynamic_custom_services_anchor_url') ? alupro_dynamic_custom_services_anchor_url() : home_url('/#custom-services')),
	array('label' => __('Request a Quote', 'alupro-dynamic'), 'url' => home_url('/contact/')),
	array('label' => __('Download Catalogue', 'alupro-dynamic'), 'url' => get_theme_file_uri('images/PDF-Design.pdf')),
);

$footer_legal_fallback = array(
	array('label' => __('Privacy Policy', 'alupro-dynamic'), 'url' => '#'),
	array('label' => __('Terms of Use', 'alupro-dynamic'), 'url' => '#'),
	array('label' => __('Sitemap', 'alupro-dynamic'), 'url' => '#'),
);
?>
<!-- Footer Starts-->
<footer class="relative overflow-hidden bg-[#120A45] text-white px-6">
	<div class="footer-pattern absolute inset-0"></div>
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#F4C026]/50 to-transparent"></div>

	<div class="relative max-w-7xl mx-auto py-16 md:py-20">
		<div class="grid gap-12 border-b border-white/10 pb-12 lg:grid-cols-[1.15fr_0.75fr_0.9fr_0.75fr_1fr]">
			<div>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center">
					<img
						src="<?php echo esc_url($footer_logo); ?>"
						alt="<?php esc_attr_e('AluPro Alloy Solutions', 'alupro-dynamic'); ?>"
						class="h-16 w-auto"
					>
				</a>

				<?php if (!empty($footer_settings['description'])) : ?>
					<p class="mt-6 max-w-md text-base leading-7 text-[#D8DAEA]">
						<?php echo esc_html($footer_settings['description']); ?>
					</p>
				<?php endif; ?>

				<ul class="mt-6 space-y-5 text-sm text-[#D8DAEA]">
					<?php if (!empty($footer_settings['mailing_address'])) : ?>
						<li class="flex gap-4">
							<span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-location-dot"></i>
							</span>
							<span class="leading-6"><?php alupro_dynamic_footer_text($footer_settings['mailing_address']); ?></span>
						</li>
					<?php endif; ?>

					<?php if (!empty($footer_settings['warehouse_address'])) : ?>
						<li class="flex gap-4">
							<span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-location-dot"></i>
							</span>
							<span class="leading-6"><?php alupro_dynamic_footer_text($footer_settings['warehouse_address']); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<div>
				<h3 class="text-sm font-bold uppercase tracking-[0.18em] text-[#00a2e0]">
					<?php echo esc_html($footer_settings['footer_1_title']); ?>
				</h3>
				<?php alupro_dynamic_footer_menu('footer_1', $footer_1_fallback, 'footer'); ?>
			</div>

			<div>
				<h3 class="text-sm font-bold uppercase tracking-[0.18em] text-[#00a2e0]">
					<?php echo esc_html($footer_settings['footer_2_title']); ?>
				</h3>
				<?php alupro_dynamic_footer_menu('footer_2', $footer_2_fallback); ?>
			</div>

			<div>
				<h3 class="text-sm font-bold uppercase tracking-[0.18em] text-[#00a2e0]">
					<?php echo esc_html($footer_settings['footer_3_title']); ?>
				</h3>
				<?php alupro_dynamic_footer_menu('footer_3', $footer_3_fallback); ?>
			</div>

			<div>
				<h3 class="text-sm font-bold uppercase tracking-[0.18em] text-[#00a2e0]">
					<?php echo esc_html($footer_settings['contact_title']); ?>
				</h3>
				<ul class="mt-6 space-y-5 text-sm text-[#D8DAEA]">
					<?php if (!empty($footer_settings['phone'])) : ?>
						<li class="flex items-center gap-4">
							<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-phone-volume"></i>
							</span>
							<a href="<?php echo esc_url(alupro_dynamic_phone_href($footer_settings['phone'])); ?>" class="leading-6 transition-colors hover:text-[#00a2e0]">
								<?php echo esc_html($footer_settings['phone']); ?>
							</a>
						</li>
					<?php endif; ?>

					<?php if (!empty($footer_settings['email'])) : ?>
						<li class="flex items-center gap-4">
							<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-envelope-open"></i>
							</span>
							<a href="<?php echo esc_url('mailto:' . antispambot($footer_settings['email'])); ?>" class="leading-6 transition-colors hover:text-[#00a2e0]">
								<?php echo esc_html($footer_settings['email']); ?>
							</a>
						</li>
					<?php endif; ?>

					<?php if (!empty($footer_settings['fax'])) : ?>
						<li class="flex items-center gap-4">
							<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-fax"></i>
							</span>
							<span class="leading-6"><?php printf(esc_html__('Fax: %s', 'alupro-dynamic'), esc_html($footer_settings['fax'])); ?></span>
						</li>
					<?php endif; ?>

					<?php if (!empty($footer_settings['hours'])) : ?>
						<li class="flex items-center gap-4">
							<span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#00a2e0]">
								<i class="fa-solid fa-clock"></i>
							</span>
							<span class="leading-6"><?php echo esc_html($footer_settings['hours']); ?></span>
						</li>
					<?php endif; ?>
				</ul>

				<div class="mt-8 flex items-center gap-3">
					<?php if (!empty($footer_settings['linkedin_url'])) : ?>
						<a href="<?php echo esc_url($footer_settings['linkedin_url']); ?>" aria-label="<?php esc_attr_e('LinkedIn', 'alupro-dynamic'); ?>" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-[#00a2e0] transition-all hover:-translate-y-0.5 hover:border-[#00a2e0] hover:bg-[#00a2e0] hover:text-[#190E5D] hover:shadow-lg hover:shadow-[#00a2e0]/20">
							<i class="fa-brands fa-linkedin-in"></i>
						</a>
					<?php endif; ?>

					<?php if (!empty($footer_settings['facebook_url'])) : ?>
						<a href="<?php echo esc_url($footer_settings['facebook_url']); ?>" aria-label="<?php esc_attr_e('Facebook', 'alupro-dynamic'); ?>" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-[#00a2e0] transition-all hover:-translate-y-0.5 hover:border-[#00a2e0] hover:bg-[#00a2e0] hover:text-[#190E5D] hover:shadow-lg hover:shadow-[#00a2e0]/20">
							<i class="fa-brands fa-facebook-f"></i>
						</a>
					<?php endif; ?>

					<?php if (!empty($footer_settings['x_url'])) : ?>
						<a href="<?php echo esc_url($footer_settings['x_url']); ?>" aria-label="<?php esc_attr_e('X', 'alupro-dynamic'); ?>" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-[#00a2e0] transition-all hover:-translate-y-0.5 hover:border-[#00a2e0] hover:bg-[#00a2e0] hover:text-[#190E5D] hover:shadow-lg hover:shadow-[#00a2e0]/20">
							<i class="fa-brands fa-x-twitter"></i>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="flex flex-col gap-5 pt-8 text-sm text-[#B9BCD4] md:flex-row md:items-center md:justify-between">
			<p><?php echo esc_html($footer_settings['copyright']); ?></p>
			<?php alupro_dynamic_footer_menu('footer_legal', $footer_legal_fallback, '', 'flex flex-wrap gap-x-6 gap-y-3 font-medium'); ?>
		</div>
	</div>
</footer>
<!-- Footer Ends-->
