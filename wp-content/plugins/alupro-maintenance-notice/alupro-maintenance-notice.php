<?php
/**
 * Plugin Name: Alupro Maintenance Notice
 * Description: Shows the Alupro maintenance notice that was previously hardcoded in the theme.
 * Version: 1.1.0
 * Author: Alupro
 * Text Domain: alupro-maintenance-notice
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ALUPRO_MAINTENANCE_NOTICE_VERSION', '1.1.0');
define('ALUPRO_MAINTENANCE_NOTICE_OPTION', 'alupro_maintenance_notice_options');

function alupro_maintenance_notice_defaults()
{
	return array(
		'enabled' => 1,
		'hide_for_admins' => 0,
		'title_prefix' => 'Under',
		'title_highlight' => 'Maintenance',
		'message' => 'Update in progress.',
	);
}

function alupro_maintenance_notice_get_options()
{
	$options = get_option(ALUPRO_MAINTENANCE_NOTICE_OPTION, array());

	if (!is_array($options)) {
		$options = array();
	}

	return wp_parse_args($options, alupro_maintenance_notice_defaults());
}

function alupro_maintenance_notice_activate()
{
	if (false === get_option(ALUPRO_MAINTENANCE_NOTICE_OPTION, false)) {
		add_option(ALUPRO_MAINTENANCE_NOTICE_OPTION, alupro_maintenance_notice_defaults());
	}
}
register_activation_hook(__FILE__, 'alupro_maintenance_notice_activate');

function alupro_maintenance_notice_sanitize_options($input)
{
	$defaults = alupro_maintenance_notice_defaults();
	$input = is_array($input) ? wp_unslash($input) : array();

	return array(
		'enabled' => empty($input['enabled']) ? 0 : 1,
		'hide_for_admins' => empty($input['hide_for_admins']) ? 0 : 1,
		'title_prefix' => isset($input['title_prefix']) ? sanitize_text_field($input['title_prefix']) : $defaults['title_prefix'],
		'title_highlight' => isset($input['title_highlight']) ? sanitize_text_field($input['title_highlight']) : $defaults['title_highlight'],
		'message' => isset($input['message']) ? sanitize_text_field($input['message']) : $defaults['message'],
	);
}

function alupro_maintenance_notice_register_settings()
{
	register_setting(
		'alupro_maintenance_notice',
		ALUPRO_MAINTENANCE_NOTICE_OPTION,
		array(
			'sanitize_callback' => 'alupro_maintenance_notice_sanitize_options',
		)
	);
}
add_action('admin_init', 'alupro_maintenance_notice_register_settings');

function alupro_maintenance_notice_add_settings_page()
{
	add_options_page(
		__('Alupro Maintenance', 'alupro-maintenance-notice'),
		__('Alupro Maintenance', 'alupro-maintenance-notice'),
		'manage_options',
		'alupro-maintenance-notice',
		'alupro_maintenance_notice_render_settings_page'
	);
}
add_action('admin_menu', 'alupro_maintenance_notice_add_settings_page');

function alupro_maintenance_notice_render_settings_page()
{
	if (!current_user_can('manage_options')) {
		return;
	}

	$options = alupro_maintenance_notice_get_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('Alupro Maintenance Notice', 'alupro-maintenance-notice'); ?></h1>
		<p><?php esc_html_e('This controls the small maintenance notice that was previously inside the theme HTML.', 'alupro-maintenance-notice'); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields('alupro_maintenance_notice'); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e('Display notice', 'alupro-maintenance-notice'); ?></th>
					<td>
						<label>
							<input
								type="checkbox"
								name="<?php echo esc_attr(ALUPRO_MAINTENANCE_NOTICE_OPTION); ?>[enabled]"
								value="1"
								<?php checked(1, (int) $options['enabled']); ?>
							>
							<?php esc_html_e('Show the maintenance notice on the website', 'alupro-maintenance-notice'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Admin visibility', 'alupro-maintenance-notice'); ?></th>
					<td>
						<label>
							<input
								type="checkbox"
								name="<?php echo esc_attr(ALUPRO_MAINTENANCE_NOTICE_OPTION); ?>[hide_for_admins]"
								value="1"
								<?php checked(1, (int) $options['hide_for_admins']); ?>
							>
							<?php esc_html_e('Hide the notice for logged-in administrators', 'alupro-maintenance-notice'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="alupro-maintenance-title-prefix"><?php esc_html_e('Title first word', 'alupro-maintenance-notice'); ?></label>
					</th>
					<td>
						<input
							id="alupro-maintenance-title-prefix"
							type="text"
							class="regular-text"
							name="<?php echo esc_attr(ALUPRO_MAINTENANCE_NOTICE_OPTION); ?>[title_prefix]"
							value="<?php echo esc_attr($options['title_prefix']); ?>"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="alupro-maintenance-title-highlight"><?php esc_html_e('Title highlighted word', 'alupro-maintenance-notice'); ?></label>
					</th>
					<td>
						<input
							id="alupro-maintenance-title-highlight"
							type="text"
							class="regular-text"
							name="<?php echo esc_attr(ALUPRO_MAINTENANCE_NOTICE_OPTION); ?>[title_highlight]"
							value="<?php echo esc_attr($options['title_highlight']); ?>"
						>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="alupro-maintenance-message"><?php esc_html_e('Message', 'alupro-maintenance-notice'); ?></label>
					</th>
					<td>
						<input
							id="alupro-maintenance-message"
							type="text"
							class="regular-text"
							name="<?php echo esc_attr(ALUPRO_MAINTENANCE_NOTICE_OPTION); ?>[message]"
							value="<?php echo esc_attr($options['message']); ?>"
						>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

function alupro_maintenance_notice_should_show()
{
	if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
		return false;
	}

	$options = alupro_maintenance_notice_get_options();

	if (empty($options['enabled'])) {
		return false;
	}

	if (!empty($options['hide_for_admins']) && current_user_can('manage_options')) {
		return false;
	}

	return true;
}

function alupro_maintenance_notice_enqueue_assets()
{
	if (!alupro_maintenance_notice_should_show()) {
		return;
	}

	wp_enqueue_style(
		'alupro-maintenance-notice',
		plugin_dir_url(__FILE__) . 'assets/maintenance.css',
		array(),
		ALUPRO_MAINTENANCE_NOTICE_VERSION
	);
}
add_action('wp_enqueue_scripts', 'alupro_maintenance_notice_enqueue_assets');

function alupro_maintenance_notice_redirect_to_front_page()
{
	if (!alupro_maintenance_notice_should_show() || is_front_page()) {
		return;
	}

	wp_safe_redirect(home_url('/'), 302);
	exit;
}
add_action('template_redirect', 'alupro_maintenance_notice_redirect_to_front_page', 0);

function alupro_maintenance_notice_render()
{
	if (!alupro_maintenance_notice_should_show()) {
		return;
	}

	$options = alupro_maintenance_notice_get_options();
	alupro_maintenance_notice_render_inline_styles();
	?>
	<!-- Alupro Maintenance Notice Starts -->
	<script>
		document.documentElement.classList.add('alupro-maintenance-active');
	</script>
	<div class="alupro-maintenance-notice-lock" aria-modal="true" aria-labelledby="alupro-maintenance-notice-title" role="dialog">
		<div class="alupro-maintenance-notice" role="status" aria-live="polite">
			<div class="alupro-maintenance-notice__animation" aria-hidden="true">
				<span class="alupro-maintenance-notice__gear alupro-maintenance-notice__gear--one"></span>
				<span class="alupro-maintenance-notice__gear alupro-maintenance-notice__gear--two"></span>
				<span class="alupro-maintenance-notice__gear alupro-maintenance-notice__gear--three"></span>
			</div>
			<h2 id="alupro-maintenance-notice-title">
				<?php echo esc_html(trim($options['title_prefix']) . ' '); ?>
				<span><?php echo esc_html($options['title_highlight']); ?></span>
			</h2>
			<?php if ('' !== trim($options['message'])) : ?>
				<p><?php echo esc_html($options['message']); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<!-- Alupro Maintenance Notice Ends -->
	<?php
}
add_action('wp_footer', 'alupro_maintenance_notice_render');

function alupro_maintenance_notice_render_inline_styles()
{
	static $printed = false;

	if ($printed) {
		return;
	}

	$printed = true;
	$css_file = plugin_dir_path(__FILE__) . 'assets/maintenance.css';

	if (!is_readable($css_file)) {
		return;
	}

	$css = file_get_contents($css_file);

	if (false === $css || '' === trim($css)) {
		return;
	}
	?>
	<style id="alupro-maintenance-notice-inline-css">
		<?php echo $css; ?>
	</style>
	<?php
}
