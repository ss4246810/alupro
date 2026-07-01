<?php
/**
 * Single Product template (Dynamic Table & PDF page).
 *
 * @package AluProDynamic
 */

wp_enqueue_script('html2pdf', 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js', array(), '0.10.1', true);

get_header();

// Helper to parse the Excel-pasted spreadsheet data
function alupro_parse_spreadsheet_table($table_data)
{
	if (empty($table_data)) {
		return array();
	}

	$lines = explode("\n", str_replace("\r", "", $table_data));
	$rows = array();

	foreach ($lines as $line) {
		$line = trim($line);
		if (empty($line)) {
			continue;
		}

		// Separate by tabs, pipes, or commas
		if (strpos($line, "\t") !== false) {
			$cells = explode("\t", $line);
		} elseif (strpos($line, "|") !== false) {
			$cells = explode("|", $line);
		} else {
			$cells = explode(",", $line);
		}

		$cells = array_map('trim', $cells);
		$rows[] = $cells;
	}

	return $rows;
}

// Helper to compute row spans dynamically
function alupro_compute_table_rowspans($rows)
{
	$processed_rows = array();
	$row_count = count($rows);
	if ($row_count === 0) {
		return $processed_rows;
	}

	$current_group_index = 0;
	$current_group_value = '';
	$current_group_rowspan = 0;

	for ($i = 0; $i < $row_count; $i++) {
		$row = $rows[$i];
		$first_cell = isset($row[0]) ? $row[0] : '';

		if ($first_cell !== '') {
			if ($current_group_rowspan > 0) {
				$processed_rows[$current_group_index]['rowspan'] = $current_group_rowspan;
			}
			$current_group_index = $i;
			$current_group_value = $first_cell;
			$current_group_rowspan = 1;

			$processed_rows[$i] = array(
				'is_first_of_group' => true,
				'value' => $first_cell,
				'cells' => array_slice($row, 1),
			);
		} else {
			$current_group_rowspan++;
			$processed_rows[$i] = array(
				'is_first_of_group' => false,
				'value' => $current_group_value,
				'cells' => array_slice($row, 1),
			);
		}
	}

	if ($current_group_rowspan > 0) {
		$processed_rows[$current_group_index]['rowspan'] = $current_group_rowspan;
	}

	return $processed_rows;
}

while (have_posts()):
	the_post();
	$pid = get_the_ID();

	// Fields
	$p_tempers = function_exists('get_field') ? get_field('product_tempers', $pid) : '';
	if (empty($p_tempers)) {
		$p_tempers = 'H116 | H321 | H111 | H112';
	}

	$p_certifications = function_exists('get_field') ? get_field('product_certifications', $pid) : '';
	if (empty($p_certifications)) {
		$p_certifications = 'Certified to: ASTM B928 (G66/G67 Tested) with ABS, BV, DNV and LR Cert.';
	}

	$p_image = function_exists('get_field') ? get_field('product_image', $pid) : '';
	if (empty($p_image)) {
		$p_image = get_the_post_thumbnail_url($pid, 'full');
	}
	if (empty($p_image)) {
		$p_image = get_theme_file_uri('images/plate-img.jpg');
	}

	$p_catalog_pdf = function_exists('get_field') ? get_field('product_catalog_pdf', $pid) : '';
	if (empty($p_catalog_pdf)) {
		$p_catalog_pdf = get_theme_file_uri('images/PDF-Design.pdf');
	}

	$p_table_headers = function_exists('get_field') ? get_field('product_table_headers', $pid) : '';
	if (empty($p_table_headers)) {
		$p_table_headers = 'Thickness, Width, Length';
	}
	$headers = array_map('trim', explode(',', $p_table_headers));

	$p_table_data = function_exists('get_field') ? get_field('product_table_data', $pid) : '';
	if (empty($p_table_data)) {
		// Default structure matching Marine Grade 5083 Aluminum
		$p_table_data = "3.0mm\t1220 mm\t2440 mm\n\t1500 mm\t6000 mm\n\t2000 mm\t6000 mm\n\t2200 mm\t9000 mm\n4.0mm\t1220 mm\t2440 mm\n\t1500 mm\t6000 mm\n\t2000 mm\t6000 mm\n\t2200 mm\t9000 mm\n4.5mm\t1220 mm\t2440 mm\n\t1500 mm\t6000 mm\n\t2000 mm\t6000 mm\n\t2200 mm\t9000 mm\n5.0mm\t1220 mm\t2440 mm\n\t1500 mm\t6000 mm\n\t2000 mm\t6000 mm\n\t2200 mm\t9000 mm\n6.0mm\t1220 mm\t2440 mm\n\t1500 mm\t6000 mm\n\t2000 mm\t6000 mm\n\t2200 mm\t9000 mm";
	}

	$raw_rows = alupro_parse_spreadsheet_table($p_table_data);
	$processed_rows = alupro_compute_table_rowspans($raw_rows);
	?>
	<main class="flex flex-col flex-1 w-full overflow-hidden">
		<section class="relative overflow-hidden bg-white px-6 py-16 md:py-24">
			<div class="relative mx-auto max-w-7xl">
				<div class="flex justify-end gap-4">
					<a href="<?php echo esc_url($p_catalog_pdf); ?>" download
						class="inline-flex w-fit cursor-pointer items-center gap-3 rounded-xl border border-[#190E5D]/20 bg-white px-6 py-4 text-sm font-bold uppercase tracking-wide text-[#190E5D] shadow-sm transition-all hover:bg-gray-50">
						Download Catalog
						<i class="fa-solid fa-download text-[#00a2e0]"></i>
					</a>
					<button type="button" id="downloadPdfBtn"
						class="inline-flex w-fit cursor-pointer items-center gap-3 rounded-xl bg-[#190E5D] px-6 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-[#190E5D]/20 transition-all hover:bg-[#0f083f]">
						Download Schedule
						<i class="fa-solid fa-file-pdf text-[#00a2e0]"></i>
					</button>
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
						<?php
						$editor_content = get_the_content();
						if (!empty(trim($editor_content))):
							echo apply_filters('the_content', $editor_content);
						else:
							?>
							<table class="w-full min-w-[560px] text-left">
								<thead class="bg-[#190E5D] text-white">
									<tr>
										<?php foreach ($headers as $header): ?>
											<th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.16em]">
												<?php echo esc_html($header); ?></th>
										<?php endforeach; ?>
									</tr>
								</thead>
								<tbody class="divide-y divide-[#190E5D]/10 text-sm">
									<?php
									$is_even_group = false;
									foreach ($processed_rows as $row):
										if ($row['is_first_of_group']) {
											$is_even_group = !$is_even_group;
										}
										$bg_class = $is_even_group ? 'bg-[#EAF7FF]' : 'bg-white';
										?>
										<tr class="<?php echo esc_attr($bg_class); ?>">
											<?php if ($row['is_first_of_group']): ?>
												<td rowspan="<?php echo esc_attr($row['rowspan']); ?>"
													class="px-5 py-3 align-top text-base font-bold text-[#180f5e] <?php echo esc_attr($bg_class); ?>">
													<?php echo esc_html($row['value']); ?>
												</td>
											<?php endif; ?>
											<?php foreach ($row['cells'] as $cell): ?>
												<td class="px-5 py-3 text-sm font-normal text-[#4B5563]">
													<?php echo esc_html($cell); ?>
												</td>
											<?php endforeach; ?>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>
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

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const downloadBtn = document.getElementById("downloadPdfBtn");
			if (downloadBtn) {
				downloadBtn.addEventListener("click", function (e) {
					const btn = e.currentTarget;
					if (typeof html2pdf === "undefined") {
						alert("PDF library failed to load. Check your internet connection and try again.");
						return;
					}
					const originalText = btn.innerHTML;
					btn.disabled = true;
					btn.innerHTML = "Generating PDF...";
					html2pdf()
						.from(document.querySelector(".html-to-pdf"))
						.set({
							margin: 10,
							filename: "<?php echo sanitize_title(get_the_title()); ?>-schedule.pdf",
							image: { type: "jpeg", quality: 0.98 },
							html2canvas: { scale: 1.5, useCORS: true, windowWidth: 900 },
							jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
							pagebreak: { mode: ["avoid-all", "css", "legacy"], avoid: "tr" },
						})
						.save()
						.catch(function (err) {
							console.error("PDF generation failed:", err);
							alert("Could not generate the PDF. Open the browser console (F12) for details.");
						})
						.finally(function () {
							btn.disabled = false;
							btn.innerHTML = originalText;
						});
				});
			}
		});
	</script>
	<?php
endwhile;

get_footer();
