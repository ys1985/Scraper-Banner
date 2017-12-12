<div id="sidenav-wrapper">
  <nav id="category-nav">
    <div class="scroller">
      <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a></h1>
      <?php
        search_form_sidenav("author");
      ?>

      <?php $users = get_users( array('orderby'=>ID,'order'=>ASC) ); ?>
      <div class="authors">
      <?php foreach($users as $user) {
      $uid = $user->ID; ?>
      <div class="author-profile">
      	<span class="author-thumbanil"><?php echo get_avatar( $uid ,40 ); ?></span>
      	<span class="author-link"><a href="<?php echo get_bloginfo("url") . '/?author=' . $uid ?>"><?php echo $user->display_name ; ?></a></span>
      </div>
      <?php } ?>
    </form>
    </div>
    <div id="sp-ico-menu">
      <div class="inner"><span></span><span></span></div>
    </div>
  </nav>
  <!-- /category-nav -->

</div>
