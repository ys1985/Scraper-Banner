<?php get_header(); ?>

    <div id="twentyminutesbnr-archvie">
    <p>taxonomy.php 20分バナーアーカイブ</p>
    <?php $args = array(
      'post_type' => 'twentyminutesbnr' //投稿タイプ名
    );
    $customPosts = query_posts($args);
    if($customPosts) : foreach($customPosts as $key => $post) : setup_postdata( $post ); ?>
      <?php echo get_the_title(); ?>
    <?php endforeach; ?>
    <?php endif; wp_reset_postdata(); //クエリのリセット ?>
    </div>

    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
