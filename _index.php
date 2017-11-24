<?php get_header(); ?>

    <div id="bnrthumb-list">
      <?php
        $loop = new WP_Query(array(
           'post_type' => 'bb_bnr',
        'posts_per_page' => -1 ) );
        while ( $loop->have_posts() ) : $loop->the_post();
      ?>


<div class="">
  <?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
  <?php the_post_thumbnail( 'thumb150' ); ?>
  <?php else: // サムネイルを持っていないときの処理 ?>
  <img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
  <?php endif; ?>
</div>
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<p class="taxonomies">
    <?php echo  get_the_term_list( $post->ID, 'bb_bnr_cat', 'タクソノミー', ', ', '' ); ?>
</p>

<div class="custom-post-content">
    <?php the_content('続きを読む&raquo;'); ?>
</div>
<?php endwhile; ?>
    </div>


    <?php get_sidebar(); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
