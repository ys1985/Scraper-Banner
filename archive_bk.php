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
      } elseif (is_day()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y年n月').'</h2>';
      }
      ?>
      <?php $args = array(
        'post_type' => 'twentyminutesbnr' //投稿タイプ名
      );

      $customPosts = get_posts($args);
      $thumImgArray = [];
      $pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';

      if($customPosts) : foreach($customPosts as $key => $post) : setup_postdata( $post ); ?>
      <div class="twentyminutesbnr-ttl-area">
        <p class="author">
          <span class="date"><?php echo get_the_date(); ?></span>
          <span class="avator">
            <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) );?>
            <?php echo get_avatar(get_the_author_id()); ?>出題者：<?php echo get_the_author_meta( 'nickname' ); ?>
          </span>
        </p>
        <h3><?php the_title(); ?></h3>
      </div>

      <div id="bnrthumb-list" class="masanory-list archive">
        <?php
        $content = get_the_content();
        preg_match_all( $pattern, $content, $images );
        $thumImgArray[] = $images;
        ?>
        <?php foreach ($thumImgArray[$key][0] as $key => $value): ?>
          <div class="grid-item">
            <a class="thumb_img" data-lightbox-gallery="photo_gallery" href="<?php echo get_content_image($value); ?>"><?php echo $value ?></a>
          </div>
        <?php endforeach; ?>
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
