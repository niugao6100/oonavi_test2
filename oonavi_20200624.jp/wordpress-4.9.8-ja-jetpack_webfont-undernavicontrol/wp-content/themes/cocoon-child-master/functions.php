<?php //子テーマ用関数
if ( !defined( "ABSPATH" ) ) exit;

//子テーマ用のビジュアルエディタースタイルを適用
add_editor_style();

//以下に子テーマ用の関数を書く
//ヘッダー下にウィジェットエリア追加
register_sidebar(array(
     "name" => "ヘッダーウィジェット" ,
     "id" => "header-right" ,
     "before_widget" => "<div class=ad-header-widget>",
     "after_widget" => "</div>",
     "before_title" => "<h3 class=header-widget_title>",
     "after_title" => "</h3>",
));

//以下　ショートコード追加
function shortcode_func() 	//Topページ　ロゴ部　表示用
{
	global $wpdb;
	$u_id =  wata_get_user_id();
	
	//表示ロゴ数取得　コンフィグデータ取得
	$sql_cnf = $wpdb->get_results("SELECT c_logo_cnt from o_cfg");
	$arr_logo = current($sql_cnf);
	$logo_cnt = current($arr_logo);

	$results = $wpdb->get_results("SELECT s_url, s_logo_img FROM o_site where s_id_to_user_id = $u_id and s_logo_rnk is not null and s_flg = 0 order by s_logo_rnk");
	//HTML作成
	$html;
	$html = $html."<script>  $(function(){ Sortable.create(dragHandle); }); </script>";
	$html = $html."<div id=\"dragHandle\">";
	for ($i = 1; $i <= $logo_cnt; $i++)
	{
		$arr = current($results);
		//url取得　HTML形式で結合
		$l_url = current($arr);
		$l_img = next($arr);
		//$l_url = $arr->l_url;
		//$l_img = $arr->l_img;
		$html = $html."<a href=$l_url target=_blank><img class=alignnone wp-image-28 src=$l_img /></a>　　";
		next($results);	
	}
	$html = $html."</div>";
	return $html;
}
add_shortcode("logo_cnt", "shortcode_func");

function shortcode_func2($page) 	//Topページ　テーブル部　表示用
{
	$siteurl = get_bloginfo("wpurl");
	global $wpdb;
	$u_id =  wata_get_user_id();
	$html = "";
	//1ページに15行表示
	$get_row_num = 15;
	if ($page == 0) {
		$start = 0;
		//HTML作成
		$html = "<table class=wp-block-table><tbody>";
	} else {
		$start = $get_row_num * $page;
	}
	//表示行、列数取得SQL
	$sql_cnf = $wpdb->get_results("SELECT c_row, c_col from o_cfg");
	$arr_size = current($sql_cnf);
	$row_size = current($arr_size);
	$col_size = next($arr_size);
	//ランク順にてid、グループ名、固定ページリンク取得SQL
	$sql_grp = $wpdb->get_results("SELECT g_id, g_name FROM o_grp where g_id_to_user_id = $u_id and g_flg = 0 order by g_rnk limit $start, $get_row_num");
	$count = count($sql_grp);
	if ($count <= 0) {
		return "end";
	}
	//行数分繰り返し
	for ($i = 1; $i <= $count; $i++)
	{
		//id、グループ名、固定ページリンク取得
		$arr_grp = current($sql_grp);
		$grp_id = current($arr_grp);
		$grp_name = next($arr_grp);
		$grp_url = $siteurl."/grp/?id=".$grp_id;
		//サイト名、URL取得のSQL文
		$sql_site = $wpdb->get_results("SELECT s_name, s_url FROM o_site where s_id_to_user_id = $u_id and s_flg = 0 and s_id_to_grp_id = $grp_id order by s_rnk");
		$arr_site = current($sql_site);
		$html = $html."<tr><td><strong><a href=$grp_url target=_blank>$grp_name</a></strong></td>";
		//列数分繰り返し
		for ($j = 1; $j <= $col_size; $j++)
		{	
			$arr_site = current($sql_site);
			$site_name = current($arr_site);
			$site_url = next($arr_site);
			$html = $html."<td><a href=$site_url target=_blank>$site_name</a></td>";
			next($sql_site);
		}
		$html = $html."</tr>";
		next($sql_grp);	
	}
	if ($page == 0) {
		$html=$html."</tbody></table>";
	}
	return $html;
}
add_shortcode("tablele", "shortcode_func2");

function shortcode_func3($arg) {	//カテゴリページ　表示用
	extract(shortcode_atts(array("g_id" => "1", "col_cnt" => "5" ), $arg));
	$url = $_REQUEST["id"];
	global $wpdb;
	$u_id =  wata_get_user_id();
	$cnt = 1;
	//タイトル取得
	$sql_g_id = $wpdb->get_results("SELECT g_id, g_name from o_grp where g_id ='$url' and g_id_to_user_id = $u_id and g_flg = 0");
	$arr_g_id = current($sql_g_id);
	$g_id = current($arr_g_id);
	$g_name = next($arr_g_id);
	//列数取得
	$sql_c_grp_col = $wpdb->get_results("SELECT c_grp_col from o_cfg");
	$arr_c_grp_col = current($sql_c_grp_col);
	$col_cnt = current($arr_c_grp_col);
	//表示数取得
	$sql_g_id_cnt = $wpdb->get_results("SELECT count(*) from o_site where s_flg = 0 and s_id_to_grp_id =$g_id and s_id_to_user_id = $u_id and s_flg = 0");
	$arr_g_id_cnt = current($sql_g_id_cnt);
	$g_id_cnt = current($arr_g_id_cnt);
	//ランク順にてサイト名、URL取得SQL
	$sql_site = $wpdb->get_results("SELECT s_name, s_url from o_site where s_flg = 0 and s_id_to_grp_id = $g_id and s_id_to_user_id = $u_id and s_flg = 0 order by s_rnk");
	$arr_site = current($sql_site);
	//HTML作成
	$html = "<h1>$g_name</h1><table class=wp-block-table><tbody>";
	$amari = $g_id_cnt%$col_cnt;
	for ($i = 1; $i <= $g_id_cnt/$col_cnt; $i++)
	{
		$html = $html."<tr>";
		for ($j = $cnt; $j <= $cnt + $col_cnt-1; $j++)
		{
			$arr_site = current($sql_site);
			$s_name = current($arr_site);
			$s_url = next($arr_site);
			$html = $html."<td><a href=$s_url target=_blank>$s_name</a></td>";
			$arr_site = next($sql_site);
		}
		$cnt = $cnt + $col_cnt;
		$html = $html."</tr>";
	}
	if($amari > 0)
	{
		$html = $html."<tr>";
		for($i = 1; $i <= $amari; $i++)
		{
			$arr_site = current($sql_site);
			$s_name = current($arr_site);
			$s_url = next($arr_site);
			$html = $html."<td><a href=$s_url target=_blank>$s_name</a></td>";
			next($sql_site);
		}
		$html = $html."</tr>";
	}
	return $html."</tbody></table>";
}
add_shortcode("sample", "shortcode_func3");

//関数追加　wata
function wata_get_user_id()	//ユーザーID取得
{
	global $wpdb;
	global $current_user;
	$user_name = $current_user -> user_login;
	$u_id;
	//o_userからログインユーザー取得
	$sql_u_id = $wpdb->get_results("SELECT u_id from o_user where u_name_to_wp_user_login = $user_name");
	$arr_u_id = current($sql_u_id);
	if($arr_u_id !="")
	{
		$u_id = current($arr_u_id);
	}
	else
	{
		$u_id = 0;
	}
	return $u_id;
}

//javascriptの追加
function sample_scripts() {

  wp_enqueue_script( "Sortable", get_stylesheet_directory_uri()."/Sortable.min.js");
  wp_enqueue_script( "bottom", get_stylesheet_directory_uri()."/jquery.bottom-1.0.js");
  wp_enqueue_script( "scrollDown", get_stylesheet_directory_uri()."/scrollDown.js");
  

}
add_action( "wp_footer", "sample_scripts" );

//ajaxの追加
function add_ajaxurl() {
?>
    <script>
        var ajaxurl = "<?php echo admin_url( 'admin-ajax.php'); ?>";
    </script>
<?php
}
add_action( "wp_head", "add_ajaxurl", 1 );


//Scroll Down contents display
function ajax_get_new_posts() {
	$url     = wp_get_referer();
	$page = $_POST["page"];
	wp_reset_postdata();	
	if( strcmp($url, "https://oonavi.jp/") == 0) //topページ場合のみ、読み込む
	{
		echo  shortcode_func2($page);
	}
    die();
}
add_action( "wp_ajax_ajax_get_new_posts", "ajax_get_new_posts" );
add_action( "wp_ajax_nopriv_ajax_get_new_posts", "ajax_get_new_posts" );