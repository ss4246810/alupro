<?php
/**
 * Default template.
 *
 * @package AluProDynamic
 */

get_header();
?>
<main class="max-w-7xl mx-auto px-6 py-20">
	<?php if (have_posts()) : ?>
		<div class="grid gap-10">
			<?php
			while (have_posts()) :
				the_post();
				?>
				<article <?php post_class('prose max-w-none'); ?>>
					<h1 class="text-4xl font-extrabold text-[#111827]">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h1>
					<div class="mt-6 text-[#4B5563]"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<h1 class="text-4xl font-extrabold text-[#111827]"><?php esc_html_e('No content found.', 'alupro-dynamic'); ?></h1>
	<?php endif; ?>
</main>
<?php
get_footer();
