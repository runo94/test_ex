<?php get_header();

// var_dump($_COOKIE);

if (isset ($_COOKIE['post_id'])) {
	$prev_posts = json_decode($_COOKIE['post_id'], true);
}
?>

<div id="content" class="wrap">

	<main id="main" class="container" role="main" itemscope itemprop="mainContentOfPage"
		itemtype="http://schema.org/Blog">

		<?php if (have_posts()):
			while (have_posts()):
				the_post();
				$post_thumbnail_id = get_post_thumbnail_id();

				$post_thumbnail_url = wp_get_attachment_image_src($post_thumbnail_id, 'custom-thumb-600', true);
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('row  my-4'); ?> role="article" itemscope
					itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
					<section class="col-md-6 col-12">
						<img title="image title" alt="thumb image" class="rounded-4"
							src="<?php echo $post_thumbnail_url['0']; ?>" style="width:100%; height:auto;">

					</section>
					<section class="col-md-6 col-12">
						<header class="article-header entry-header">

							<h1 class="entry-title single-title" itemprop="headline" rel="bookmark">
								<?php the_title(); ?>
							</h1>

							<p class="byline entry-meta vcard">


								<?php printf(
									'Posted' . ' %1$s %2$s',
									'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
									'<span class="by">' . 'by' . '</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link(get_the_author_meta('ID')) . '</span>'
								); ?>

							</p>

						</header>

						<section class="entry-content" itemprop="articleBody">
							<?php
								the_content();
							?>
						</section>

						<footer class="article-footer">

						</footer>
					</section>
				</article>


			<?php endwhile; ?>

		<?php else: ?>

			<article id="post-not-found" class="hentry">
				<header class="article-header">
					<h1>
						Oops, Post Not Found!
					</h1>
				</header>
				<section class="entry-content">
					<p>
						Uh Oh. Something is missing. Try double checking things.
					</p>
				</section>
				<footer class="article-footer">
					<p>
						This is the error message in the single.php template.
					</p>
				</footer>
			</article>

		<?php endif; ?>
		<?php if (isset ($prev_posts)): ?>
			<section class="row">
				<h3>Previously visited:</h3>
				<?php
				foreach ($prev_posts as $key => $prev_post) { ?>
					<div class='col-6 col-lg-4 my-4'>
						<?php echo do_shortcode("[show_post id='{$prev_post}']"); ?>
					</div>
				<?php }
				; ?>
			</section>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>