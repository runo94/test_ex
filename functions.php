<?php
add_action('after_setup_theme', 'theme_slug_setup');

add_theme_support('post-thumbnails');

set_post_thumbnail_size(125, 125, true);

function theme_slug_setup()
{
  add_theme_support('wp-block-styles');
}

wp_enqueue_script('jquery');

function load_css_js()
{
  wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/library/css/bootstrap.min.css');

  wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/library/js/libs/bootstrap.min.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'load_css_js');


function page_navigation()
{
  global $wp_query;
  $bignum = 999999999;
  if ($wp_query->max_num_pages <= 1)
    return;
  echo '<nav class="pagination">';
  echo paginate_links(
    array(
      'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
      'format' => '',
      'current' => max(1, get_query_var('paged')),
      'total' => $wp_query->max_num_pages,
      'prev_text' => '&larr;',
      'next_text' => '&rarr;',
      'type' => 'list',
      'end_size' => 3,
      'mid_size' => 3
    )
  );
  echo '</nav>';
}


add_filter('image_size_names_choose', 'custom_image_sizes');

add_image_size('custom-thumb-600', 600, 600, true);
add_image_size('custom-thumb-300', 300, 300, true);

function custom_image_sizes($sizes)
{
  return array_merge(
    $sizes,
    array(
      'custom-thumb-600' => __('600px by 600px'),
      'custom-thumb-300' => __('300px by 300px'),
    )
  );
}

add_shortcode('show_post', 'show_post_func');
function show_post_func($atts)
{
  $atts = shortcode_atts([
    'id' => '',
  ], $atts);

  if (empty ($atts['id'])) {
    return '';
  }

  $thumbnail = get_the_post_thumbnail($atts['id'], 'custom-thumb-300', array('class' => 'card-img-top'));
  $permalink = get_post_permalink($atts['id']);
  $title = get_the_title($atts['id']);
  $quote_author = get_post_meta($atts['id'], 'quote_author', true);
  $excerpt = get_the_excerpt($atts['id']);
  $post_data = "
    <article role='article'>
      <section class='card'>
      {$thumbnail}
      <div class='card-body'>
        <header class='article-header'>
          <h2 class='card-title'>
            <a href='{$permalink}' rel='bookmark' title='{$title}'>
              {$title}
            </a>
          </h2>
        </header>
        <section>
        <p><i>{$excerpt}</i></p>
        <p>{$quote_author}</p>
        </section>
      </div>
      </section>
    </article>
  ";

  return $post_data;
};

function setCookies()
{
  global $wp_query;
  // setcookie('post_id',"", time()-5);
  if (is_single()) {
    $post_arr = [];
    if (isset ($_COOKIE['post_id'])) {

      $data = json_decode($_COOKIE['post_id'], true);
      $post_arr = $data;

      if (!is_array($post_arr)) {
        $post_arr = [];
      }

      $post_id = get_the_ID();
      array_unshift($post_arr, $post_id);

      if ($post_arr[1] !== $post_id) {
        setcookie('post_id', json_encode(array_unique(array_slice($post_arr, 0, 3))), time() + (86400 * 5), '/', 'test-ex.loc');
      }

    } else {

      var_dump($post_arr);

      $post_id = get_the_ID();
      array_unshift($post_arr, $post_id);
      setcookie('post_id', json_encode($post_arr), time() + (86400 * 5), '/', 'test-ex.loc');
    }

  }
  $wp_query->rewind_posts();
  return;
}
add_action('wp', 'setCookies', 10);