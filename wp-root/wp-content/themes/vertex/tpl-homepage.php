<?php
/*
Template Name: Homepage
*/

get_header();
$slider = array(
	'post_type' => 'post',
	'category_name' => 'slide',
	'posts_per_page' => -1,
	'ignore_sticky_posts' => true
);

$the_query = new WP_Query($slider);
if ($the_query->have_posts()):
	?>
	<div class="home-slider">
		<div id="slider" class="sl-slider-wrapper">
			<div class="sl-slider">
				<?php while ($the_query->have_posts()):
					$the_query->the_post();
					$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
					$trans = array(
						array('horizontal', '-25', '-25', '2', '2'),
						array('vertical', '10', '-15', '1.5', '1.5'),
						array('horizontal', '3', '3', '2', '1'),
						array('vertical', '-25', '-25', '2', '2'),
						array('horizontal', '-5', '10', '2', '1')
					);
					$random_key = array_rand($trans, 2);
					$arr = $trans[$random_key[0]];
					?>
					<div class="sl-slide" data-orientation="<?php echo $arr[0]; ?>"
						data-slice1-rotation="<?php echo $arr[1]; ?>" data-slice2-rotation="<?php echo $arr[2]; ?>"
						data-slice1-scale="<?php echo $arr[3]; ?>" data-slice2-scale="<?php echo $arr[4]; ?>">
						<div class="sl-slide-inner">
							<div class="bg-img" style="background-image: url(<?php echo esc_url($thumbnail[0]); ?>); ">
								<!-- /slider link, dezactivat <a href="<?php the_permalink(); ?>"></a> --></div>
						</div>
					</div>
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div><!-- /sl-slider -->
			<nav id="nav-arrows" class="nav-arrows">
				<span class="nav-arrow-prev"><?php echo __('Previous', 'vertex'); ?></span>
				<span class="nav-arrow-next"><?php echo __('Next', 'vertex'); ?></span>
			</nav>
		</div><!-- /slider-wrapper -->
	</div><!-- home-slider -->
<?php endif; ?>
<div class="feature-text-area">
	<div class="container">
		<h3><?php echo (vertex_setting('vertex_hometext') != '' ? sanitize_text_field(vertex_setting('vertex_hometext')) : ''); ?>
		</h3>
	</div><!-- container -->
</div><!-- feature-text-area -->

<div class="home-portfolio">
	<div class="container">
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/premium-product-photography-in-eu/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/001-Premium-product-Photography-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/premium-product-photography-in-eu/">Premium Product Photography</a>
				</h3>

			</div>
		</div>
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/creative-shoot/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/002-Creative-Shoot-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/creative-shoot/">Creative Shoot</a></h3>
			</div>
		</div>
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/adygascan-360-is-unique-innovative-technique/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/003-AdygaScan-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/adygascan-360-is-unique-innovative-technique/">AdygaScan 360°</a>
				</h3>
			</div>
		</div>
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/stopmotion/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/004-Stop-Motion-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/stopmotion/">STOPMotion</a></h3>
			</div>
		</div>
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/commercial-video-production/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/005-Video-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/commercial-video-production/">Commercial Video Production</a></h3>
			</div>
		</div>
		<div class="portfolio-box">
			<div class="port-image">
				<a href="https://www.adyga.com/gif-animation/"
					style="background-image: url(https://www.adyga.com/wp-content/uploads/2022/09/006-GIF-768x768.jpg)"></a>
			</div>
			<div class="port-body">
				<h3><a href="https://www.adyga.com/gif-animation/">GiF Animation</a></h3>
			</div>
		</div>
		<div class="clear"></div>
	</div><!-- container -->
</div><!-- home-portfolio -->

<?php
$blog_args = array(
	'post_type' => 'post',
	'posts_per_page' => 3,
	'paged' => (get_query_var('paged') ? get_query_var('paged') : 1),
	'category_name' => 'blog'
);
$blog = new WP_Query($blog_args);
if ($blog->have_posts()):
	?>
	<div class="blog">
		<div class="container">
			<div class="blog-posts">
				<?php
				while ($blog->have_posts()):
					$blog->the_post();
					?>
					<div class="blog-post-box <?php echo (is_sticky() ? 'sticky-post' : ''); ?>">
						<div class="blog-post-feature">
							<?php
							if ('video' == get_post_format(get_the_ID())):

								echo vertex_get_video(get_the_ID());

							else:

								$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array(600, 600));
								echo '<div class="blog-post-image">
										<a href="' . esc_url(get_permalink()) . '" style="background-image: url(' . esc_url($thumbnail[0]) . ')"></a>
									</div>';
							endif;
							?>
						</div>
						<div class="blog-post-info">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="blog-post-meta"> <?php the_time(get_option('date_format')); ?> | <a
									href="<?php comments_link(); ?>"><?php comments_number(__('0 Comments', 'vertex'), __(' 1 Comment', 'vertex'), '% ' . __('Comments', 'vertex')); ?></a>
							</div>
							<div class="blog-post-excerpt">
								<p><?php echo wp_trim_words(get_the_excerpt(), 25, '...') ?></p>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div><!-- blog-posts -->
		</div><!-- container -->
	</div><!-- blog -->
<?php endif; ?>
<?php
get_footer();
?>