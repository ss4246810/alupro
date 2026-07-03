<?php
/**
 * Newsletter subscription section.
 *
 * @package AluProDynamic
 */

$newsletter_status = isset($_GET['alupro_subscribe']) ? sanitize_key(wp_unslash($_GET['alupro_subscribe'])) : '';
$redirect_to = remove_query_arg(array('alupro_subscribe', 'alupro_enquiry', 'alupro_contact'), add_query_arg(array()));
?>
<!-- New Sub Footer Starts-->
<section class="relative overflow-hidden bg-[#F0F7FF] px-6 py-16 text-[#0E1B2E] md:py-20">
	<div class="absolute inset-0 opacity-[0.04]" style="background-image: repeating-linear-gradient(45deg, #00a2e0 0, #00a2e0 1px, transparent 0, transparent 50%); background-size: 20px 20px;"></div>
	<div class="relative mx-auto max-w-7xl text-center">
		<p class="text-sm font-bold uppercase tracking-[0.18em] text-[#0077AA]">
			<?php esc_html_e('Stay Informed', 'alupro-dynamic'); ?>
		</p>
		<h2 class="mt-4 text-2xl font-bold text-[#0E1B2E] sm:text-3xl">
			<?php esc_html_e('Stay updated with Alupro.', 'alupro-dynamic'); ?>
		</h2>
		<p class="mx-auto mt-4 max-w-xl text-base leading-8 text-[#4A5568]">
			<?php esc_html_e('Subscribe to receive the latest aluminium product news and exclusive offers', 'alupro-dynamic'); ?>
		</p>

		<?php if ('success' === $newsletter_status) : ?>
			<p class="mx-auto mt-5 max-w-xl rounded-xl border border-[#00a2e0]/25 bg-white px-5 py-3 text-sm font-semibold text-[#0077AA]">
				<?php esc_html_e('Thank you. Your subscription request has been sent.', 'alupro-dynamic'); ?>
			</p>
		<?php elseif ('invalid' === $newsletter_status) : ?>
			<p class="mx-auto mt-5 max-w-xl rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700">
				<?php esc_html_e('Please enter a valid email address.', 'alupro-dynamic'); ?>
			</p>
		<?php elseif ('error' === $newsletter_status) : ?>
			<p class="mx-auto mt-5 max-w-xl rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-700">
				<?php esc_html_e('The subscription could not be sent. Please try again.', 'alupro-dynamic'); ?>
			</p>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
			<input type="hidden" name="action" value="alupro_newsletter_subscribe">
			<input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>">
			<?php wp_nonce_field('alupro_newsletter_subscribe', 'alupro_newsletter_nonce'); ?>
			<label class="sr-only" for="alupro_subscriber_email"><?php esc_html_e('Email address', 'alupro-dynamic'); ?></label>
			<input
				id="alupro_subscriber_email"
				type="email"
				name="subscriber_email"
				placeholder="<?php esc_attr_e('Enter your email address', 'alupro-dynamic'); ?>"
				required
				class="flex-1 rounded-xl border border-[#CBD5E1] bg-white px-5 py-3.5 text-sm text-[#0E1B2E] placeholder-[#94A3B8] shadow-sm outline-none focus:border-[#00a2e0] focus:ring-2 focus:ring-[#00a2e0]/20"
			>
			<input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">
			<button
				type="submit"
				class="inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#00a2e0] px-7 py-3.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-[#00a2e0]/30 transition-all hover:-translate-y-0.5 hover:bg-[#0091c9]"
			>
				<?php esc_html_e('Subscribe', 'alupro-dynamic'); ?> <i class="fa-solid fa-paper-plane"></i>
			</button>
		</form>
	</div>
</section>
<!-- New Sub Footer Ends-->
