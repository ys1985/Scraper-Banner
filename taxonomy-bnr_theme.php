<?php get_header(); ?>

    <div id="twentyminutesbnr-archvie">

      <?php $args_title = array(
        'post_type' => 'twentyminutesbnr',
        'tax_query' => array(
          array(
            'taxonomy' => 'bnr_theme',
            'field' => 'slug',
            'terms' => $term
          )
        )
      ); ?>
      <?php $query_title = new WP_Query( $args_title ); ?>
      <?php while ( $query_title->have_posts()) : ?>
      <?php $query_title->the_post();?>
      <?php if (get_field('author') === "questions"): ?>
      <h2 class="year-ttl"><?php echo get_the_date(); ?></h2>
      <div class="twentyminutesbnr-ttl-area">
        <p class="author">
          <span class="avator">
            <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) );?>
            <?php echo get_avatar(get_the_author_id()); ?>出題者：<?php echo get_the_author_meta( 'nickname' ); ?>
          </span>
        </p>
          <h3><?php echo get_the_title() ?></h3>
      </div>
      <?php endif; ?>
      <?php endwhile ?>

      <div id="bnrthumb-list" class="twentyminutesbnr">

      <?php $term = get_query_var('bnr_theme') ?>
      <?php $args = array(
        'post_type' => 'twentyminutesbnr',
        'tax_query' => array(
          array(
            'taxonomy' => 'bnr_theme',
            'field' => 'slug',
            'terms' => $term
          )
        )
      );
      $domestic_post = get_posts($args);?>

      <?php if($domestic_post) : foreach($domestic_post as $post) : setup_postdata( $post ); ?>

      <div class="grid-item">
        <a class="thumb_img" href="<?php echo $str_grep ?>">
          <div class="gradient"></div>
          <div class="meta">
            <p class="title"><?php echo get_the_title(); ?></p>
            <p class ="date"><?php echo get_the_date(); ?></p>
          </div>
          <?php if ( $image = get_field('winner-img') ): ?>
          <img src="<?php echo $image ?>" alt="" title="" />
          <?php elseif ( $image = get_field('thumb-img') ): ?>
          <img src="<?php echo $image ?>" alt="" title="" />
          <?php else: // サムネイルを持っていないときの処理 ?>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/no-image.jpg" alt="no image" title="no image" />
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
      <?php endforeach; ?>
      <?php else : //記事が存在しない場合 ?>
      <p>表示する記事がありません。</p>
      <?php endif;
      wp_reset_postdata(); ?>


      <div>
    </div>
      <!-- /twentyminutesbnr-archvie -->

    <?php require_once locate_template('sidebar-date.php', true); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
