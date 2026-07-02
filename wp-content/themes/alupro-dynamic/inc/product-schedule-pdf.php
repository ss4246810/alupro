<?php
/**
 * Dynamic product schedule table and PDF generation.
 *
 * @package AluProDynamic
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('alupro_parse_spreadsheet_table')) {
	function alupro_parse_spreadsheet_table($table_data)
	{
		if (empty($table_data)) {
			return array();
		}

		$lines = explode("\n", str_replace("\r", '', (string) $table_data));
		$rows = array();

		foreach ($lines as $line) {
			$line = rtrim($line);

			if ('' === trim($line)) {
				continue;
			}

			if (false !== strpos($line, "\t")) {
				$cells = explode("\t", $line);
			} elseif (false !== strpos($line, '|')) {
				$cells = explode('|', $line);
			} else {
				$cells = str_getcsv($line);
			}

			$rows[] = array_map('trim', $cells);
		}

		return $rows;
	}
}

if (!function_exists('alupro_compute_table_rowspans')) {
	function alupro_compute_table_rowspans($rows)
	{
		$processed_rows = array();
		$current_group_index = null;
		$current_group_value = '';
		$current_group_rowspan = 0;

		foreach ($rows as $index => $row) {
			$first_cell = isset($row[0]) ? trim((string) $row[0]) : '';

			if ('' !== $first_cell || null === $current_group_index) {
				if (null !== $current_group_index) {
					$processed_rows[$current_group_index]['rowspan'] = $current_group_rowspan;
				}

				$current_group_index = $index;
				$current_group_value = $first_cell;
				$current_group_rowspan = 1;

				$processed_rows[$index] = array(
					'is_first_of_group' => true,
					'value' => $first_cell,
					'cells' => array_slice($row, 1),
					'rowspan' => 1,
				);
			} else {
				$current_group_rowspan++;
				$processed_rows[$index] = array(
					'is_first_of_group' => false,
					'value' => $current_group_value,
					'cells' => array_slice($row, 1),
					'rowspan' => 1,
				);
			}
		}

		if (null !== $current_group_index) {
			$processed_rows[$current_group_index]['rowspan'] = $current_group_rowspan;
		}

		return $processed_rows;
	}
}

function alupro_dynamic_default_schedule_table_data()
{
	return implode(
		"\n",
		array(
			"3.0mm\t1220mm\t2440mm\tStock",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
			"4.0mm\t1220mm\t2440mm\tStock",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
			"4.5mm\t1220mm\t2440mm\tIndent",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
			"5.0mm\t1220mm\t2440mm\tStock",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
			"6.0mm\t1220mm\t2440mm\tStock",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
			"7.0mm\t1220mm\t2440mm\tIndent",
			"\t1500mm\t6000mm\tStock",
			"\t2000mm\t6000mm\tStock",
			"\t2200mm\t9000mm\tIndent",
		)
	);
}

function alupro_dynamic_parse_schedule_headers($headers)
{
	$headers = trim((string) $headers);

	if ('' === $headers) {
		return array();
	}

	if (false !== strpos($headers, "\t")) {
		$parsed = explode("\t", $headers);
	} elseif (false !== strpos($headers, '|')) {
		$parsed = explode('|', $headers);
	} else {
		$parsed = str_getcsv($headers);
	}

	return array_map('trim', $parsed);
}

function alupro_dynamic_normalize_schedule_rows($rows, $column_count)
{
	$normalized = array();

	foreach ($rows as $row) {
		$row = array_values(array_map('trim', array_map('strval', $row)));

		if (count($row) < $column_count) {
			$row = array_pad($row, $column_count, '');
		}

		$normalized[] = array_slice($row, 0, $column_count);
	}

	return $normalized;
}

function alupro_dynamic_table_max_columns($rows)
{
	$max = 0;

	foreach ($rows as $row) {
		$max = max($max, count($row));
	}

	return $max;
}

function alupro_dynamic_dom_cell_text($cell)
{
	$text = html_entity_decode($cell->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$text = preg_replace('/\s+/u', ' ', $text);

	return trim($text);
}

function alupro_dynamic_extract_editor_schedule_table($content)
{
	$content = trim((string) $content);

	if ('' === $content || false === stripos($content, '<table')) {
		return array(
			'headers' => array(),
			'rows' => array(),
		);
	}

	$dom = new DOMDocument();
	$previous = libxml_use_internal_errors(true);
	$dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $content . '</div>');
	libxml_clear_errors();
	libxml_use_internal_errors($previous);

	$tables = $dom->getElementsByTagName('table');

	if (0 === $tables->length) {
		return array(
			'headers' => array(),
			'rows' => array(),
		);
	}

	$table = $tables->item(0);
	$all_rows = array();

	foreach ($table->getElementsByTagName('tr') as $tr) {
		$cells = array();
		$has_header_cell = false;

		foreach ($tr->childNodes as $node) {
			if (XML_ELEMENT_NODE !== $node->nodeType) {
				continue;
			}

			$name = strtolower($node->nodeName);

			if ('th' !== $name && 'td' !== $name) {
				continue;
			}

			if ('th' === $name) {
				$has_header_cell = true;
			}

			$cells[] = array(
				'text' => alupro_dynamic_dom_cell_text($node),
				'rowspan' => max(1, (int) $node->getAttribute('rowspan')),
			);
		}

		if (!empty($cells)) {
			$all_rows[] = array(
				'cells' => $cells,
				'is_header' => $has_header_cell,
			);
		}
	}

	$headers = array();
	$body_rows = array();
	$header_consumed = false;
	$span_remaining = 0;

	foreach ($all_rows as $row) {
		if (!$header_consumed && $row['is_header']) {
			foreach ($row['cells'] as $cell) {
				$headers[] = $cell['text'];
			}

			$header_consumed = true;
			continue;
		}

		$text_cells = array();

		foreach ($row['cells'] as $cell) {
			$text_cells[] = $cell['text'];
		}

		if ($span_remaining > 0) {
			array_unshift($text_cells, '');
			$span_remaining--;
		} elseif (!empty($row['cells'])) {
			$span_remaining = max(0, (int) $row['cells'][0]['rowspan'] - 1);
		}

		$body_rows[] = $text_cells;
	}

	return array(
		'headers' => $headers,
		'rows' => $body_rows,
	);
}

function alupro_get_product_schedule_data($post_id)
{
	$post_id = absint($post_id);
	$title = get_the_title($post_id);

	$tempers = function_exists('get_field') ? get_field('product_tempers', $post_id) : '';
	if (empty($tempers)) {
		$tempers = 'H116 | H321 | H111 | H112';
	}

	$certifications = function_exists('get_field') ? get_field('product_certifications', $post_id) : '';
	if (empty($certifications)) {
		$certifications = 'Certified to: ASTM B928 (G66/G67 Tested) with ABS, BV, DNV and LR Cert.';
	}

	$image = function_exists('get_field') ? get_field('product_image', $post_id) : '';
	if (empty($image)) {
		$image = get_the_post_thumbnail_url($post_id, 'full');
	}
	if (empty($image)) {
		$image = get_theme_file_uri('images/plate-img.jpg');
	}

	$catalog_pdf = function_exists('get_field') ? get_field('product_catalog_pdf', $post_id) : '';
	if (empty($catalog_pdf)) {
		$catalog_pdf = get_theme_file_uri('images/PDF-Design.pdf');
	}

	$headers = function_exists('get_field') ? get_field('product_table_headers', $post_id) : '';
	$headers = alupro_dynamic_parse_schedule_headers($headers);
	if (empty($headers)) {
		$headers = array('Thickness', 'Width', 'Length', 'Availability');
	}

	$table_data = function_exists('get_field') ? get_field('product_table_data', $post_id) : '';
	$source = 'acf';

	if ('' !== trim((string) $table_data)) {
		$raw_rows = alupro_parse_spreadsheet_table($table_data);
	} else {
		$editor_table = alupro_dynamic_extract_editor_schedule_table(get_post_field('post_content', $post_id));

		if (!empty($editor_table['rows'])) {
			$raw_rows = $editor_table['rows'];
			$source = 'editor';

			if (!empty($editor_table['headers'])) {
				$headers = $editor_table['headers'];
			}
		} else {
			$raw_rows = alupro_parse_spreadsheet_table(alupro_dynamic_default_schedule_table_data());
			$source = 'default';
		}
	}

	$column_count = max(count($headers), alupro_dynamic_table_max_columns($raw_rows));

	if ($column_count < 1) {
		$column_count = 1;
	}

	for ($i = count($headers); $i < $column_count; $i++) {
		$headers[] = sprintf(__('Column %d', 'alupro-dynamic'), $i + 1);
	}

	$headers = array_slice($headers, 0, $column_count);
	$raw_rows = alupro_dynamic_normalize_schedule_rows($raw_rows, $column_count);
	$processed_rows = alupro_compute_table_rowspans($raw_rows);

	return array(
		'post_id' => $post_id,
		'title' => $title,
		'tempers' => $tempers,
		'certifications' => $certifications,
		'image' => $image,
		'catalog_pdf' => $catalog_pdf,
		'headers' => $headers,
		'rows' => $raw_rows,
		'processed_rows' => $processed_rows,
		'source' => $source,
	);
}

function alupro_get_product_schedule_pdf_url($post_id)
{
	return add_query_arg(
		array(
			'alupro_schedule_pdf' => absint($post_id),
		),
		home_url('/')
	);
}

function alupro_render_product_schedule_table($schedule)
{
	$headers = isset($schedule['headers']) ? $schedule['headers'] : array();
	$processed_rows = isset($schedule['processed_rows']) ? $schedule['processed_rows'] : array();
	$column_count = max(1, count($headers));

	ob_start();
	?>
	<table class="w-full min-w-[560px] text-left">
		<thead class="bg-[#190E5D] text-white">
			<tr>
				<?php foreach ($headers as $header): ?>
					<th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.16em]">
						<?php echo esc_html($header); ?>
					</th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody class="divide-y divide-[#190E5D]/10 text-sm">
			<?php if (empty($processed_rows)): ?>
				<tr>
					<td colspan="<?php echo esc_attr($column_count); ?>" class="px-5 py-4 text-sm text-[#4B5563]">
						<?php esc_html_e('No schedule rows have been added yet.', 'alupro-dynamic'); ?>
					</td>
				</tr>
			<?php else: ?>
				<?php
				$is_even_group = false;

				foreach ($processed_rows as $row):
					if (!empty($row['is_first_of_group'])) {
						$is_even_group = !$is_even_group;
					}

					$bg_class = $is_even_group ? 'bg-[#EAF7FF]' : 'bg-white';
					$cells = isset($row['cells']) ? array_values($row['cells']) : array();
					$cells = array_pad(array_slice($cells, 0, max(0, $column_count - 1)), max(0, $column_count - 1), '');
					?>
					<tr class="<?php echo esc_attr($bg_class); ?>">
						<?php if (!empty($row['is_first_of_group'])): ?>
							<td rowspan="<?php echo esc_attr($row['rowspan']); ?>"
								class="px-5 py-3 align-top text-base font-bold text-[#180f5e] <?php echo esc_attr($bg_class); ?>">
								<?php echo esc_html($row['value']); ?>
							</td>
						<?php endif; ?>
						<?php foreach ($cells as $cell): ?>
							<td class="px-5 py-3 text-sm font-normal text-[#4B5563]">
								<?php echo esc_html($cell); ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<?php
	return ob_get_clean();
}

if (!class_exists('AluPro_Dynamic_Pdf_Document')) {
	class AluPro_Dynamic_Pdf_Document
	{
		private $width = 595.44;
		private $height = 841.68;
		private $pages = array();
		private $content = '';

		public function add_page()
		{
			if ('' !== $this->content) {
				$this->pages[] = $this->content;
			}

			$this->content = '';
		}

		public function page_width()
		{
			return $this->width;
		}

		public function page_height()
		{
			return $this->height;
		}

		public function rect($x, $y, $w, $h, $fill = null, $stroke = null, $line_width = 0.5)
		{
			$bottom = $this->height - $y - $h;
			$op = $fill && $stroke ? 'B' : ($fill ? 'f' : 'S');
			$command = 'q ' . $this->format_number($line_width) . ' w ';

			if ($fill) {
				$command .= $this->color_command($fill, false) . ' ';
			}

			if ($stroke) {
				$command .= $this->color_command($stroke, true) . ' ';
			}

			$command .= $this->format_number($x) . ' ' . $this->format_number($bottom) . ' ' . $this->format_number($w) . ' ' . $this->format_number($h) . ' re ' . $op . ' Q' . "\n";
			$this->content .= $command;
		}

		public function rounded_rect($x, $y, $w, $h, $r, $fill = null, $stroke = null, $line_width = 0.5)
		{
			$x0 = $x;
			$x1 = $x + $w;
			$y0 = $this->height - $y - $h;
			$y1 = $this->height - $y;
			$k = 0.5522847498;
			$c = $r * $k;
			$op = $fill && $stroke ? 'B' : ($fill ? 'f' : 'S');
			$command = 'q ' . $this->format_number($line_width) . ' w ';

			if ($fill) {
				$command .= $this->color_command($fill, false) . ' ';
			}

			if ($stroke) {
				$command .= $this->color_command($stroke, true) . ' ';
			}

			$command .= $this->format_number($x0 + $r) . ' ' . $this->format_number($y0) . ' m ';
			$command .= $this->format_number($x1 - $r) . ' ' . $this->format_number($y0) . ' l ';
			$command .= $this->format_number($x1 - $r + $c) . ' ' . $this->format_number($y0) . ' ' . $this->format_number($x1) . ' ' . $this->format_number($y0 + $r - $c) . ' ' . $this->format_number($x1) . ' ' . $this->format_number($y0 + $r) . ' c ';
			$command .= $this->format_number($x1) . ' ' . $this->format_number($y1 - $r) . ' l ';
			$command .= $this->format_number($x1) . ' ' . $this->format_number($y1 - $r + $c) . ' ' . $this->format_number($x1 - $r + $c) . ' ' . $this->format_number($y1) . ' ' . $this->format_number($x1 - $r) . ' ' . $this->format_number($y1) . ' c ';
			$command .= $this->format_number($x0 + $r) . ' ' . $this->format_number($y1) . ' l ';
			$command .= $this->format_number($x0 + $r - $c) . ' ' . $this->format_number($y1) . ' ' . $this->format_number($x0) . ' ' . $this->format_number($y1 - $r + $c) . ' ' . $this->format_number($x0) . ' ' . $this->format_number($y1 - $r) . ' c ';
			$command .= $this->format_number($x0) . ' ' . $this->format_number($y0 + $r) . ' l ';
			$command .= $this->format_number($x0) . ' ' . $this->format_number($y0 + $r - $c) . ' ' . $this->format_number($x0 + $r - $c) . ' ' . $this->format_number($y0) . ' ' . $this->format_number($x0 + $r) . ' ' . $this->format_number($y0) . ' c h ' . $op . ' Q' . "\n";

			$this->content .= $command;
		}

		public function line($x1, $y1, $x2, $y2, $color = '#d9dce1', $line_width = 0.5)
		{
			$this->content .= 'q ' . $this->format_number($line_width) . ' w ' . $this->color_command($color, true) . ' ' . $this->format_number($x1) . ' ' . $this->format_number($this->height - $y1) . ' m ' . $this->format_number($x2) . ' ' . $this->format_number($this->height - $y2) . ' l S Q' . "\n";
		}

		public function text($x, $y, $text, $size = 10, $bold = false, $color = '#111827', $align = 'left')
		{
			$text = $this->clean_text($text);
			$width = $this->text_width($text, $size, $bold);

			if ('center' === $align) {
				$x -= $width / 2;
			} elseif ('right' === $align) {
				$x -= $width;
			}

			$font = $bold ? '/F2' : '/F1';
			$this->content .= 'BT ' . $this->color_command($color, false) . ' ' . $font . ' ' . $this->format_number($size) . ' Tf 1 0 0 1 ' . $this->format_number($x) . ' ' . $this->format_number($this->height - $y) . ' Tm (' . $this->escape_text($text) . ') Tj ET' . "\n";
		}

		public function wrapped_text($x, $y, $text, $max_width, $size = 10, $bold = false, $color = '#111827', $line_height = 12, $max_lines = 0)
		{
			$lines = $this->wrap_lines($text, $max_width, $size, $bold);

			if ($max_lines > 0 && count($lines) > $max_lines) {
				$lines = array_slice($lines, 0, $max_lines);
				$last = count($lines) - 1;
				$lines[$last] = $this->fit_text(rtrim($lines[$last]) . '...', $max_width, $size, $bold);
			}

			foreach ($lines as $index => $line) {
				$this->text($x, $y + ($index * $line_height), $line, $size, $bold, $color);
			}

			return count($lines) * $line_height;
		}

		public function fit_text($text, $max_width, $size = 10, $bold = false)
		{
			$text = $this->clean_text($text);

			if ($this->text_width($text, $size, $bold) <= $max_width) {
				return $text;
			}

			while (strlen($text) > 3 && $this->text_width($text . '...', $size, $bold) > $max_width) {
				$text = substr($text, 0, -1);
			}

			return rtrim($text) . '...';
		}

		public function output()
		{
			if ('' !== $this->content) {
				$this->pages[] = $this->content;
				$this->content = '';
			}

			$objects = array(
				1 => '<< /Type /Catalog /Pages 2 0 R >>',
				3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>',
				4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>',
			);
			$page_object_numbers = array();
			$object_number = 5;

			foreach ($this->pages as $content) {
				$content_object = $object_number++;
				$page_object = $object_number++;
				$objects[$content_object] = '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . "endstream";
				$objects[$page_object] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . $this->format_number($this->width) . ' ' . $this->format_number($this->height) . '] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents ' . $content_object . ' 0 R >>';
				$page_object_numbers[] = $page_object . ' 0 R';
			}

			$objects[2] = '<< /Type /Pages /Kids [' . implode(' ', $page_object_numbers) . '] /Count ' . count($page_object_numbers) . ' >>';
			ksort($objects);

			$pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
			$offsets = array(0);

			foreach ($objects as $number => $object) {
				$offsets[$number] = strlen($pdf);
				$pdf .= $number . " 0 obj\n" . $object . "\nendobj\n";
			}

			$xref_offset = strlen($pdf);
			$count = max(array_keys($objects)) + 1;
			$pdf .= "xref\n0 " . $count . "\n";
			$pdf .= "0000000000 65535 f \n";

			for ($i = 1; $i < $count; $i++) {
				$pdf .= sprintf("%010d 00000 n \n", isset($offsets[$i]) ? $offsets[$i] : 0);
			}

			$pdf .= "trailer\n<< /Size " . $count . " /Root 1 0 R >>\nstartxref\n" . $xref_offset . "\n%%EOF";

			return $pdf;
		}

		private function wrap_lines($text, $max_width, $size, $bold)
		{
			$text = $this->clean_text($text);
			$words = preg_split('/\s+/', $text);
			$lines = array();
			$current = '';

			foreach ($words as $word) {
				$test = '' === $current ? $word : $current . ' ' . $word;

				if ($this->text_width($test, $size, $bold) <= $max_width) {
					$current = $test;
					continue;
				}

				if ('' !== $current) {
					$lines[] = $current;
				}

				$current = $word;
			}

			if ('' !== $current) {
				$lines[] = $current;
			}

			return empty($lines) ? array('') : $lines;
		}

		private function text_width($text, $size, $bold)
		{
			$text = $this->clean_text($text);
			$factor = $bold ? 0.5 : 0.45;

			return strlen($text) * $size * $factor;
		}

		private function clean_text($text)
		{
			$text = html_entity_decode(wp_strip_all_tags((string) $text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
			$text = str_replace(
				array("\r", "\n", '•', '–', '—', '“', '”', '’', '‘'),
				array(' ', ' ', '-', '-', '-', '"', '"', "'", "'"),
				$text
			);
			$text = preg_replace('/\s+/', ' ', $text);
			$text = trim($text);

			if (function_exists('iconv')) {
				$encoded = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);

				if (false !== $encoded) {
					$text = $encoded;
				}
			}

			return $text;
		}

		private function escape_text($text)
		{
			return str_replace(
				array('\\', '(', ')'),
				array('\\\\', '\\(', '\\)'),
				$text
			);
		}

		private function color_command($hex, $stroke)
		{
			$hex = ltrim((string) $hex, '#');

			if (3 === strlen($hex)) {
				$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
			}

			$r = hexdec(substr($hex, 0, 2)) / 255;
			$g = hexdec(substr($hex, 2, 2)) / 255;
			$b = hexdec(substr($hex, 4, 2)) / 255;

			return $this->format_number($r) . ' ' . $this->format_number($g) . ' ' . $this->format_number($b) . ($stroke ? ' RG' : ' rg');
		}

		private function format_number($number)
		{
			return rtrim(rtrim(sprintf('%.3F', $number), '0'), '.');
		}
	}
}

function alupro_dynamic_pdf_table_rows($schedule)
{
	$rows = array();
	$column_count = max(1, count($schedule['headers']));

	foreach ($schedule['processed_rows'] as $row) {
		$cells = array(!empty($row['is_first_of_group']) ? $row['value'] : '');
		$cells = array_merge($cells, isset($row['cells']) ? $row['cells'] : array());
		$cells = array_pad(array_slice($cells, 0, $column_count), $column_count, '');
		$rows[] = $cells;
	}

	return $rows;
}

function alupro_dynamic_pdf_column_widths($column_count, $table_width)
{
	if ($column_count <= 1) {
		return array($table_width);
	}

	if (4 === $column_count) {
		return array(145, 110, 120, $table_width - 375);
	}

	$first = min(150, max(90, $table_width * 0.28));
	$remaining = ($table_width - $first) / ($column_count - 1);
	$widths = array($first);

	for ($i = 1; $i < $column_count; $i++) {
		$widths[] = $remaining;
	}

	return $widths;
}

function alupro_dynamic_pdf_is_availability_value($value)
{
	$value = strtolower(trim((string) $value));

	return in_array($value, array('stock', 'in stock', 'available', 'indent', 'made to order', 'out of stock'), true);
}

function alupro_dynamic_pdf_draw_badge($pdf, $x, $y, $w, $value)
{
	$normalized = strtolower(trim((string) $value));

	if (in_array($normalized, array('stock', 'in stock', 'available'), true)) {
		$fill = '#d9fbe8';
		$stroke = '#93e0b1';
		$text = '#008a44';
		$label = 'available' === $normalized ? 'Available' : 'Stock';
	} elseif ('out of stock' === $normalized) {
		$fill = '#fee2e2';
		$stroke = '#fca5a5';
		$text = '#b91c1c';
		$label = 'Out';
	} else {
		$fill = '#fff1d6';
		$stroke = '#efc36f';
		$text = '#a16207';
		$label = 'Indent';
	}

	$badge_width = max(45, min(72, strlen($label) * 6.5 + 20));
	$badge_x = $x + (($w - $badge_width) / 2);
	$pdf->rounded_rect($badge_x, $y + 4, $badge_width, 16, 8, $fill, $stroke, 0.6);
	$pdf->text($badge_x + ($badge_width / 2), $y + 15, $label, 8.5, false, $text, 'center');
}

function alupro_dynamic_generate_schedule_pdf($schedule)
{
	$pdf = new AluPro_Dynamic_Pdf_Document();
	$headers = $schedule['headers'];
	$rows = alupro_dynamic_pdf_table_rows($schedule);
	$column_count = max(1, count($headers));
	$table_x = 50;
	$table_width = 495;
	$header_height = 20;
	$row_height = 24;
	$bottom_limit = 775;
	$widths = alupro_dynamic_pdf_column_widths($column_count, $table_width);
	$row_index = 0;

	$draw_table_header = function ($y) use ($pdf, $headers, $widths, $table_x, $header_height) {
		$pdf->rect($table_x, $y, array_sum($widths), $header_height, '#1d1164', '#1d1164');

		$x = $table_x;
		foreach ($headers as $index => $header) {
			if ($index > 0) {
				$pdf->line($x, $y, $x, $y + $header_height, '#31246f', 0.6);
			}

			$pdf->text($x + 10, $y + 14, $header, 9, false, '#ffffff');
			$x += $widths[$index];
		}

		return $y + $header_height;
	};

	$start_page = function ($first_page) use ($pdf, $schedule, $draw_table_header) {
		$pdf->add_page();
		$pdf->rect(8, 0, 2, $pdf->page_height(), '#246bff', '#246bff');

		if ($first_page) {
			$pdf->text(50, 81, 'AluPro', 30, true, '#180f5e');
			$title_height = $pdf->wrapped_text(160, 58, $schedule['title'], 385, 19, false, '#111111', 21, 2);
			$meta_y = 58 + max(21, $title_height) + 5;
			$pdf->text(160, $meta_y, 'Tempers: ' . $schedule['tempers'], 10.5, false, '#4b4b4b');
			$cert_y = $meta_y + 17;
			$cert_height = $pdf->wrapped_text(160, $cert_y, $schedule['certifications'], 385, 10.5, false, '#4b4b4b', 13, 2);
			$line_y = max(120, $cert_y + $cert_height + 8);
			$pdf->line(50, $line_y, 545, $line_y, '#d9dce1', 0.6);

			return $draw_table_header($line_y + 12);
		}

		$pdf->line(50, 120, 545, 120, '#d9dce1', 0.6);

		return $draw_table_header(132);
	};

	$start_note_page = function () use ($pdf) {
		$pdf->add_page();
		$pdf->rect(8, 0, 2, $pdf->page_height(), '#246bff', '#246bff');
		$pdf->line(50, 120, 545, 120, '#d9dce1', 0.6);

		return 142;
	};

	$y = $start_page(true);

	foreach ($rows as $cells) {
		if ($y + $row_height > $bottom_limit) {
			$y = $start_page(false);
		}

		$fill = 0 === $row_index % 2 ? '#ffffff' : '#f6f7f9';
		$pdf->rect($table_x, $y, $table_width, $row_height, $fill, null);

		$x = $table_x;
		foreach ($cells as $index => $cell) {
			$cell_width = $widths[$index];

			if (0 === $index && '' !== trim((string) $cell)) {
				$pdf->rect($x, $y, $cell_width, $row_height, '#eaf4ff', null);
			}

			if ($index > 0) {
				$pdf->line($x, $y, $x, $y + $row_height, '#edf0f3', 0.4);
			}

			if ($index === $column_count - 1 && alupro_dynamic_pdf_is_availability_value($cell)) {
				alupro_dynamic_pdf_draw_badge($pdf, $x, $y, $cell_width, $cell);
			} else {
				$font_size = 9.5;
				$bold = 0 === $index && '' !== trim((string) $cell);
				$color = $bold ? '#111827' : '#4b4b4b';
				$pdf->text($x + 10, $y + 16, $pdf->fit_text($cell, $cell_width - 20, $font_size, $bold), $font_size, $bold, $color);
			}

			$x += $cell_width;
		}

		$pdf->line($table_x, $y + $row_height, $table_x + $table_width, $y + $row_height, '#d9dce1', 0.5);
		$y += $row_height;
		$row_index++;
	}

	$note_height = 66;
	$note_y = $y + 26;

	if ($note_y + $note_height > $bottom_limit) {
		$note_y = $start_note_page();
	}

	$pdf->rounded_rect(50, $note_y, 495, $note_height, 4, '#f8fafc', '#d9dce1', 0.6);
	$pdf->text(64, $note_y + 24, 'Custom & Indent Items:', 11, false, '#111111');
	$pdf->wrapped_text(64, $note_y + 42, 'Dimensions not listed above and items marked Indent are available via mill / works production on a made-to-order basis. Subject to minimum order quantities (MOQ).', 455, 8.5, false, '#555555', 11, 3);

	return $pdf->output();
}

function alupro_dynamic_handle_schedule_pdf_download()
{
	if (empty($_GET['alupro_schedule_pdf'])) {
		return;
	}

	$post_id = absint($_GET['alupro_schedule_pdf']);
	$post = get_post($post_id);

	if (!$post || 'aluminium_product' !== $post->post_type || ('publish' !== $post->post_status && !current_user_can('read_post', $post_id))) {
		status_header(404);
		exit;
	}

	$schedule = alupro_get_product_schedule_data($post_id);
	$pdf = alupro_dynamic_generate_schedule_pdf($schedule);
	$filename = sanitize_title(get_the_title($post_id)) . '-schedule.pdf';

	while (ob_get_level()) {
		ob_end_clean();
	}

	nocache_headers();
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment; filename="' . $filename . '"');
	header('Content-Length: ' . strlen($pdf));
	echo $pdf;
	exit;
}
add_action('template_redirect', 'alupro_dynamic_handle_schedule_pdf_download');
