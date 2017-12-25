<?php get_header(); ?>

    <div id="twentyminutesbnr-archvie">
    <p>archive-twentyminutesbnr.php 20分バナーアーカイブ</p>
    <?php
     $type = get_query_var( 'title' ); //指定したいタクソノミーを指定
     $args = array(
               'post_type' => array('twentyminutesbnr'), /* 投稿タイプを指定 */
               'tax_query' => array(
                   'relation' => 'OR',
                   array(
                       'taxonomy' => 'title', /* 指定したい投稿タイプが持つタクソノミーを指定 */
                       'field' => 'slug',
                       'terms' => $type, /* 上記で指定した変数を指定 */
                   ),
               ),
               'paged' => $paged,
               'posts_per_page' => '5' /* 5件を取得 */
           );
     ?>
     <?php $customPosts = query_posts( $args ); ?>
     <?php if($customPosts) : foreach($customPosts as $key => $post) : setup_postdata( $post ); ?>
       <?php echo get_the_title(); ?>
     <?php endforeach; ?>
     <?php endif; wp_reset_postdata(); //クエリのリセット ?>
    </div>

    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
