<?php
/**
 * Single Product template (Dynamic Table & PDF page).
 *
 * @package AluProDynamic
 */

get_header();

while (have_posts()):
	the_post();
	$pid = get_the_ID();
	$schedule = alupro_get_product_schedule_data($pid);
	$p_tempers = $schedule['tempers'];
	$p_certifications = $schedule['certifications'];
	$p_image = $schedule['image'];
	$p_schedule_pdf = alupro_get_product_schedule_pdf_url($pid);
	?>
	<main class="flex flex-col flex-1 w-full overflow-hidden">
		<section class="relative overflow-hidden bg-white px-6 py-16 md:py-24">
			<div class="relative mx-auto max-w-7xl">
				<div class="flex justify-end gap-4">
					<a href="<?php echo esc_url($p_schedule_pdf); ?>" download
						class="inline-flex w-fit cursor-pointer items-center gap-3 rounded-xl bg-[#190E5D] px-6 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-[#190E5D]/20 transition-all hover:bg-[#0f083f]">
						Download PDF
						<i class="fa-solid fa-file-pdf text-[#00a2e0]"></i>
					</a>
				</div>

				<div
					class="html-to-pdf mt-8 overflow-hidden rounded-2xl border border-[#190E5D]/10 bg-white shadow-[0_20px_55px_rgba(17,24,39,0.07)]">
					<div
						class="flex flex-col gap-6 border-b border-[#190E5D]/10 px-5 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-7">
						<div class="flex items-center gap-4 sm:gap-8">
							<img src="<?php echo esc_url(get_theme_file_uri('images/logo-colored.svg')); ?>"
								alt="AluPro Logo" class="h-16 w-auto shrink-0 sm:h-24" />
							<div>
								<h3 class="text-lg font-extrabold text-[#111827] sm:text-xl lg:text-2xl">
									<?php the_title(); ?>
								</h3>
								<p class="mt-1 text-sm text-[#4B5563]">
									Tempers: <?php echo esc_html($p_tempers); ?>
								</p>
								<p class="mt-1 text-sm text-[#4B5563]">
									<?php echo esc_html($p_certifications); ?>
								</p>
							</div>
						</div>
						<img src="<?php echo esc_url($p_image); ?>" alt="<?php the_title_attribute(); ?>"
							class="h-28 w-40 shrink-0 self-center rounded-xl object-cover sm:h-32 sm:w-48 sm:self-auto" />
					</div>
					<div class="overflow-x-auto">
						<?php echo alupro_render_product_schedule_table($schedule); ?>
					</div>
				</div>

				<div class="mt-8 rounded-2xl border border-[#190E5D]/10 bg-[#F8FAFC] px-7 py-6">
					<h3 class="text-base font-extrabold uppercase tracking-widest text-[#111827]">
						Custom & Indent Items
					</h3>
					<p class="mt-3 text-sm leading-7 text-[#4B5563]">
						Dimensions not listed above and items marked Indent are
						available via mill / works production on a made-to-order
						basis. Subject to minimum order quantities (MOQ).
					</p>
				</div>
			</div>
		</section>
	</main>

	<?php
	endwhile;

get_footer();
