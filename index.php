<?php get_header(); ?>

<div id="content">

	<div id="inner-content" class="wrap">

		<main id="main" class="container" role="main" itemscope itemprop="mainContentOfPage"
			itemtype="http://schema.org/Blog">
			<section class="row">
				<?php if (have_posts()):
					while (have_posts()):
						the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-6 col-lg-4'); ?> role="article">
							<section class="card">
								<?php the_post_thumbnail('custom-thumb-300', array('class' => 'card-img-top')); ?>
								<div class="card-body">
									<header class="article-header">

										<h2 class="card-title"><a href="<?php the_permalink() ?>" rel="bookmark"
												title="<?php the_title_attribute(); ?>">
												<?php the_title(); ?>
											</a></h2>
										<p class="byline entry-meta vcard">
											<?php printf(
												'Posted'. ' %1$s %2$s',
												'<time class="updated entry-time" datetime="' . get_the_time('Y-m-d') . '" itemprop="datePublished">' . get_the_time(get_option('date_format')) . '</time>',
												'<span class="by">' . 'by' . '</span> <span class="entry-author author" itemprop="author" itemscope itemptype="http://schema.org/Person">' . get_the_author_link(get_the_author_meta('ID')) . '</span>'
											); ?>
										</p>

									</header>

									<section>
										<?php the_excerpt(); ?>
									</section>
								</div>
							</section>
						</article>

					<?php endwhile; ?>

					<?php page_navigation(); ?>

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
								'This is the error message in the index.php template.
							</p>
						</footer>
					</article>

				<?php endif; ?>
			</section>
		</main>

	</div>

</div>


<?php get_footer(); ?>