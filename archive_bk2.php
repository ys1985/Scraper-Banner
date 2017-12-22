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
    <?php $args = array(
      'post_type' => 'twentyminutesbnr' //投稿タイプ名
    );
    $customPosts = get_posts($args);?>

    <div id="twentyminutesbnr-archvie">
      <?php while ( have_posts() ) : the_post() ?>
        <span class="date"><?php echo get_the_date(); ?></span>
      <?php endwhile ?>


      <?php
      if (is_year()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y年').'</h2>';
      } elseif (is_day()) {
          echo $html .= '<h2 class="year-ttl">'.get_the_date('Y年n月').'</h2>';
      }
      ?>

      <?php $query1 = new WP_Query( $args ); ?>
      <?php while ( $query1->have_posts()) : ?>
      <?php $query1->the_post();?>

      <div class="twentyminutesbnr-ttl-area">
        <p class="author">
          <?php if (get_field('author') === "questions"): ?>
          <span class="date"><?php echo get_the_date(); ?></span>
          <span class="avator">
            <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) );?>
            <?php echo get_avatar(get_the_author_id()); ?>出題者：<?php echo get_the_author_meta( 'nickname' ); ?>
          </span>
        </p>
          <h3><?php echo get_the_title() ?></h3>
        <?php endif; ?>
      </div>
      <?php endwhile; ?>

      <div id="bnrthumb-list" class="masanory-list archive">
          <?php $query2 = new WP_Query( $args ); ?>
          <?php while ( $query2->have_posts()) : ?>
          <?php $query2->the_post();?>
          <div class="grid-item">
            <a class="thumb_img" data-lightbox-gallery="photo_gallery" href="<?php echo get_field('thumb-img'); ?>">
              <?php if ( $image = get_field('thumb-img') ): // サムネイルを持っているときの処理 ?>
              <img src="<?php echo $image ?>" alt="" title="" />
              <?php else: // サムネイルを持っていないときの処理 ?>
              <img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" />
              <?php endif; ?>
            </a>
            <div class="body">
        			<p class="thumbnail"><?php echo get_avatar(get_the_author_id() , 40); ?></p>
        			<div class="info">
        				<p class="author ft-bold"><?php echo get_the_author_meta( 'nickname' ); ?></p>
        				<p class="reactions">
        					<!-- <span class="comments"><i class="fa fa-commenting" aria-hidden="true"></i>0</span> -->
        					<!-- <span class="likes"><i class="fa fa-heart" aria-hidden="true"></i>0</span> -->
        				</p>
        			</div>
        		</div>
          </div>
          <?php endwhile; ?>
      </div>
    </div>


    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
