<?php get_header(); ?>


<div id="bnrthumb-list">

  <?php
  while ( have_posts() ) : the_post(); ?>
    <div class="grid-item">
      <a href="#">
        <?php if ( has_post_thumbnail() ): // サムネイルを持っているときの処理 ?>
        <?php the_post_thumbnail( 'thumb150' ); ?>
        <?php else: // サムネイルを持っていないときの処理 ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/no-img.png" alt="no image" title="no image" width="100" height="100" />
        <?php endif; ?>
      </a>
      <dl class="post-details date">
        <dt>Date : </dt>
        <dd><?php the_date(); ?></dd>
      </dl>
      <dl class="post-details category">
        <dt>Category : </dt>
        <dd><a href="#"><?php the_category(); ?></a></dd>
      </dl>
      <dl class="post-details title">
        <dt>Project : </dt>
        <dd><a href="#"><?php the_title_attribute(); ?></a></dd>
      </dl>
    </div>
  <!-- </div> -->

<?php endwhile;?>

</div>


  <?php get_sidebar(); ?>

  </div>
  <!-- /contents-slide-wrap -->
<?php get_footer(); ?>
