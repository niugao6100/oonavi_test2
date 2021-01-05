<?php get_header( 'xxx' ); ?>

<?php
    $siteurl = get_bloginfo("wpurl");
	$search_query = get_search_query();
	$user_id = 0;
	$user_name = $current_user -> user_login;
	//o_userからログインユーザー取得
	$sql_u_id = $wpdb->get_results("SELECT u_id from o_user where u_name_to_wp_user_login = $user_name");
	$arr_u_id = current($sql_u_id);
	if($arr_u_id !="")
	{
		$user_id = current($arr_u_id);
	}
	else
	{
		$user_id = 0;
	}
	
    $search_query1 = str_replace('　', ' ', $search_query);
    $search_query1 = trim($search_query1);
    $search_query1 = preg_replace('/\s+/', ' ', $search_query1);
    $search_query1 = explode(' ',$search_query1);
    $br = '<br>';
    
    //echo $search_query1[0];
    //echo $search_query1[1];
    //echo $search_query1[2];
    
    //コンフィグテーブルより、表示列数取得
    $sql_c_grp_col = $wpdb->get_results("SELECT c_grp_col from o_cfg");
    $arr_c_grp_col = current($sql_c_grp_col);
    $col_cnt = current($arr_c_grp_col);
    
	$sql_o_grp = $wpdb->get_results("SELECT g_id, g_name from o_grp where g_id_to_user_id = $user_id and g_name like '%$search_query%' order by g_rnk");
	$sql_o_site = $wpdb->get_results("SELECT s_id_to_grp_id, s_name, s_url from o_site where s_id_to_user_id = $user_id and  s_name like '%$search_query%' or s_url like '%$search_query%' order by s_rnk");
	$arr_o_grp = current($sql_o_grp);		$g_size = count($sql_o_grp);
	$arr_o_site = current($sql_o_site);		$s_size = count($sql_o_site);


?>
 
<?php
	if( $search_query == "" )
	{
		?><h1><?php echo $search_query; ?>検索結果</h1>
		大変お手数なのですが、検索したい語句の入力をお願い申し上げ致します。<?php 
	}
	else if( $s_size > 0 )
	{
		?><h1><?php echo $search_query; ?>の検索結果</h1>
<p><?php echo $s_size; ?>件のサイトがヒットしました。</p><?php
		
		for( $i=0; $i<$s_size; $i )
		{
			$g_id = current($arr_o_site);
		    $sql_o_grp = $wpdb->get_results("SELECT g_name from o_grp where g_id_to_user_id = $user_id and g_id = $g_id order by g_rnk");
		    $arr_o_grp = current($sql_o_grp);
			$g_name = current($arr_o_grp);
			$g_url = $siteurl."/grp/?id=".$g_id;
			$html = '<strong><font size=5><a href='.$g_url.' target="_blank">'.$g_name.'</a></font></strong><br><table class="wp-block-table"><tbody>';
			echo $html;
			$sql_o_site1 = $wpdb->get_results("SELECT s_name, s_url from o_site where s_id_to_user_id = $user_id and s_id_to_grp_id = '$g_id' and (s_name like '%$search_query%' or s_url like '%$search_query%') order by s_rnk");
			$arr_o_site1 = current($sql_o_site1); $s_size1 = count($sql_o_site1);
			
			$row_size = $s_size1/$col_cnt;
			$amari = $s_size1%$col_cnt;
			if($row_size >= 1)
			{
				for( $j=1; $j <= $row_size; $j++ )
				{
					$cnt = 1;
					$html = '<tr>';
					for($k = $cnt; $k <= $cnt + $col_cnt-1; $k++)
					{
						$s_name = current($arr_o_site1);	$s_url = next($arr_o_site1);
						$html = $html.'<td><a href='.$s_url.' target="_blank">'.$s_name.'</a></td>';
						$arr_o_site1 = next($sql_o_site1);
						$arr_o_site = next($sql_o_site);
						$i++;
					}
					$cnt = $cnt + $col_cnt;
					$html = $html.'</tr>';
					echo $html;
				}
			}
			if($amari > 0)
			{
				$html = '<tr>';
				for( $j=1; $j <=$amari; $j++ )
				{
					$s_name = current($arr_o_site1);	$s_url = next($arr_o_site1);
					$html = $html.'<td><a href='.$s_url.' target="_blank">'.$s_name.'</a></td>';
					$arr_o_site1 = next($sql_o_site1);
					$arr_o_site = next($sql_o_site);
					$i++;
				}
				$html = $html.'</tr>';
				echo $html;
			}
			$arr_o_grp = next($sql_o_grp);
			$html = '</tbody></table>';
			echo $html;
		}
	}
	else if( $g_size > 0)
	{
		?><h1><?php echo $search_query; ?>の検索結果</h1>
<p><?php echo $s_size; ?>件のサイトがヒットしました。</p><?php
		for( $i=0; $i<$g_size; $i++ )
		{
			$g_id = current($arr_o_grp);
			$g_name = next($arr_o_grp);	
			$g_url = $siteurl."/grp/?id=".$g_id;
			$html = '<strong><font size=5><a href='.$g_url.' target="_blank">'.$g_name.'</a></font></strong><br><table class="wp-block-table"><tbody>';
			echo $html;

			//グループ毎のサイト数取得
			$sql_o_site = $wpdb->get_results("SELECT s_name, s_url from o_site where s_id_to_user_id = $user_id and s_id_to_grp_id = '$g_id' and (s_name like '%$search_query%' or s_url like '%$search_query%') order by s_rnk");
			$arr_o_site = current($sql_o_site); $s_size = count($sql_o_site);

			$row_size = $s_size/$col_cnt;
			$amari = $s_size%$col_cnt;
			if($row_size >= 1)
			{
				for( $j=1; $j <= $row_size; $j++ )
				{
					$cnt = 1;
					$html = '<tr>';
					for($k = $cnt; $k <= $cnt + $col_cnt-1; $k++)
					{
						$s_name = current($arr_o_site);	$s_url = next($arr_o_site);
						$html = $html.'<td><a href='.$s_url.' target="_blank">'.$s_name.'</a>';
						$arr_o_site = next($sql_o_site);
					}
					$cnt = $cnt + $col_cnt;
					$html = $html.'</tr>';
					echo $html;
				}
			}
			if($amari > 0)
			{
				$html = '<tr>';
				for($j = 1; $j <= $amari; $j++)
				{
					//$arr_site = current($sql_site);
					$s_name = current($arr_o_site);	$s_url = next($arr_o_site);
					$html = $html.'<td><a href='.$s_url.' target="_blank">'.$s_name.'</a></td>';
					$arr_o_site = next($sql_o_site);
				}
				$html = $html.'</tr>';
				echo $html;
			}
			$arr_o_grp = next($sql_o_grp);
			$html = '</tbody></table>';
			echo $html;
		}
	}	
	else
	{
		?><h1><?php echo $search_query; ?>の検索結果</h1><?php
		echo $search_query; ?> に一致する情報は見つかりませんでした。<?php 
	} ?>


<?php get_footer( 'xxx' ); ?>