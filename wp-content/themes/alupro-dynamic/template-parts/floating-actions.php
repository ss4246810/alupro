<?php
/**
 * Floating WhatsApp and scroll-to-top actions.
 *
 * @package AluProDynamic
 */

$whatsapp_url = 'https://wa.me/6588987720';
?>
<!-- whatsapp starts -->
<a
	id="whatsappBtn"
	href="<?php echo esc_url($whatsapp_url); ?>"
	target="_blank"
	rel="noopener noreferrer"
	style="bottom:1rem; transition: bottom 0.3s ease;"
	class="fixed right-4 z-51 flex items-center justify-center w-12 h-12 rounded-full drop-shadow-[0_4px_6px_rgba(0,0,0,0.3)] hover:drop-shadow-[0_6px_10px_rgba(0,0,0,0.45)]"
	title="<?php esc_attr_e('Chat with us on WhatsApp', 'alupro-dynamic'); ?>"
>
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48" aria-hidden="true" focusable="false">
		<circle cx="24" cy="24" r="24" fill="#25D366"/>
		<path fill="#fff" d="M24 10C16.27 10 10 16.27 10 24c0 2.52.68 4.88 1.86 6.91L10 38l7.32-1.82A13.93 13.93 0 0 0 24 38c7.73 0 14-6.27 14-14S31.73 10 24 10zm7.27 19.39c-.31.87-1.82 1.66-2.5 1.73-.65.07-1.27.29-4.27-1.11-3.59-1.68-5.9-5.34-6.08-5.59-.18-.25-1.45-1.93-1.45-3.68s.92-2.61 1.25-2.97c.31-.34.68-.43.91-.43.23 0 .45.01.65.01.21.01.49-.08.77.58.31.71 1.04 2.52 1.13 2.7.09.18.15.39.03.63-.12.24-.18.39-.35.6-.18.21-.37.47-.53.63-.18.18-.36.37-.16.73.21.36.92 1.52 1.98 2.46 1.36 1.21 2.5 1.59 2.86 1.77.36.18.57.15.78-.09.21-.24.9-1.05 1.14-1.41.24-.36.48-.3.81-.18.33.12 2.1 .99 2.46 1.17.36.18.6.27.69.42.09.16.09.91-.22 1.78z"/>
	</svg>
</a>
<!-- whatsapp ends -->

<!-- Scroll Top Custom Starts-->
<button
	id="scrollToTopBtn"
	type="button"
	style="display:none;"
	class="bg-gradient-to-br from-[#00a2e0] to-[#1687C7] hover:from-[#1687C7] hover:to-[#00a2e0] text-white px-3 py-3 rounded-full transition-all duration-300 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)] hover:drop-shadow-[0_8px_8px_rgba(0,0,0,0.7)] fixed bottom-4 right-4 z-50 cursor-pointer"
	aria-label="<?php esc_attr_e('Scroll to top', 'alupro-dynamic'); ?>"
>
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" class="lucide lucide-arrow-up-icon lucide-arrow-up">
		<path d="m5 12 7-7 7 7"/>
		<path d="M12 19V5"/>
	</svg>
</button>
<!-- Scroll Top Custom Ends-->
