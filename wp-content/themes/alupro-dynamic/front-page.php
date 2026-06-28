<?php
/**
 * Front page template.
 *
 * @package AluProDynamic
 */

get_header();
get_template_part('template-parts/banner');

?>
<main class="flex flex-col flex-1 w-full overflow-hidden">
<?php
get_template_part('template-parts/about');
get_template_part('template-parts/browse');

echo alupro_dynamic_static_home_sections();

?>
</main>
<?php
get_footer();
