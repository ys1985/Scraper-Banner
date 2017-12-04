<nav id="category-nav">
  <div class="scroller">
    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a></h1>
    <?php
      // $terms = get_terms( 'brand-category' , array('hide_empty'=>false));
      // foreach ( $terms as $term ){
      // echo '<a href="'.get_term_link($term->slug, 'brand-category').'">'.$term->name.'</a>'; //タームのリンク
      // }
    ?>
    <?php
    if(is_tax('brand-category')) {
      echo get_query_var('term');
    }
    ?>
    <?php
    search_form_html();
    ?>
  </div>
</nav>
<!-- /category-nav -->
