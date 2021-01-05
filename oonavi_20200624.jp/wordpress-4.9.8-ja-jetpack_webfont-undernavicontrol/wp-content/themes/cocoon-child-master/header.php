<?php
/**
 * Cocoon WordPress Theme
 * @author: yhira
 * @link: https://wp-cocoon.com/
 * @license: http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */
if ( !defined( 'ABSPATH' ) ) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
<?php //ヘッドタグ内挿入用のアクセス解析用テンプレート
get_template_part('tmp/head-analytics'); ?>
<meta charset="utf-8">
<?php //AMPの案内タグを出力
if ( has_amp_page() ): ?>
<link rel="amphtml" href="<?php echo get_amp_permalink(); ?>">
<?php endif ?>





<?php //Google Search Consoleのサイト認証IDの表示
if ( get_google_search_console_id() ): ?>
<!-- Google Search Console -->
<meta name="google-site-verification" content="<?php echo get_google_search_console_id() ?>" />
<!-- /Google Search Console -->
<?php endif;//Google Search Console終了 ?>





<?php //Google Tag Manager
if (is_analytics() && $tracking_id = get_google_tag_manager_tracking_id()): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $tracking_id; ?>');</script>
<!-- End Google Tag Manager -->
<?php endif //Google Tag Manager終了 ?>

<?php // force Internet Explorer to use the latest rendering engine available ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php // mobile meta (hooray!) ?>
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1"/>

<?php //自動アドセンス
get_template_part('tmp/ad-auto-adsense'); ?>


<?php wp_head(); ?>

<?php //カスタムフィールドの挿入（カスタムフィールド名：head_custom
get_template_part('tmp/head-custom-field'); ?>

<?php //headで読み込む必要があるJavaScript
get_template_part('tmp/head-javascript'); ?>

<?php //ヘッドタグ内挿入用のユーザー用テンプレート
get_template_part('tmp-user/head-insert'); ?>
</head>





<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">

<?php //body最初に挿入するアクセス解析ヘッダータグの取得
get_template_part('tmp/body-top-analytics'); ?>

<?php //ユーザーカスタマイズ用
get_template_part('tmp-user/body-top-insert'); ?>

<?php //サイトヘッダーからコンテンツまでbodyタグ最初のHTML
get_template_part('tmp/body-top'); ?>

<!-- ヘッダーへウィジェット追加 -->
<?php dynamic_sidebar('header-right'); ?>







<?php
$select_site=$_GET["select_site"];



if($select_site==2){
print <<< eof
<!-- Begin Yahoo Search Form -->
<html>
<body>
<div class="search-box input-box">
<form method="get" action="http://search.yahoo.co.jp/search" target="_blank">
<p style="margin:0;padding:0;">
<a href="http://www.yahoo.co.jp/" target="_blank"></a>
<input type=text placeholder="グローバル検索" name=p class="search-edit" aria-label="input">
<input type="hidden" name="fr" value="yssw">
<input type="hidden" name="ei">
<button type="submit" class="search-submit" role="button" aria-label="button"></button>
</p>
</form>
</div>
</body>
</html>
<!-- End Yahoo! Search Form -->
eof;
}




else if($select_site==3){
print <<< eof
<!-- Begin Bing Search Form -->
<html>
<body>
<div class="search-box input-box">
<form method="get" action="http://www.bing.com/search" target="_blank">
<p style="margin:0;padding:0;">
<a href="http://www.bing.com/" target="_blank"></a>
<input type=text placeholder="グローバル検索" name=q class="search-edit" aria-label="input" value="">
<input type="hidden" name="q1" value="">
</p>
<button type="submit" class="search-submit" role="button" aria-label="button"></button>
</form>
</div>
</body>
</html>
<!-- End Bing Search Form -->
eof;
}










else{
print <<< eof
<!-- Google  -->
<html>
<body>
<div class="search-box input-box">
<form method="get" action="http://www.google.co.jp/search" target="_blank">
<p style="margin:0;padding:0;">
<a href="http://www.google.co.jp/" target="_blank"></a>
<input type=text placeholder="グローバル検索" name=q class="search-edit" aria-label="input">
<input type=hidden name=ie>
<input type=hidden name=oe>
<input type=hidden name=hl value="ja">
<button type="submit" class="search-submit" role="button" aria-label="button"></button>
</p>
</form>
</div>
</body>
</html>
<!-- Google -->
eof;
}

?>





<?php
//初期設定
$selected["select_site"]=array_fill_keys([1,2,3],'');

//値セット
$selected["select_site"][filter_input(INPUT_GET,"select_site")]=" selected";



print <<< eof
<html>
<body>
<p>
<div class="global_search_select">
<form method="GET" action="">
<select name="select_site">
<option value="1"{$selected["select_site"][1]}>google</option>
<option value="2"{$selected["select_site"][2]}>yahoo!</option>
<option value="3"{$selected["select_site"][3]}>bing</option>
</select>
<button type="submit" class="select_submit" role="button" aria-label="button"></button>
</form>
</div>
</p>
</body>
</html>
eof;

?>





<?php
// echo "選択サイトは、「".$_GET["select_site"] ."」です。";
?>

