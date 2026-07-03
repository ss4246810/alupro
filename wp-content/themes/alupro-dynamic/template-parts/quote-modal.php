<?php
/**
 * Quote/enquiry modal.
 *
 * @package AluProDynamic
 */

$enquiry_status = isset($_GET['alupro_enquiry']) ? sanitize_key(wp_unslash($_GET['alupro_enquiry'])) : '';
$redirect_to = remove_query_arg(array('alupro_subscribe', 'alupro_enquiry', 'alupro_contact'), add_query_arg(array()));
?>
<!-- Quote Modal Starts -->
<div
	id="quote-modal"
	class="fixed inset-0 z-[80] hidden items-center justify-center px-4 py-6"
	aria-labelledby="quote-modal-title"
	aria-modal="true"
	role="dialog"
>
	<button
		type="button"
		class="js-quote-modal-close absolute inset-0 cursor-default bg-[#09051F]/70 backdrop-blur-sm"
		aria-label="<?php esc_attr_e('Close quote request popup', 'alupro-dynamic'); ?>"
	></button>

	<div class="relative max-h-[calc(100vh-48px)] w-full max-w-3xl overflow-y-auto rounded-2xl bg-white px-6 py-8 shadow-[0_30px_90px_rgba(9,5,31,0.35)] sm:px-10 md:px-14 md:py-12">
		<button
			type="button"
			class="js-quote-modal-close absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-xl border border-[#190E5D]/10 bg-[#F8FAFC] text-[#190E5D] transition-all hover:border-[#00a2e0]/40 hover:bg-[#e6f6fc] hover:text-[#00a2e0] cursor-pointer"
			aria-label="<?php esc_attr_e('Close quote request popup', 'alupro-dynamic'); ?>"
		>
			<i class="fa-solid fa-xmark"></i>
		</button>

		<div class="max-w-2xl">
			<h2 id="quote-modal-title" class="pr-10 text-3xl font-extrabold leading-[1.08] text-black sm:text-4xl">
				<?php esc_html_e('Request a Quote for Aluminium Products', 'alupro-dynamic'); ?>
			</h2>
			<p class="mt-5 text-base leading-7 text-[#263B5E]">
				<?php esc_html_e('Tell us what you need - we reply within 2 hours during business hours.', 'alupro-dynamic'); ?>
			</p>
		</div>

		<?php if ('success' === $enquiry_status) : ?>
			<p class="mt-6 rounded-xl border border-[#00a2e0]/25 bg-[#EAF7FF] px-5 py-3 text-sm font-semibold text-[#0077AA]">
				<?php esc_html_e('Thank you. Your enquiry has been sent.', 'alupro-dynamic'); ?>
			</p>
		<?php elseif ('invalid' === $enquiry_status) : ?>
			<p class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700">
				<?php esc_html_e('Please provide your name, valid email address, and project details.', 'alupro-dynamic'); ?>
			</p>
		<?php elseif ('error' === $enquiry_status) : ?>
			<p class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700">
				<?php esc_html_e('The enquiry could not be sent. Please try again.', 'alupro-dynamic'); ?>
			</p>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="mt-8 grid gap-6">
			<input type="hidden" name="action" value="alupro_quote_enquiry">
			<input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>">
			<?php wp_nonce_field('alupro_quote_enquiry', 'alupro_quote_nonce'); ?>

			<div class="grid gap-6 md:grid-cols-2">
				<label class="sr-only" for="alupro_quote_name"><?php esc_html_e('Your Name', 'alupro-dynamic'); ?></label>
				<input
					id="alupro_quote_name"
					type="text"
					name="name"
					placeholder="<?php esc_attr_e('Your Name', 'alupro-dynamic'); ?>"
					required
					class="h-16 rounded-2xl border border-[#BFD0E4] bg-white px-7 text-sm text-[#111827] outline-none transition-all placeholder:text-[#8D98B3] focus:border-[#23AEEA] focus:ring-4 focus:ring-[#23AEEA]/15"
				>
				<label class="sr-only" for="alupro_quote_company"><?php esc_html_e('Company / Shipyard', 'alupro-dynamic'); ?></label>
				<input
					id="alupro_quote_company"
					type="text"
					name="company"
					placeholder="<?php esc_attr_e('Company / Shipyard', 'alupro-dynamic'); ?>"
					class="h-16 rounded-2xl border border-[#BFD0E4] bg-white px-7 text-sm text-[#111827] outline-none transition-all placeholder:text-[#8D98B3] focus:border-[#23AEEA] focus:ring-4 focus:ring-[#23AEEA]/15"
				>
				<label class="sr-only" for="alupro_quote_email"><?php esc_html_e('Email Address', 'alupro-dynamic'); ?></label>
				<input
					id="alupro_quote_email"
					type="email"
					name="email"
					placeholder="<?php esc_attr_e('Email Address', 'alupro-dynamic'); ?>"
					required
					class="h-16 rounded-2xl border border-[#BFD0E4] bg-white px-7 text-sm text-[#111827] outline-none transition-all placeholder:text-[#8D98B3] focus:border-[#23AEEA] focus:ring-4 focus:ring-[#23AEEA]/15"
				>
				<label class="sr-only" for="alupro_quote_phone"><?php esc_html_e('Phone', 'alupro-dynamic'); ?></label>
				<input
					id="alupro_quote_phone"
					type="tel"
					name="phone"
					placeholder="<?php esc_attr_e('Phone (+65)', 'alupro-dynamic'); ?>"
					class="h-16 rounded-2xl border border-[#BFD0E4] bg-white px-7 text-sm text-[#111827] outline-none transition-all placeholder:text-[#8D98B3] focus:border-[#23AEEA] focus:ring-4 focus:ring-[#23AEEA]/15"
				>
			</div>

			<label class="sr-only" for="alupro_quote_details"><?php esc_html_e('Project details', 'alupro-dynamic'); ?></label>
			<textarea
				id="alupro_quote_details"
				name="details"
				rows="6"
				placeholder="<?php esc_attr_e('Project details, aluminium grade, size, quantity...', 'alupro-dynamic'); ?>"
				required
				class="min-h-44 rounded-2xl border border-[#BFD0E4] bg-white px-7 py-6 text-sm text-[#111827] outline-none transition-all placeholder:text-[#8D98B3] focus:border-[#23AEEA] focus:ring-4 focus:ring-[#23AEEA]/15"
			></textarea>
			<input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" aria-hidden="true">

			<button
				type="submit"
				class="group flex h-16 items-center justify-center gap-3 rounded-2xl bg-[#190E5D] px-8 text-base font-extrabold uppercase tracking-wide text-white shadow-[0_14px_28px_rgba(25,14,93,0.24)] transition-all hover:-translate-y-0.5 hover:bg-[#0f083f] hover:shadow-[0_18px_34px_rgba(25,14,93,0.32)] cursor-pointer"
			>
				<?php esc_html_e('Send Request', 'alupro-dynamic'); ?>
				<i class="fa-solid fa-paper-plane text-xl text-[#00a2e0]"></i>
			</button>
		</form>
	</div>
</div>
<!-- Quote Modal Ends -->

<?php if ($enquiry_status) : ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var quoteModal = document.getElementById('quote-modal');
			if (!quoteModal) {
				return;
			}
			quoteModal.classList.remove('hidden');
			quoteModal.classList.add('flex');
			document.body.classList.add('overflow-hidden');
		});
	</script>
<?php endif; ?>
