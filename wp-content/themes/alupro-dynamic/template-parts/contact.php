<?php
/**
 * Contact page content and enquiry form.
 *
 * @package AluProDynamic
 */

$contact_page_id = get_queried_object_id();
$footer_settings = function_exists('alupro_dynamic_get_footer_settings') ? alupro_dynamic_get_footer_settings() : array();
$contact_status = isset($_GET['alupro_contact']) ? sanitize_key(wp_unslash($_GET['alupro_contact'])) : '';
$redirect_to = remove_query_arg(array('alupro_subscribe', 'alupro_enquiry', 'alupro_contact'), add_query_arg(array()));

if (!function_exists('alupro_get_contact_field')) {
	function alupro_get_contact_field($field_name, $default_value, $post_id = null) {
		if (function_exists('get_field')) {
			$value = get_field($field_name, $post_id);

			if (!empty($value)) {
				return $value;
			}
		}

		return $default_value;
	}
}

if (!function_exists('alupro_contact_text')) {
	function alupro_contact_text($text) {
		echo wp_kses(nl2br(esc_html($text)), array('br' => array()));
	}
}

if (!function_exists('alupro_contact_address_body')) {
	function alupro_contact_address_body($text) {
		return trim((string) preg_replace('/^\s*(Mailing address|Warehouse)\s*:?\s*/i', '', (string) $text));
	}
}

$eyebrow = alupro_get_contact_field('contact_eyebrow', __('Contact Us', 'alupro-dynamic'), $contact_page_id);
$title = alupro_get_contact_field('contact_title', __("Let's Get Connected", 'alupro-dynamic'), $contact_page_id);
$description = alupro_get_contact_field(
	'contact_description',
	'',
	$contact_page_id
);
$details_title = alupro_get_contact_field('contact_details_title', __('Direct Contact', 'alupro-dynamic'), $contact_page_id);
$form_title = alupro_get_contact_field('contact_form_title', __('Send Your Message', 'alupro-dynamic'), $contact_page_id);
$form_description = alupro_get_contact_field(
	'contact_form_description',
	__('Fill the form below and we will contact you soon.', 'alupro-dynamic'),
	$contact_page_id
);

$phone = isset($footer_settings['phone']) ? $footer_settings['phone'] : '+65 6876 1198';
$email = isset($footer_settings['email']) ? $footer_settings['email'] : 'info@aluproalloy.com';
$mailing_address = isset($footer_settings['mailing_address']) ? $footer_settings['mailing_address'] : "Mailing address:\n8 Burn Road #11-03 Trivex Singapore 369977.";
$warehouse_address = isset($footer_settings['warehouse_address']) ? $footer_settings['warehouse_address'] : "Warehouse:\nBenoi Road, Singapore";
$mailing_address_body = alupro_contact_address_body($mailing_address);
$warehouse_address_body = alupro_contact_address_body($warehouse_address);
?>
<!-- Contact Page Starts -->
<section id="contact" class="materials-showcase relative overflow-hidden bg-[#F8FAFC] px-6 py-16 md:py-24 scroll-mt-[140px]">
	<div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-blue-200/50 blur-3xl"></div>
	<div class="absolute top-1/3 -right-40 h-[420px] w-[420px] rounded-full bg-cyan-200/50 blur-3xl"></div>
	<div class="absolute bottom-0 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-indigo-200/40 blur-3xl"></div>
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#190E5D]/20 to-transparent"></div>

	<div class="relative max-w-7xl mx-auto">
		<div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
			<div class="max-w-3xl">
				<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/30 bg-[#e6f6fc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
					<i class="fa-solid fa-phone"></i>
					<?php echo esc_html($eyebrow); ?>
				</span>
				<h1 class="mt-6 text-3xl font-extrabold leading-tight text-[#111827] sm:text-4xl lg:text-5xl">
					<?php echo esc_html($title); ?>
				</h1>
				<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0]"></div>
				<?php if ($description) : ?>
					<p class="mt-7 max-w-2xl text-base leading-8 text-[#4B5563] md:text-lg">
						<?php echo esc_html($description); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="grid gap-6 lg:grid-cols-[0.9fr_1.4fr] mt-14 mb-16">
			<div class="relative overflow-hidden rounded-[2rem] bg-[#180f5e] p-6 text-white shadow-2xl md:p-8">
				<div class="absolute inset-0 opacity-4">
					<div class="h-full w-full bg-[linear-gradient(to_right,#ffffff_1px,transparent_1px),linear-gradient(to_bottom,#ffffff_1px,transparent_1px)] bg-[size:38px_38px]"></div>
				</div>

				<div class="relative z-10">
					<div class="mb-10">
						<h2 class="text-2xl font-bold md:text-3xl">
							<?php echo esc_html($details_title); ?>
						</h2>
					</div>

					<div class="space-y-4">
						<?php if ($email) : ?>
							<div class="group rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:bg-white/10">
								<p class="mb-2 text-sm font-medium text-blue-300"><?php esc_html_e('Email', 'alupro-dynamic'); ?></p>
								<a href="<?php echo esc_url('mailto:' . antispambot($email)); ?>" class="text-lg font-semibold text-white">
									<?php echo esc_html($email); ?>
								</a>
							</div>
						<?php endif; ?>

						<?php if ($phone) : ?>
							<div class="group rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:bg-white/10">
								<p class="mb-2 text-sm font-medium text-blue-300"><?php esc_html_e('Phone', 'alupro-dynamic'); ?></p>
								<a href="<?php echo esc_url(function_exists('alupro_dynamic_phone_href') ? alupro_dynamic_phone_href($phone) : 'tel:' . preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-lg font-semibold text-white">
									<?php echo esc_html($phone); ?>
								</a>
							</div>
						<?php endif; ?>

						<?php if ($mailing_address_body) : ?>
							<div class="group rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:bg-white/10">
								<p class="mb-2 text-sm font-medium text-blue-300"><?php esc_html_e('Mailing address:', 'alupro-dynamic'); ?></p>
								<p class="text-lg font-semibold text-white">
									<?php alupro_contact_text($mailing_address_body); ?>
								</p>
							</div>
						<?php endif; ?>

						<?php if ($warehouse_address_body) : ?>
							<div class="group rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur transition hover:bg-white/10">
								<p class="mb-2 text-sm font-medium text-blue-300"><?php esc_html_e('Warehouse:', 'alupro-dynamic'); ?></p>
								<p class="text-lg font-semibold text-white">
									<?php alupro_contact_text($warehouse_address_body); ?>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-xl shadow-blue-100/70 md:p-8">
				<div class="mb-8 flex flex-col gap-4 border-b border-slate-100 pb-6 md:flex-row md:items-center md:justify-between">
					<div>
						<h2 class="text-2xl font-bold text-slate-950 md:text-3xl">
							<?php echo esc_html($form_title); ?>
						</h2>
						<?php if ($form_description) : ?>
							<p class="mt-2 text-slate-500">
								<?php echo esc_html($form_description); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ('success' === $contact_status) : ?>
					<p class="mb-6 rounded-2xl border border-[#00a2e0]/25 bg-[#EAF7FF] px-5 py-3 text-sm font-semibold text-[#0077AA]">
						<?php esc_html_e('Thank you. Your message has been sent.', 'alupro-dynamic'); ?>
					</p>
				<?php elseif ('invalid' === $contact_status) : ?>
					<p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700">
						<?php esc_html_e('Please provide your name, valid email address, and message.', 'alupro-dynamic'); ?>
					</p>
				<?php elseif ('error' === $contact_status) : ?>
					<p class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700">
						<?php esc_html_e('The message could not be sent. Please try again.', 'alupro-dynamic'); ?>
					</p>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-5">
					<input type="hidden" name="action" value="alupro_contact_enquiry">
					<input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>">
					<?php wp_nonce_field('alupro_contact_enquiry', 'alupro_contact_nonce'); ?>

					<div class="grid gap-5 md:grid-cols-2">
						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_name">
								<?php esc_html_e('Full Name', 'alupro-dynamic'); ?>
							</label>
							<input id="alupro_contact_name" type="text" name="name" placeholder="<?php esc_attr_e('Enter your name', 'alupro-dynamic'); ?>" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
						</div>

						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_company">
								<?php esc_html_e('Company Name', 'alupro-dynamic'); ?>
							</label>
							<input id="alupro_contact_company" type="text" name="company" placeholder="<?php esc_attr_e('Enter your company name', 'alupro-dynamic'); ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
						</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_email">
								<?php esc_html_e('Email Address', 'alupro-dynamic'); ?>
							</label>
							<input id="alupro_contact_email" type="email" name="email" placeholder="<?php esc_attr_e('Enter your email', 'alupro-dynamic'); ?>" required class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
						</div>

						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_phone">
								<?php esc_html_e('Phone Number', 'alupro-dynamic'); ?>
							</label>
							<input id="alupro_contact_phone" type="tel" name="phone" placeholder="<?php esc_attr_e('Enter your phone', 'alupro-dynamic'); ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
						</div>
					</div>

					<div>
						<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_subject">
							<?php esc_html_e('Subject', 'alupro-dynamic'); ?>
						</label>
						<input id="alupro_contact_subject" type="text" name="subject" placeholder="<?php esc_attr_e('Write your subject', 'alupro-dynamic'); ?>" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">
					</div>

					<div>
						<label class="mb-2 block text-sm font-semibold text-slate-700" for="alupro_contact_message">
							<?php esc_html_e('Message', 'alupro-dynamic'); ?>
						</label>
						<textarea id="alupro_contact_message" name="message" rows="6" placeholder="<?php esc_attr_e('Tell us about your project or question...', 'alupro-dynamic'); ?>" required class="w-full resize-none rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"></textarea>
					</div>

					<input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

					<div class="flex flex-col gap-4 pt-2 md:flex-row md:items-center md:justify-between">
						<button type="submit" class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-[#00a2e0] hover:bg-[#0091c9] px-8 py-4 font-bold text-white shadow-sm shadow-[#190E5D]/20 transition hover:-translate-y-1 cursor-pointer">
							<?php esc_html_e('Send Message', 'alupro-dynamic'); ?>
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
							</svg>
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="mt-6 grid gap-6 md:grid-cols-3">
			<div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-lg shadow-blue-100/50">
				<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
				</div>
				<h3 class="text-lg font-bold text-slate-950"><?php esc_html_e('Fast Response', 'alupro-dynamic'); ?></h3>
				<p class="mt-2 leading-7 text-slate-500">
					<?php esc_html_e('Our team replies quickly with clear and helpful answers.', 'alupro-dynamic'); ?>
				</p>
			</div>

			<div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-lg shadow-blue-100/50">
				<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
					</svg>
				</div>
				<h3 class="text-lg font-bold text-slate-950"><?php esc_html_e('Trusted Support', 'alupro-dynamic'); ?></h3>
				<p class="mt-2 leading-7 text-slate-500">
					<?php esc_html_e('Your message is handled professionally and carefully.', 'alupro-dynamic'); ?>
				</p>
			</div>

			<div class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-lg shadow-blue-100/50">
				<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-4a4 4 0 11-8 0 4 4 0 018 0z" />
					</svg>
				</div>
				<h3 class="text-lg font-bold text-slate-950"><?php esc_html_e('Friendly Team', 'alupro-dynamic'); ?></h3>
				<p class="mt-2 leading-7 text-slate-500">
					<?php esc_html_e('Talk with real people who understand your needs.', 'alupro-dynamic'); ?>
				</p>
			</div>
		</div>
	</div>
</section>
<!-- Contact Page Ends -->
