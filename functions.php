<?php


//========================================================================================
//管理画面左メニュー 表示設定
//========================================================================================
function remove_menus () {
    global $menu;
    unset($menu[2]);  // ダッシュボード
    // unset($menu[4]);  // メニューの線1
    unset($menu[5]);  // 投稿
    unset($menu[10]); // メディア
    // unset($menu[15]); // リンク
    unset($menu[20]); // ページ
    unset($menu[25]); // コメント
    // unset($menu[59]); // メニューの線2
    // unset($menu[60]); // テーマ
    // unset($menu[65]); // プラグイン
    // unset($menu[70]); // プロフィール
    // unset($menu[75]); // ツール
    // unset($menu[80]); // 設定
    // unset($menu[90]); // メニューの線3
}
add_action('admin_menu', 'remove_menus');


//========================================================================================
//* PHPの正規表現でHTMLからimgタグを取得する方法
//========================================================================================

function get_content_image ( $content ) {

	$pattern = '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i';

	if ( preg_match( $pattern, $content, $images ) ){
		if ( is_array( $images ) && isset( $images[1] ) ) {
			return $images[1];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

add_action('init', 'get_content_image');
//========================================================================================
//* カスタムフィールドを検索対象に含めます。(「-キーワード」のようなNOT検索にも対応します)
//========================================================================================
function posts_search_custom_fields( $orig_search, $query ) {
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		// 4.4のWP_Query::parse_search()の処理を流用しています。(検索語の分割処理などはすでにquery_vars上にセット済のため省きます)
		global $wpdb;
		$q = $query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';
		$searchand = '';

		foreach ( $q['search_terms'] as $term ) {
			$include = '-' !== substr( $term, 0, 1 );
			if ( $include ) {
				$like_op  = 'LIKE';
				$andor_op = 'OR';
			} else {
				$like_op  = 'NOT LIKE';
				$andor_op = 'AND';
				$term     = substr( $term, 1 );
			}
			$like = $n . $wpdb->esc_like( $term ) . $n;
			// カスタムフィールド用の検索条件を追加します。
			$search .= $wpdb->prepare( "{$searchand}(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s) $andor_op (custom.meta_value $like_op %s))", $like, $like, $like );
			$searchand = ' AND ';
		}
		if ( ! empty( $search ) ) {
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() )
				$search .= " AND ($wpdb->posts.post_password = '') ";
		}
		return $search;
	}
	else {
		return $orig_search;
	}
}
add_filter( 'posts_search', 'posts_search_custom_fields', 10, 2 );
/**
 * カスタムフィールド検索用のJOINを行います。
 */
function posts_join_custom_fields( $join, $query ) {
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		// group_concat()したmeta_valueをJOINすることでレコードの重複を除きつつ検索しやすくします。
		global $wpdb;
		$join .= " INNER JOIN ( ";
		$join .= " SELECT post_id, group_concat( meta_value separator ' ') AS meta_value FROM $wpdb->postmeta ";
		// $join .= " WHERE meta_key IN ( 'test' ) ";
		$join .= " GROUP BY post_id ";
		$join .= " ) AS custom ON ($wpdb->posts.ID = custom.post_id) ";
	}
	return $join;
}
add_filter( 'posts_join', 'posts_join_custom_fields', 10, 2 );


//========================================================================================
//画像貼り付け時の自動挿入タグを削除
//========================================================================================
add_filter( 'image_send_to_editor', 'remove_image_attribute', 10 );
add_filter( 'post_thumbnail_html', 'remove_image_attribute', 10 );

function remove_image_attribute( $html ){
	$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
	$html = preg_replace( '/class=[\'"]([^\'"]+)[\'"]/i', '', $html );
	return $html;
}

//========================================================================================
// 管理画面タクソノミー絞込検索用
//========================================================================================

function add_post_taxonomy_restrict_filter() {
    global $post_type;
    if ( 'brands' == $post_type ) {
        ?>
        <select name="brand-category">
            <option value="">商材選択</option>
            <?php
            $terms = get_terms('brand-category');
            foreach ($terms as $term) { ?>
                <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>
        <select name="person">
            <option value="">人物あり・なし</option>
            <?php
            $terms = get_terms('person');
            foreach ($terms as $term) { ?>
                <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>
        <select name="color">
            <option value="">color</option>
            <?php
            $terms = get_terms('color');
            foreach ($terms as $term) { ?>
                <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>
        <select name="size">
            <option value="">サイズ</option>
            <?php
            $terms = get_terms('size');
            foreach ($terms as $term) { ?>
                <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>
        <?php
    }
}
add_action( 'restrict_manage_posts', 'add_post_taxonomy_restrict_filter' );

//========================================================================================
// カスタム投稿タイプ タクソノミー追加
//========================================================================================


function create_post_type() {

  //通常バナー投稿
  register_post_type(
   'brands',
   array(
     'label' => 'バナー投稿',
     'public' => true,
     'has_archive' => true,
     'rewrite' => array('with_front' => false ),
     'menu_position' => 5,
     'supports' => array( 'title', 'thumbnail'),
     'taxonomies' => array( 'genre' )
   )
 );

  register_taxonomy(
    'brand-category',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => '商材カテゴリ',
      'singular_label' => '商材カテゴリ',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'brand-category' )
    )
  );

  register_taxonomy(
    'color',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => 'カラー',
      'singular_label' => 'カラー',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'color' )
    )
  );
  register_taxonomy(
    'person',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => '人物',
      'singular_label' => '人物',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'person' )
    )
  );

  register_taxonomy(
    'size',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => 'サイズ',
      'singular_label' => 'サイズ',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'size' )
    )
  );
  register_taxonomy(
    'tag',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => 'タグ',
      'singular_label' => 'タグ',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'tag' )
    )
  );

  //20分バナーカスタム投稿タイプ
  register_post_type(
   'twentyminutesbnr',
   array(
     'label' => '20分バナー投稿',
     'public' => true,
     'has_archive' => true,
     'rewrite' => array('with_front' => false ),
     'menu_position' => 5,
     'supports' => array( 'title' , 'thumbnail'),
     'taxonomies' => array( 'genre' )
   )
  );

  register_taxonomy(
    'bnr_theme',
    'twentyminutesbnr',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => 'お題',
      'singular_label' => 'お題',
      'public' => true,
      'show_ui' => true,
      'rewrite' => array( 'slug' => 'bnr_theme' )
    )
  );

}
add_action( 'init', 'create_post_type' );


function wp_redirect_url_swithc($url){
  $http = is_ssl() ? 'https' : 'http' . '://';
  $url = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  $url = strtok($url, '?');
  return $url;
}
add_action('wp','wp_redirect_url_swithc');

//========================================================================================
// 検索中表示機能
//========================================================================================

// （タクソノミーと）タームのリンクを取得する
function custom_taxonomies_terms_links(){
  // 投稿 ID から投稿オブジェクトを取得
  $post = get_post( $post->ID );

  // その投稿から投稿タイプを取得
  $post_type = $post->post_type;

  // その投稿タイプからタクソノミーを取得
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $all_taxonomies = get_taxonomies( array(
    'public'   => true,
    '_builtin' => false
  ) );
  // $relust_tax_getparams = [];
  //全タクソノミーをINPUT_GETで取得
  foreach ($all_taxonomies as $all_taxonomie) {
    $all_taxonomie_Array = explode(' ' , filter_input(INPUT_GET, $all_taxonomie));
    $relust_tax_getparams[] = $all_taxonomie_Array;
  }

  //絞込検索された投稿のタクソノミーだけ表示
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){
    // 投稿に付けられたタームを取得

    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    var_dump($terms);

    if ( !empty( $terms ) ) {
      foreach ( $terms as $term ) {

        $term_getparams = explode(' ', $term->slug);
        // var_dump($term->slug);

      }
    }
  }
}

function search_current_tag(){
  $taxonomies = get_taxonomies( array(
    'public'   => true,
    '_builtin' => false
  ) );
  $terms = get_terms( $taxonomie, 'hide_empty=0' );

  $html .= '<ul id="search_current_tag">';
  foreach( $taxonomies as $key => $taxonomie ) {
    if($tax_getparams = filter_input(INPUT_GET, $taxonomie)) {
      $tax_getparams = explode(' ', $tax_getparams);
    }
    else {
      $tax_getparams = array();
    }
    if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
      foreach ( $terms as $key => $term ) {
        if(in_array($term->slug, $tax_getparams)) {
          $html .= '<li>'.$term->name.'</li>';
        }
      }
    }
  }
  $html .= '</ul>';
  echo $html;
}

//========================================================================================
// 通常バナー 絞込検索用のメニュー
//========================================================================================

//*
//タクソノミーとタームからフォームを作る関数
//*
function search_form_sidenav() {

  global $wp_query, $query;

  $urlArray = explode('/', wp_redirect_url_swithc($url));

  //投稿者ページだったら
  if(in_array('author',$urlArray )){
    $action = wp_redirect_url_swithc($url);
  }
  else {
    $action = home_url( '/' );
  }

  $html .= '<form method="post" id="searchform" action="' . $action . '">';
  $html .= '<input type="hidden" name="s" value="">';


  $taxonomies = get_taxonomies( array(  //全タクソノミーを配列で取得
    'public'   => true,
    '_builtin' => false
  ) );

  foreach( $taxonomies as $key => $taxonomie ) {  //タクソノミー配列を回す
    switch ($taxonomie) {
      case 'bnr_theme':
      break;
      case 'color':
        $html .= '<dl class="search_taxonomie color"><dt>' . get_taxonomy($taxonomie)->labels->name . '</dt>';
        break;
      default:
        $html .= '<dl class="search_taxonomie"><dt>' . get_taxonomy($taxonomie)->labels->name . '</dt>';
        break;
    }
    if($tax_getparams = filter_input(INPUT_GET, $taxonomie)) {
      $tax_getparams = explode(' ', $tax_getparams);
    }
    else {
      $tax_getparams = array();
    }

    $terms = get_terms( $taxonomie, 'hide_empty=0' );   //各タクソノミーのタームを取得
    if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
      foreach ( $terms as $key => $term ) {

        if(in_array($term->slug, $tax_getparams)) {
          $checked = "checked";
        }
        else {
          $checked = "";
        }

        switch ($taxonomie) {
          case 'bnr_theme':
          break;
          case 'color':
            $html .= '<dd class="'. $term->slug . '"><input type="checkbox" id="' . $term->slug . '" name="' . $term->taxonomy . '[]" value="' . $term->slug  . '"' . ' ' . $checked . '><label for="' . $term->slug . '" class="checkbox"><span class="color-tip"></span></label><span class="bubble">' . $term->name  . '</span></dd>';
              break;
          default:
          $html .= '<dd><input type="checkbox" id="' . $term->slug . '" name="' . $term->taxonomy . '[]" value="' . $term->slug . '"' . ' ' . $checked . '><label for="' . $term->slug . '" class="checkbox">' . $term->name  . '</label></dd>';
            break;
        }

      }
      $html .= '</dl>';
      if($taxonomie != 'bnr_theme'){
          $html .= '<div class="clear"><div class="searchsubmit"><input type="submit" class="searchsubmit" value="OK"></div></div>';
      }
    }

  }

  $html .= '</form>';

  echo $html;  //作成したフォームを返す

}


//*
// カスタムクエリ追加
//*
function myQueryVars( $public_query_vars ) {

  $taxonomies = get_taxonomies( array(  //前回作ったタクソノミーを取得
  'public'   => true,
  '_builtin' => false
  ) );

  foreach ( $taxonomies as $taxonomie ) {  //それを回す
    $public_query_vars[] = $taxonomie;  //カスタムクエリを既存のクエリに追加
  }


  return $public_query_vars;
}
add_filter( 'query_vars', 'myQueryVars' );  //SQL が生成される前に、WordPress のパブリッククエリ変数のリストに対して適用される。

//*
//?brand-category=onamae&person=no-person&color=c1&s= の様なパラメーターを作る
//*
function myRequest( $vars ) {

  $taxonomies = get_taxonomies( array(  //タクソノミー配列取得
    'public'   => true,
    '_builtin' => false
  ) );

  foreach( $taxonomies as $taxonomie ) {  //タクソノミー配列回す
    $terms = get_terms( $taxonomie, 'hide_empty=0' );  //タームオブジェクト取得


    if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
      foreach ( $terms as $key => $term ) {  //タームオブジェクト回す
        if ( !empty( $vars[$term->taxonomy] ) && is_array( $vars[$term->taxonomy] ) ) {  //クエリに選択したタクソノミーが含まれていたら
          $vars[$term->taxonomy] = implode( '+', $vars[$term->taxonomy] );  //プラスで連結してクエリに入れる

        }
      }
    }
  }
  //*
  //投稿者用のパラメーター足す
  //*
  // $users = get_users( array('orderby'=>ID,'order'=>ASC) );
  // foreach ($users as $user) {
  //   if(!empty( $vars["author"] ) && is_array( $vars["author"] )){
  //     $vars["author"] = implode( '+', $vars["author"] );
  //   }
  // }

  if ( isset( $_POST['s'] ) && !empty( $vars )) { //検索フォームから来ていて、クエリからじゃなかったら

    $gets = array();

    $url = wp_redirect_url_swithc($url) . "?";
    foreach( $vars as $key => $val ) {

      if ($key == 's') {
        $val = str_replace('&', '%26', $val);  //文字化けとかしないようにして
      }
      if ( strlen( $val ) > 0 ) {
        if ( mb_detect_encoding( $val ) !== 'ASCII' ) {  //しないようにして
          $val = urlencode( $val );
        }
        $gets[] = "{$key}={$val}";
      }

    }
    if ( empty( $vars['s'] ) ) {
      $gets[] = "s=";
    }

    wp_redirect( $url . implode( '&', $gets ) );  //?brands=over-30000+over-135000&s=みたいにして/brands/にリダイレクト
    exit;
  }

  return $vars;
}
add_filter( 'request', 'myRequest');   //追加クエリ変数・プライベートクエリ変数が追加された後に適用される。


//*
//パラメーターを元にtax_queryを作る
//*
function myFilter( $query ) {

  if (is_admin()) {
    return $query;
  }
  global $wp_query;

  //post_type 20分バナー以外brands
  if ($query->query["post_type"] != "twentyminutesbnr") {
    $query->set("post_type", "brands");
  }

  if ( !array_key_exists( 's', $query->query ) ) { //詳細ページの場合
    return $query;  //そのまま表示
  } else {
    if ( $query->get('name') ) {  //違ったらnameをクエリから取り除く
      unset($wp_query->query['name']);
    }
  }

  if ( $query->get( 'post_type' ) === 'brands') {
    $args = $wp_query->query;
    $meta_query = array();
    $tax_query = array();

    $taxonomies = get_taxonomies( array(
      'public'   => true,
      '_builtin' => false
    ));

    //*
    //tax_queryを作っていく
    //*
    foreach( $taxonomies as $taxonomie ) {
      $terms = get_terms( $taxonomie, 'hide_empty=0' );
      if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
        foreach ( $terms as $key => $term ) {

          if ( array_key_exists( $taxonomie, $wp_query->query ) ) {

            $slug = $query->get('brands');

            $slug = $query->get($taxonomie);
            $slug = explode( '+', $slug );
            $tax_query[] = array(
              'relation' => 'AND',
              array(
                'taxonomy' => $taxonomie,
                'field' => 'slug',
                'terms' => $slug,
                'operator' => 'IN',
              )
            );
            unset($args[$taxonomie]);
            break ;
          }

        }
      }
    }

    //クエリを作りなおしたら
    $args['meta_query'] = $meta_query;
    $args['tax_query'] = $tax_query;

    //古いの消して
    $query->init();
    $query->parse_query( $args );  //新しいクエリにする
    $query->is_search = true;      //検索ページだよってことにする

  }

  return $query;
}

add_filter('pre_get_posts','myFilter');  //クエリを実行する前に呼び出し
