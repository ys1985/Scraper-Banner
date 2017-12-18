<?php get_header(); ?>
    <?php
    function change_posts_per_page($query) {
      if (is_admin()) {
        return $query;
      }
      global $wp_query;
      $query->set("post_type", "twentyminutesbnr");
    }
    add_action( 'pre_get_posts', 'change_posts_per_page' );
    ?>

    <div id="twentyminutesbnr-archvie">
      <h2 class="year-ttl"><?php echo the_date("Y年n月j日 l"); ?></h2>
    </div>
    <div id="bnrthumb-list">
        <ul>
          <?php $args = array(
            'post_type' => 'twentyminutesbnr' //投稿タイプ名
          );
          $customPosts = get_posts($args);
          if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); ?>

            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <li><?php echo $post->post_content ?></li>

          <?php endforeach; ?>
          <?php else : //記事が無い場合 ?>
            <div id="no-result">
              <div class="in">
                <img class="illust" src="<?php echo get_template_directory_uri() ?>/assets/images/ghost.svg" alt="">
                <p class="tit"><span class="fa fa-search" aria-hidden="true"></span>No Results</p>
                <p class="word">検索ワード：<?php echo get_search_query(); ?></p>
                <a class="baseBtn" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップに戻る</a>
              </div>
            </div>
          <?php endif;
          wp_reset_postdata(); //クエリのリセット ?>
        </ul>

    </div>

    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
