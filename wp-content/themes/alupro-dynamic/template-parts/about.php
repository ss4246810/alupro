<?php
/**
 * Home/about section.
 *
 * @package AluProDynamic
 */
?>
<!-- About Section Starts -->
<section class="relative overflow-hidden bg-[#F8FAFC] px-6 py-20 md:py-28">
	<div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#190E5D]/20 to-transparent"></div>
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 xl:gap-16 items-center">
			<div>
				<span class="inline-flex items-center gap-2 rounded-full border border-[#00a2e0]/30 bg-[#e6f6fc] px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#1687C7]">
					<i class="fa-solid fa-circle-info"></i>About Us
				</span>

				<h2 class="mt-6 text-3xl font-extrabold leading-tight text-[#111827] sm:text-4xl">
					AluPro <span class="text-[#1687C7]">Alloy Solutions</span>
				</h2>
				<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0]"></div>

				<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-base">
					<b class="text-black font-bold">AluPro Alloy Solutions Pte Ltd</b> is a Singapore-based stockholder and distributor of certified marine-grade Aluminium Alloys. With over <b class="text-black font-bold">15 years of industry experience</b>, we are guided by our motto, "Excellence in Aluminium Distribution", serving the marine, shipbuilding, offshore, and engineering sectors across Southeast Asia and beyond.
				</p>
				<p class="mt-7 text-base leading-8 text-[#4B5563] md:text-base">
					Sourced from established global manufacturers, our alloys offer excellent strength-to-weight performance and corrosion resistance for shipbuilding, offshore structures, naval vessels, luxury yachts, and precision engineering.
				</p>

				<div class="mt-7 flex flex-wrap gap-3">
					<span class="rounded-full border border-[#00a2e0]/30 bg-white px-4 py-2 text-sm font-semibold text-[#1687C7]">ABS</span>
					<span class="rounded-full border border-[#00a2e0]/30 bg-white px-4 py-2 text-sm font-semibold text-[#1687C7]">Bureau Veritas</span>
					<span class="rounded-full border border-[#00a2e0]/30 bg-white px-4 py-2 text-sm font-semibold text-[#1687C7]">DNV</span>
					<span class="rounded-full border border-[#00a2e0]/30 bg-white px-4 py-2 text-sm font-semibold text-[#1687C7]">Lloyd's Register</span>
				</div>
			</div>

			<div class="relative">
				<img
					src="<?php echo esc_url(get_theme_file_uri('images/marine-img-2.webp')); ?>"
					alt="<?php esc_attr_e('Shipbuilding aluminium structure', 'alupro-dynamic'); ?>"
					class="w-full h-[360px] lg:h-[420px] object-cover rounded-2xl shadow-xl"
				>
			</div>
		</div>

		<div class="mt-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center lg:border-b-0">
				<span class="text-3xl font-extrabold text-[#190E5D]">15+</span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500">Years Experience</span>
			</div>
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center sm:border-l lg:border-b-0 lg:border-l-0">
				<span class="text-3xl font-extrabold text-[#190E5D]">15+</span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500">Alloy Grades Supplies</span>
			</div>
			<div class="flex flex-col items-center border-b border-[#190E5D]/10 py-4 px-4 text-center sm:border-b-0">
				<span class="text-3xl font-extrabold text-[#190E5D]">4+</span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500">Class Approvals</span>
			</div>
			<div class="flex flex-col items-center border-[#190E5D]/10 py-4 px-4 text-center sm:border-l lg:border-l-0">
				<span class="text-3xl font-extrabold text-[#190E5D]">100%</span>
				<span class="mt-2 text-xs font-semibold uppercase tracking-widest text-gray-500">Material Traceability</span>
			</div>
		</div>

		<div class="mt-16 grid overflow-hidden rounded-2xl border border-[#190E5D]/10 bg-white shadow-[0_24px_70px_rgba(17,24,39,0.08)] md:grid-cols-3">
			<div class="group flex flex-col lg:flex-row gap-6 p-8 transition-colors md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#190E5D] text-white shadow-lg shadow-[#190E5D]/20">
					<i class="fa-solid fa-ship text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						Marine &amp; Shipbuilding Aluminium
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>

			<div class="group flex flex-col lg:flex-row gap-6 border-t border-[#190E5D]/10 p-8 transition-colors md:border-l md:border-t-0 md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#00a2e0] text-white shadow-lg shadow-[#00a2e0]/20">
					<i class="fa-solid fa-gears text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						Precision Engineering &amp; Aerospace Materials
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#190E5D] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>

			<div class="group flex flex-col lg:flex-row gap-6 border-t border-[#190E5D]/10 p-8 transition-colors md:border-l md:border-t-0 md:p-10">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#111827] text-white shadow-lg shadow-[#111827]/20">
					<i class="fa-solid fa-certificate text-xl"></i>
				</div>
				<div>
					<p class="text-lg font-extrabold leading-snug text-[#111827]">
						Certified Quality &amp; Full Traceability
					</p>
					<div class="mt-5 h-1 w-16 rounded-full bg-[#00a2e0] transition-all duration-300 group-hover:w-24"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About Section Ends -->
