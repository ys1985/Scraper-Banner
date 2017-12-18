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
      <?php
      if (is_year()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y年').'</h2>';
      } elseif (is_month()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y年n月').'</h2>';
      }
      ?>
      <?php $args = array(
        'post_type' => 'twentyminutesbnr' //投稿タイプ名
      );
      $customPosts = get_posts($args);
      if($customPosts) : foreach($customPosts as $post) : setup_postdata( $post ); ?>
      <div class="twentyminutesbnr-ttl-area">
        <p class="author">
          <span class="date">2017.12.20</span>
          <span class="avator"><img class="avator" alt="" src="http://0.gravatar.com/avatar/c90b1859437a3480cf2be6d94d4d7b55?s=60&amp;d=wavatar&amp;r=g" srcset="http://0.gravatar.com/avatar/c90b1859437a3480cf2be6d94d4d7b55?s=120&amp;d=wavatar&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60">出題者：七島</span>
        </p>
        <h3><?php the_title(); ?></h3>
      </div>
      <div id="bnrthumb-list" class="archive">
        <?php
          echo $post->post_content;
         ?>
      </div>
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
    </div>




    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
