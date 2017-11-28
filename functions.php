<?php
add_theme_support('post-thumbnails');
// add_theme_support( 'menus' );

//========================================================================================
//カスタムメニューの位置を定義する
//========================================================================================
register_nav_menus(array(
    'category_menu' => '商材メニュー',
    'color_menu' => 'カラーメニュー'
));
register_nav_menus(array($location => $description));

//========================================================================================
//ウィジェット設定 サイドバーを定義する
//========================================================================================
add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
  register_sidebar( array(
  'name' => __( 'Main Sidebar', 'theme-slug' ),
  'id' => 'sidebar-1',
  'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
  'before_widget' => '<div id="%1$s" class="category-list">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="category_ttl">',
	'after_title'   => '</h2>',
    ) );
}

//========================================================================================
//カテゴリメニューに件数を表示
//========================================================================================
add_filter( 'wp_nav_menu_objects', 'article_count' );
function article_count( $items ) {
  foreach ( $items as $item ) {
      if ( $term = get_term( $item->object_id, $item->object ) ) {
          $item->title .= '<span class="menu_count">（'. $term->count .'）</span>';
      }
      $args[] = $item;
  }
  return $args;
}

function admin_categorybox_height(){
	?><style>#category-all{max-height:9999px}</style><?php
}
add_action('admin_head','admin_categorybox_height');


//========================================================================================
//カテゴリメニュー 大カテゴリチェックボックス非表示
//========================================================================================
// require_once(ABSPATH . '/wp-admin/includes/template.php');
// class Danda_Category_Checklist extends Walker_Category_Checklist {
//
//      function start_el( &$output, $category, $depth, $args, $id = 0 ) {
//         extract($args);
//         if ( empty($taxonomy) )
//             $taxonomy = 'category';
//
//         if ( $taxonomy == 'category' )
//             $name = 'post_category';
//         else
//             $name = 'tax_input['.$taxonomy.']';
//
//         $class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
//         //親カテゴリの時はチェックボックス表示しない
//         if($category->parent == 0){
//                $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit">' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
//         }else{
//             $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
//         }
//     }
//
// }
// function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
//     $args['checked_ontop'] = false;
//     $args['walker'] = new Danda_Category_Checklist();
//     return $args;
// }
// add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );



// require_once locate_template('lib/init.php');        // 初期設定の関数
// require_once locate_template('lib/cleanup.php');     // 不要なモノを削除する関数
// require_once locate_template('lib/titles.php');      // タイトル出力の関数
// require_once locate_template('lib/breadcrumbs.php'); // パンくずリストの関数
// require_once locate_template('lib/scripts.php');     // CSSやJavascript関連の関数
// require_once locate_template('lib/ads.php');         // 広告関連の関数
// require_once locate_template('lib/widgets.php');     // サイドバー、ウィジェットの関数
// require_once locate_template('lib/custom.php');      // その他カスタマイズの関数

//========================================================================================
// カスタム投稿タイプ 追加
//========================================================================================
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type(
   'brands',
   array(
     'label' => '商材投稿',
     'public' => true,
     'has_archive' => true,
     'rewrite' => array( 'with_front' => false ),
     'menu_position' => 5,
     'supports' => array( 'title', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'revisions' ),
     'taxonomies' => array( 'genre' ),
   )
 );

/* ここから */
  register_taxonomy(
    'brand-category',
    'brands',
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false */
      'update_count_callback' => '_update_post_term_count',
      'label' => '商材名',
      'singular_label' => '商材名',
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
/* ここまでを追加 */
}

//========================================================================================
// 絞込用の検索機能追加
//========================================================================================

//タクソノミーとタームからフォームを作る関数（archive-rent.phpとかから呼び出す関数）
function search_form_html() {
global $wp_query, $query;

$html = '<form method="post" id="searchform" action="' . home_url( '/' ) . '">';
$html .= '<input class="search_all" type="text" name="s"  id="s" value="' . $wp_query->get('s') . '" placeholder="検索したいキーワードを入力してください">';
$taxonomies = get_taxonomies( array(  //全タクソノミーを配列で取得
  'public'   => true,
  '_builtin' => false
) );
foreach( $taxonomies as $taxonomie ) {  //タクソノミー配列を回す
  $html .= '<dl class="search_taxonomie"><dt>' . get_taxonomy($taxonomie)->labels->name . '</dt>';
  $terms = get_terms( $taxonomie, 'hide_empty=0' );   //各タクソノミーのタームを取得
  if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
    foreach ( $terms as $key => $term ) {
      if($term->count > 0){ //各タームを回して
        $html .= '<dd><input type="checkbox" name="' . $term->taxonomy . '" value="' . $term->slug . '">' . $term->name . '<span class=="count">（' . $term->count . '）</span>' . '</dd>';  //インプットを作成
      }

    }
    $html .= '</dl>';
  }
}
$html .= '<input type="submit" class="searchsubmit" value="検索する">';
$html .= '</form>';

echo $html;  //作成したフォームを返す
}


// カスタムクエリ追加
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


//?rent=over-30000+over-135000&post_type=rent&key-money-deposit=30000+40000&s= の様なパラメーターを作る
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
if ( isset( $_POST['s'] ) && !empty( $vars ) ) {  //検索フォームから来ていて、クエリからじゃなかったら
  $url = home_url('/brands/') . "?";
  $gets = array();
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
  wp_redirect( $url . implode( '&', $gets ) );  //?rent=over-30000+over-135000&s=みたいにして/rent/にリダイレクト
  exit;
}
return $vars;
}
add_filter( 'request', 'myRequest');  //追加クエリ変数・プライベートクエリ変数が追加された後に適用される。


//パラメーターを元にtax_queryを作る
function myFilter( $query ) {
global $wp_query;

if ( !array_key_exists( 's', $query->query ) ) { //詳細ページの場合
  return $query;  //そのまま表示
} else {
  if ( $query->get('name') ) {  //違ったらnameをクエリから取り除く
    unset($wp_query->query['name']);
  }
}

if ( $query->get( 'post_type' ) === 'brands') {
  if ( count( $wp_query->query ) === 1 ) return $query;
  $args = $wp_query->query;
  $meta_query = array();
  $tax_query = array();

  $taxonomies = get_taxonomies( array(
    'public'   => true,
    '_builtin' => false
  ) );

  //tax_queryを作っていく
  foreach( $taxonomies as $taxonomie ) {
    $terms = get_terms( $taxonomie, 'hide_empty=0' );
    if ( ! empty( $terms ) && !is_wp_error( $terms ) ){
      foreach ( $terms as $key => $term ) {

        if ( array_key_exists( $taxonomie, $wp_query->query ) ) {

          $slug = $query->get('brands');

          $slug = $query->get($taxonomie);
          $slug = explode( '+', $slug );
          $tax_query[] = array(
            'taxonomy' => $taxonomie,
            'field' => 'slug',
            'terms' => $slug,
            'operator' => 'IN',
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
