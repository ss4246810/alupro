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

function alupro_dynamic_normalize_background_color($color)
{
	$color = strtolower(trim(html_entity_decode((string) $color, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
	$color = preg_replace('/\s+/', ' ', $color);

	if ('' === $color || in_array($color, array('transparent', 'none', 'inherit', 'initial', 'unset'), true)) {
		return '';
	}

	if (preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $color)) {
		return $color;
	}

	if (preg_match('/^rgba?\(([^)]+)\)$/i', $color, $matches)) {
		$parts = array_map('trim', explode(',', $matches[1]));

		if (count($parts) >= 3) {
			$rgb = array();

			for ($i = 0; $i < 3; $i++) {
				$part = $parts[$i];
				$value = false !== strpos($part, '%') ? (float) $part * 2.55 : (float) $part;
				$rgb[] = max(0, min(255, (int) round($value)));
			}

			if (isset($parts[3]) && (float) $parts[3] <= 0) {
				return '';
			}

			return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
		}
	}

	$named_colors = array(
		'black' => '#000000',
		'blue' => '#0000ff',
		'gray' => '#808080',
		'green' => '#008000',
		'grey' => '#808080',
		'orange' => '#ffa500',
		'purple' => '#800080',
		'red' => '#ff0000',
		'silver' => '#c0c0c0',
		'white' => '#ffffff',
		'yellow' => '#ffff00',
	);

	return isset($named_colors[$color]) ? $named_colors[$color] : '';
}

function alupro_dynamic_extract_background_color($node)
{
	$background = '';

	if ($node->hasAttribute('style')) {
		$style = html_entity_decode($node->getAttribute('style'), ENT_QUOTES | ENT_HTML5, 'UTF-8');

		if (preg_match('/(?:^|;)\s*background-color\s*:\s*([^;]+)/i', $style, $matches)) {
			$background = alupro_dynamic_normalize_background_color($matches[1]);
		}

		if ('' === $background && preg_match('/(?:^|;)\s*background\s*:\s*([^;]+)/i', $style, $matches)) {
			if (preg_match('/#[0-9a-f]{3,6}\b|rgba?\([^)]+\)|\b[a-z]+\b/i', $matches[1], $color_match)) {
				$background = alupro_dynamic_normalize_background_color($color_match[0]);
			}
		}
	}

	if ('' === $background && $node->hasAttribute('bgcolor')) {
		$background = alupro_dynamic_normalize_background_color($node->getAttribute('bgcolor'));
	}

	return $background;
}

function alupro_dynamic_normalize_background_matrix($backgrounds, $row_count, $column_count)
{
	$normalized = array();

	for ($i = 0; $i < $row_count; $i++) {
		$row = isset($backgrounds[$i]) && is_array($backgrounds[$i]) ? $backgrounds[$i] : array();
		$row = array_values(array_map('alupro_dynamic_normalize_background_color', $row));
		$row = array_pad($row, $column_count, '');
		$normalized[] = array_slice($row, 0, $column_count);
	}

	return $normalized;
}

function alupro_dynamic_normalize_background_list($backgrounds, $row_count)
{
	$normalized = array();

	for ($i = 0; $i < $row_count; $i++) {
		$normalized[] = isset($backgrounds[$i]) ? alupro_dynamic_normalize_background_color($backgrounds[$i]) : '';
	}

	return $normalized;
}

function alupro_dynamic_apply_processed_row_backgrounds($processed_rows, $cell_backgrounds, $row_backgrounds)
{
	foreach ($processed_rows as $index => $row) {
		$backgrounds = isset($cell_backgrounds[$index]) ? $cell_backgrounds[$index] : array();
		$processed_rows[$index]['background'] = isset($backgrounds[0]) ? $backgrounds[0] : '';
		$processed_rows[$index]['cell_backgrounds'] = array_slice($backgrounds, 1);
		$processed_rows[$index]['row_background'] = isset($row_backgrounds[$index]) ? $row_backgrounds[$index] : '';
	}

	return $processed_rows;
}

function alupro_dynamic_has_backgrounds($table_background, $header_backgrounds, $row_backgrounds, $body_row_backgrounds = array())
{
	if ('' !== $table_background) {
		return true;
	}

	foreach ($header_backgrounds as $background) {
		if ('' !== $background) {
			return true;
		}
	}

	foreach ($row_backgrounds as $row) {
		foreach ($row as $background) {
			if ('' !== $background) {
				return true;
			}
		}
	}

	foreach ($body_row_backgrounds as $background) {
		if ('' !== $background) {
			return true;
		}
	}

	return false;
}

function alupro_dynamic_extract_editor_schedule_table($content)
{
	$content = trim((string) $content);

	if ('' === $content || false === stripos($content, '<table')) {
		return array(
			'headers' => array(),
			'header_backgrounds' => array(),
			'rows' => array(),
			'row_backgrounds' => array(),
			'body_row_backgrounds' => array(),
			'table_background' => '',
			'has_backgrounds' => false,
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
			'header_backgrounds' => array(),
			'rows' => array(),
			'row_backgrounds' => array(),
			'body_row_backgrounds' => array(),
			'table_background' => '',
			'has_backgrounds' => false,
		);
	}

	$table = $tables->item(0);
	$table_background = alupro_dynamic_extract_background_color($table);
	$all_rows = array();

	foreach ($table->getElementsByTagName('tr') as $tr) {
		$cells = array();
		$has_header_cell = false;
		$row_background = alupro_dynamic_extract_background_color($tr);

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
				'background' => alupro_dynamic_extract_background_color($node),
			);
		}

		if (!empty($cells)) {
			$all_rows[] = array(
				'cells' => $cells,
				'is_header' => $has_header_cell,
				'row_background' => $row_background,
			);
		}
	}

	$headers = array();
	$header_backgrounds = array();
	$body_rows = array();
	$body_backgrounds = array();
	$body_row_backgrounds = array();
	$header_consumed = false;
	$span_remaining = 0;

	foreach ($all_rows as $row) {
		if (!$header_consumed && $row['is_header']) {
			foreach ($row['cells'] as $cell) {
				$headers[] = $cell['text'];
				$header_backgrounds[] = $cell['background'];
			}

			$header_consumed = true;
			continue;
		}

		$text_cells = array();
		$background_cells = array();

		foreach ($row['cells'] as $cell) {
			$text_cells[] = $cell['text'];
			$background_cells[] = $cell['background'];
		}

		if ($span_remaining > 0) {
			array_unshift($text_cells, '');
			array_unshift($background_cells, '');
			$span_remaining--;
		} elseif (!empty($row['cells'])) {
			$span_remaining = max(0, (int) $row['cells'][0]['rowspan'] - 1);
		}

		$body_rows[] = $text_cells;
		$body_backgrounds[] = $background_cells;
		$body_row_backgrounds[] = $row['row_background'];
	}

	return array(
		'headers' => $headers,
		'header_backgrounds' => $header_backgrounds,
		'rows' => $body_rows,
		'row_backgrounds' => $body_backgrounds,
		'body_row_backgrounds' => $body_row_backgrounds,
		'table_background' => $table_background,
		'has_backgrounds' => alupro_dynamic_has_backgrounds($table_background, $header_backgrounds, $body_backgrounds, $body_row_backgrounds),
	);
}

/**
 * Resolve a PDF URL from an ACF file field value.
 *
 * ACF can return a file field as an attachment ID, a URL string, or an array
 * containing ID/id and url keys, so this accepts those shapes deliberately.
 *
 * @param array{id?: int|string, ID?: int|string, url?: string}|int|string|null $file ACF file field value.
 * @return string Sanitized PDF URL, or empty string when the value is not a PDF.
 */
function alupro_dynamic_get_pdf_url_from_file_field($file)
{
	$url = '';
	$attachment_id = 0;

	if (is_array($file)) {
		if (!empty($file['ID'])) {
			$attachment_id = absint($file['ID']);
		} elseif (!empty($file['id'])) {
			$attachment_id = absint($file['id']);
		}

		if (!empty($file['url']) && is_string($file['url'])) {
			$url = trim($file['url']);
		}
	} elseif (is_numeric($file)) {
		$attachment_id = absint($file);
	} elseif (is_string($file)) {
		$file = trim($file);

		if (is_numeric($file)) {
			$attachment_id = absint($file);
		} else {
			$url = $file;
		}
	}

	if ($attachment_id) {
		$attachment_url = wp_get_attachment_url($attachment_id);

		if ($attachment_url && alupro_dynamic_is_pdf_url($attachment_url, $attachment_id)) {
			return esc_url_raw($attachment_url);
		}
	}

	if ('' === $url) {
		return '';
	}

	$resolved_attachment_id = 0;

	if (function_exists('url_to_postid')) {
		$resolved_attachment_id = absint(url_to_postid($url));
	}

	if ($resolved_attachment_id && 'attachment' === get_post_type($resolved_attachment_id)) {
		$attachment_url = wp_get_attachment_url($resolved_attachment_id);

		if ($attachment_url && alupro_dynamic_is_pdf_url($attachment_url, $resolved_attachment_id)) {
			return esc_url_raw($attachment_url);
		}
	}

	if (alupro_dynamic_is_pdf_url($url)) {
		return esc_url_raw($url);
	}

	return '';
}

/**
 * Check whether a URL or attachment points to a PDF file.
 *
 * @param string $url URL to inspect.
 * @param int    $attachment_id Optional attachment ID for MIME checking.
 * @return bool True when the URL/attachment is a PDF.
 */
function alupro_dynamic_is_pdf_url($url, $attachment_id = 0)
{
	if ($attachment_id && 'application/pdf' === get_post_mime_type($attachment_id)) {
		return true;
	}

	$path = wp_parse_url($url, PHP_URL_PATH);

	return 'pdf' === strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));
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

	$uploaded_catalog_pdf = function_exists('get_field') ? get_field('product_catalog_pdf', $post_id) : '';
	$uploaded_catalog_pdf = alupro_dynamic_get_pdf_url_from_file_field($uploaded_catalog_pdf);
	$catalog_pdf = $uploaded_catalog_pdf;
	$use_catalog_pdf = function_exists('get_field') ? (bool) get_field('product_use_catalog_pdf', $post_id) : false;

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
	$header_backgrounds = array();
	$row_backgrounds = array();
	$body_row_backgrounds = array();
	$table_background = '';
	$editor_table = alupro_dynamic_extract_editor_schedule_table(get_post_field('post_content', $post_id));

	if ('' !== trim((string) $table_data)) {
		$raw_rows = alupro_parse_spreadsheet_table($table_data);

		if (!empty($editor_table['has_backgrounds'])) {
			$header_backgrounds = $editor_table['header_backgrounds'];
			$table_background = $editor_table['table_background'];

			if (count($editor_table['rows']) === count($raw_rows)) {
				$row_backgrounds = $editor_table['row_backgrounds'];
				$body_row_backgrounds = $editor_table['body_row_backgrounds'];
			}
		}
	} else {
		if (!empty($editor_table['rows'])) {
			$raw_rows = $editor_table['rows'];
			$row_backgrounds = $editor_table['row_backgrounds'];
			$body_row_backgrounds = $editor_table['body_row_backgrounds'];
			$header_backgrounds = $editor_table['header_backgrounds'];
			$table_background = $editor_table['table_background'];
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
	$row_backgrounds = alupro_dynamic_normalize_background_matrix($row_backgrounds, count($raw_rows), $column_count);
	$body_row_backgrounds = alupro_dynamic_normalize_background_list($body_row_backgrounds, count($raw_rows));
	$header_backgrounds = array_pad(array_slice(array_map('alupro_dynamic_normalize_background_color', $header_backgrounds), 0, $column_count), $column_count, '');
	$processed_rows = alupro_compute_table_rowspans($raw_rows);
	$processed_rows = alupro_dynamic_apply_processed_row_backgrounds($processed_rows, $row_backgrounds, $body_row_backgrounds);

	return array(
		'post_id' => $post_id,
		'title' => $title,
		'tempers' => $tempers,
		'certifications' => $certifications,
		'image' => $image,
		'catalog_pdf' => $catalog_pdf,
		'use_catalog_pdf' => $use_catalog_pdf && !empty($uploaded_catalog_pdf),
		'headers' => $headers,
		'header_backgrounds' => $header_backgrounds,
		'rows' => $raw_rows,
		'row_backgrounds' => $row_backgrounds,
		'body_row_backgrounds' => $body_row_backgrounds,
		'processed_rows' => $processed_rows,
		'table_background' => alupro_dynamic_normalize_background_color($table_background),
		'has_custom_backgrounds' => alupro_dynamic_has_backgrounds($table_background, $header_backgrounds, $row_backgrounds, $body_row_backgrounds),
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

function alupro_dynamic_contrast_text_color($background)
{
	$background = ltrim(alupro_dynamic_normalize_background_color($background), '#');

	if (3 === strlen($background)) {
		$background = $background[0] . $background[0] . $background[1] . $background[1] . $background[2] . $background[2];
	}

	if (6 !== strlen($background)) {
		return '';
	}

	$r = hexdec(substr($background, 0, 2));
	$g = hexdec(substr($background, 2, 2));
	$b = hexdec(substr($background, 4, 2));
	$luminance = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

	return $luminance > 150 ? '#111827' : '#ffffff';
}

function alupro_dynamic_background_style_attr($background, $include_text_color = false)
{
	$background = alupro_dynamic_normalize_background_color($background);

	if ('' === $background) {
		return '';
	}

	$style = 'background-color: ' . $background . ';';

	if ($include_text_color) {
		$text_color = alupro_dynamic_contrast_text_color($background);

		if ('' !== $text_color) {
			$style .= ' color: ' . $text_color . ';';
		}
	}

	return ' style="' . esc_attr($style) . '"';
}

function alupro_dynamic_table_cell_style_attr($cell_background, $row_background = '', $row_background_visible = false)
{
	$cell_background = alupro_dynamic_normalize_background_color($cell_background);
	$row_background = alupro_dynamic_normalize_background_color($row_background);
	$style = '';

	if ('' !== $cell_background) {
		$style .= 'background-color: ' . $cell_background . ';';
		$text_color = alupro_dynamic_contrast_text_color($cell_background);

		if ('' !== $text_color) {
			$style .= ' color: ' . $text_color . ';';
		}
	} elseif ($row_background_visible && '' !== $row_background) {
		$text_color = alupro_dynamic_contrast_text_color($row_background);

		if ('' !== $text_color) {
			$style .= 'color: ' . $text_color . ';';
		}
	}

	if ('' === $style) {
		return '';
	}

	return ' style="' . esc_attr($style) . '"';
}

function alupro_render_product_schedule_table($schedule)
{
	$headers = isset($schedule['headers']) ? $schedule['headers'] : array();
	$header_backgrounds = isset($schedule['header_backgrounds']) ? $schedule['header_backgrounds'] : array();
	$processed_rows = isset($schedule['processed_rows']) ? $schedule['processed_rows'] : array();
	$column_count = max(1, count($headers));
	$table_background = isset($schedule['table_background']) ? $schedule['table_background'] : '';

	ob_start();
	?>
	<table class="w-full min-w-[560px] text-left"<?php echo alupro_dynamic_background_style_attr($table_background); ?>>
		<thead class="bg-[#190E5D] text-white">
			<tr>
				<?php foreach ($headers as $index => $header): ?>
					<th class="px-5 py-3 text-xs font-bold uppercase tracking-[0.16em]"<?php echo alupro_dynamic_background_style_attr(isset($header_backgrounds[$index]) ? $header_backgrounds[$index] : '', true); ?>>
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
				$render_row_index = 0;

				foreach ($processed_rows as $row):
					$render_row_index++;
					$is_even_render_row = 0 === $render_row_index % 2;
					if (!empty($row['is_first_of_group'])) {
						$is_even_group = !$is_even_group;
					}

					$bg_class = $is_even_group ? 'bg-[#EAF7FF]' : 'bg-white';
					$cells = isset($row['cells']) ? array_values($row['cells']) : array();
					$cells = array_pad(array_slice($cells, 0, max(0, $column_count - 1)), max(0, $column_count - 1), '');
					?>
					<?php $row_background = isset($row['row_background']) ? $row['row_background'] : ''; ?>
					<tr class="<?php echo esc_attr($bg_class); ?>"<?php echo alupro_dynamic_background_style_attr($row_background); ?>>
						<?php if (!empty($row['is_first_of_group'])): ?>
							<?php $first_cell_background = !empty($row['background']) ? $row['background'] : ''; ?>
							<td rowspan="<?php echo esc_attr($row['rowspan']); ?>"
								class="px-5 py-3 align-top text-base font-bold text-[#180f5e] <?php echo esc_attr($bg_class); ?>"<?php echo alupro_dynamic_table_cell_style_attr($first_cell_background); ?>>
								<?php echo esc_html($row['value']); ?>
							</td>
						<?php endif; ?>
						<?php foreach ($cells as $cell_index => $cell): ?>
							<?php
							$cell_backgrounds = isset($row['cell_backgrounds']) ? $row['cell_backgrounds'] : array();
							$cell_background = !empty($cell_backgrounds[$cell_index]) ? $cell_backgrounds[$cell_index] : '';
							?>
							<td class="px-5 py-3 text-sm font-normal text-[#4B5563]"<?php echo alupro_dynamic_table_cell_style_attr($cell_background, $row_background, !$is_even_render_row); ?>>
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
		private $images = array();
		private $image_lookup = array();

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

		public function image($source, $x, $y, $w, $h, $fit = 'contain')
		{
			$image = $this->prepare_image($source);

			if (empty($image)) {
				return false;
			}

			$key = sha1($image['data']);

			if (!isset($this->image_lookup[$key])) {
				$name = 'I' . (count($this->images) + 1);
				$this->images[$name] = $image;
				$this->image_lookup[$key] = $name;
			}

			$name = $this->image_lookup[$key];
			$draw_x = $x;
			$draw_y = $y;
			$draw_w = $w;
			$draw_h = $h;

			if ('cover' !== $fit && $image['width'] > 0 && $image['height'] > 0) {
				$ratio = min($w / $image['width'], $h / $image['height']);
				$draw_w = $image['width'] * $ratio;
				$draw_h = $image['height'] * $ratio;
				$draw_x = $x + (($w - $draw_w) / 2);
				$draw_y = $y + (($h - $draw_h) / 2);
			}

			$bottom = $this->height - $draw_y - $draw_h;
			$this->content .= 'q ' . $this->format_number($draw_w) . ' 0 0 ' . $this->format_number($draw_h) . ' ' . $this->format_number($draw_x) . ' ' . $this->format_number($bottom) . ' cm /' . $name . ' Do Q' . "\n";

			return true;
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
			$image_object_numbers = array();

			foreach ($this->images as $name => $image) {
				$image_object_numbers[$name] = $object_number++;
			}

			foreach ($this->pages as $content) {
				$content_object = $object_number++;
				$page_object = $object_number++;
				$objects[$content_object] = '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . "endstream";
				$xobjects = '';

				if (!empty($image_object_numbers)) {
					$xobjects .= ' /XObject <<';

					foreach ($image_object_numbers as $name => $image_object) {
						$xobjects .= ' /' . $name . ' ' . $image_object . ' 0 R';
					}

					$xobjects .= ' >>';
				}

				$objects[$page_object] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 ' . $this->format_number($this->width) . ' ' . $this->format_number($this->height) . '] /Resources << /Font << /F1 3 0 R /F2 4 0 R >>' . $xobjects . ' >> /Contents ' . $content_object . ' 0 R >>';
				$page_object_numbers[] = $page_object . ' 0 R';
			}

			foreach ($this->images as $name => $image) {
				$image_object = $image_object_numbers[$name];
				$objects[$image_object] = '<< /Type /XObject /Subtype /Image /Width ' . (int) $image['width'] . ' /Height ' . (int) $image['height'] . ' /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ' . strlen($image['data']) . " >>\nstream\n" . $image['data'] . "\nendstream";
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

		private function prepare_image($source)
		{
			$bytes = $this->read_image_bytes($source);

			if (empty($bytes) || !function_exists('imagecreatefromstring')) {
				return array();
			}

			$source_image = @imagecreatefromstring($bytes);

			if (!$source_image) {
				return array();
			}

			$width = imagesx($source_image);
			$height = imagesy($source_image);

			if ($width < 1 || $height < 1) {
				imagedestroy($source_image);
				return array();
			}

			$canvas = imagecreatetruecolor($width, $height);
			$white = imagecolorallocate($canvas, 255, 255, 255);
			imagefilledrectangle($canvas, 0, 0, $width, $height, $white);
			imagecopy($canvas, $source_image, 0, 0, 0, 0, $width, $height);

			ob_start();
			imagejpeg($canvas, null, 90);
			$jpeg = ob_get_clean();

			imagedestroy($source_image);
			imagedestroy($canvas);

			if (empty($jpeg)) {
				return array();
			}

			return array(
				'data' => $jpeg,
				'width' => $width,
				'height' => $height,
			);
		}

		private function read_image_bytes($source)
		{
			$source = trim((string) $source);

			if ('' === $source) {
				return '';
			}

			if (0 === strpos($source, 'data:image/')) {
				$comma = strpos($source, ',');

				if (false !== $comma) {
					$data = substr($source, $comma + 1);
					$decoded = base64_decode($data, true);

					return false !== $decoded ? $decoded : '';
				}
			}

			if (preg_match('#^https?://#i', $source)) {
				$local_path = alupro_dynamic_pdf_image_url_to_path($source);

				if ($local_path && is_readable($local_path)) {
					return (string) file_get_contents($local_path);
				}

				$response = wp_remote_get(
					$source,
					array(
						'timeout' => 8,
						'redirection' => 3,
					)
				);

				if (!is_wp_error($response) && 200 === (int) wp_remote_retrieve_response_code($response)) {
					return (string) wp_remote_retrieve_body($response);
				}

				return '';
			}

			if (is_readable($source)) {
				return (string) file_get_contents($source);
			}

			return '';
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

function alupro_dynamic_pdf_table_background_rows($schedule)
{
	$rows = array();
	$column_count = max(1, count($schedule['headers']));
	$processed_rows = isset($schedule['processed_rows']) ? $schedule['processed_rows'] : array();
	$active_group_background = '';

	foreach ($processed_rows as $row) {
		if (!empty($row['is_first_of_group'])) {
			$active_group_background = !empty($row['background']) ? $row['background'] : '#eaf4ff';
		}

		$backgrounds = array($active_group_background);
		$backgrounds = array_merge($backgrounds, isset($row['cell_backgrounds']) ? $row['cell_backgrounds'] : array());
		$backgrounds = array_pad(array_slice($backgrounds, 0, $column_count), $column_count, '');
		$rows[] = $backgrounds;
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

function alupro_dynamic_pdf_image_url_to_path($url)
{
	$url = trim((string) $url);

	if ('' === $url) {
		return '';
	}

	$uploads = wp_get_upload_dir();
	$maps = array(
		array('url' => isset($uploads['baseurl']) ? $uploads['baseurl'] : '', 'path' => isset($uploads['basedir']) ? $uploads['basedir'] : ''),
		array('url' => content_url(), 'path' => WP_CONTENT_DIR),
		array('url' => get_theme_file_uri(), 'path' => get_theme_file_path()),
		array('url' => site_url('/'), 'path' => ABSPATH),
	);

	foreach ($maps as $map) {
		$base_url = untrailingslashit((string) $map['url']);
		$base_path = untrailingslashit((string) $map['path']);

		if ('' === $base_url || '' === $base_path || 0 !== strpos($url, $base_url)) {
			continue;
		}

		$relative = ltrim(substr($url, strlen($base_url)), '/');
		$path = $base_path . '/' . rawurldecode($relative);

		if (is_readable($path)) {
			return $path;
		}
	}

	return '';
}

function alupro_dynamic_pdf_logo_source()
{
	$logo = dirname(__DIR__) . '/images/logo-colored-pdf.png';

	return is_readable($logo) ? $logo : '';
}

function alupro_dynamic_generate_schedule_pdf($schedule)
{
	$pdf = new AluPro_Dynamic_Pdf_Document();
	$headers = $schedule['headers'];
	$rows = alupro_dynamic_pdf_table_rows($schedule);
	$row_backgrounds = alupro_dynamic_pdf_table_background_rows($schedule);
	$header_backgrounds = isset($schedule['header_backgrounds']) ? $schedule['header_backgrounds'] : array();
	$body_row_backgrounds = isset($schedule['body_row_backgrounds']) ? $schedule['body_row_backgrounds'] : array();
	$column_count = max(1, count($headers));
	$table_x = 50;
	$table_width = 495;
	$header_height = 20;
	$row_height = 24;
	$bottom_limit = 775;
	$widths = alupro_dynamic_pdf_column_widths($column_count, $table_width);
	$row_index = 0;

	$draw_table_header = function ($y) use ($pdf, $headers, $header_backgrounds, $widths, $table_x, $header_height) {
		$x = $table_x;
		foreach ($headers as $index => $header) {
			$header_fill = !empty($header_backgrounds[$index]) ? $header_backgrounds[$index] : '#1d1164';
			$pdf->rect($x, $y, $widths[$index], $header_height, $header_fill, $header_fill);
			$pdf->text($x + 10, $y + 14, $header, 9, true, alupro_dynamic_contrast_text_color($header_fill) ?: '#ffffff');
			$x += $widths[$index];
		}

		return $y + $header_height;
	};

	$start_page = function ($first_page) use ($pdf, $schedule, $draw_table_header) {
		$pdf->add_page();
		$pdf->rect(8, 0, 2, $pdf->page_height(), '#246bff', '#246bff');

		if ($first_page) {
			$logo_source = alupro_dynamic_pdf_logo_source();

			if (!$logo_source || !$pdf->image($logo_source, 42, 48, 105, 68)) {
				$pdf->text(50, 81, 'AluPro', 30, true, '#180f5e');
			}

			if (!empty($schedule['image'])) {
				$pdf->image($schedule['image'], 455, 54, 90, 64);
			}

			$title_height = $pdf->wrapped_text(160, 58, $schedule['title'], 285, 19, false, '#111111', 21, 2);
			$meta_y = 58 + max(21, $title_height) + 5;
			$pdf->text(160, $meta_y, $pdf->fit_text('Tempers: ' . $schedule['tempers'], 285, 10.5, false), 10.5, false, '#4b4b4b');
			$cert_y = $meta_y + 17;
			$cert_height = $pdf->wrapped_text(160, $cert_y, $schedule['certifications'], 285, 10.5, false, '#4b4b4b', 13, 2);
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

		$cell_backgrounds = isset($row_backgrounds[$row_index]) ? $row_backgrounds[$row_index] : array();
		$row_background = isset($body_row_backgrounds[$row_index]) ? $body_row_backgrounds[$row_index] : '';
		$is_even_pdf_row = 0 === (($row_index + 1) % 2);
		$fill = (!$is_even_pdf_row && '' !== $row_background) ? $row_background : (0 === $row_index % 2 ? '#ffffff' : '#f6f7f9');
		$pdf->rect($table_x, $y, $table_width, $row_height, $fill, null);

		$x = $table_x;
		foreach ($cells as $index => $cell) {
			$cell_width = $widths[$index];
			$cell_background = !empty($cell_backgrounds[$index]) ? $cell_backgrounds[$index] : '';
			$custom_background = $cell_background ?: (!$is_even_pdf_row ? $row_background : '');

			if ('' !== $cell_background) {
				$pdf->rect($x, $y, $cell_width, $row_height, $cell_background, null);
			} elseif (0 === $index && '' !== trim((string) $cell)) {
				$pdf->rect($x, $y, $cell_width, $row_height, '#eaf4ff', null);
				$custom_background = '';
			}

			if ($index > 0) {
				$pdf->line($x, $y, $x, $y + $row_height, '#edf0f3', 0.4);
			}

			if ($index === $column_count - 1 && alupro_dynamic_pdf_is_availability_value($cell)) {
				alupro_dynamic_pdf_draw_badge($pdf, $x, $y, $cell_width, $cell);
			} else {
				$font_size = 9.5;
				$bold = 0 === $index && '' !== trim((string) $cell);
				$color = '' !== $custom_background ? alupro_dynamic_contrast_text_color($custom_background) : ($bold ? '#111827' : '#4b4b4b');
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
