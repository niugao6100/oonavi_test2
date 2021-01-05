<?php get_header( 'xxx' ); ?>

<?php
    $search_query = get_search_query();
    
    
    $search_query1 = str_replace('　', ' ', $search_query);
    $search_query1 = trim($search_query1);
    $search_query1 = preg_replace('/\s+/', ' ', $search_query1);
    $search_query1 = explode(' ',$search_query1);
    $br = '<br>';
    
    //echo $search_query1[0];
    //echo $search_query1[1];
    //echo $search_query1[2];
    
    //コンフィグテーブルより、表示列数取得
    $sql_c_grp_col = $wpdb->get_results("select c_grp_col from o_cfg");
    $arr_c_grp_col = current($sql_c_grp_col);
    $col_cnt = current($arr_c_grp_col);
    
    $sql_o_grp = $wpdb->get_results('select g_id, g_name, g_url from o_grp where g_name like "%'.$search_query.'%" || g_url like "%'.$search_query.'%" order by g_rnk');
    $sql_o_site = $wpdb->get_results('select s_grp_to_g_id, s_name, s_url from o_site where s_name like "%'.$search_query.'%" || s_url like "%'.$search_query.'%" order by s_rnk');
	$arr_o_grp = current($sql_o_grp);		$g_size = count($sql_o_grp);
	$arr_o_site = current($sql_o_site);		$s_size = count($sql_o_site);


?>
 
<h1><?php echo $search_query; ?>の検索結果</h1>
<p><?php echo $s_size; ?>件のサイトがヒットしました。</p>
 
<?php
	if( $search_query == "" )
	{
		?> 一致する情報は見つかりませんでした。<?php 
	}
	else if( $s_size > 0 )
	{
		for( $i=0; $i<$s_size; $i++ )
		{
			$g_id = current($arr_o_site);
		    $sql_o_grp = $wpdb->get_results('select g_name from o_grp where g_id = '.$g_id.' order by g_rnk');
		    $arr_o_grp = current($sql_o_grp);
			$g_name = current($arr_o_grp);
			$html = '<strong><font size=4>'.$g_name.'</font></strong><br><table class="wp-block-table"><tbody>';
			echo $html;
			$sql_o_site1 = $wpdb->get_results('select s_name, s_url from o_site where s_grp_to_g_id = '.$g_id.' && (s_name like "%'.$search_query.'%" || s_url like "%'.$search_query.'%") order by s_rnk');
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
		for( $i=0; $i<$g_size; $i++ )
		{
			$g_id = current($arr_o_grp);
			$g_name = next($arr_o_grp);	$g_url = "https://oonavi.jp/grp/?id=".next($arr_o_grp);
			$html = '<strong><font size=5><a href='.$g_url.' target="_blank">'.$g_name.'</a></font></strong><br><table class="wp-block-table"><tbody>';
			echo $html;

			//グループ毎のサイト数取得
			$sql_o_site = $wpdb->get_results('select s_name, s_url from o_site where s_grp_to_g_id = '.$g_id.' && (s_name like "%'.$search_query.'%" || s_url like "%'.$search_query.'%") order by s_rnk');
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
		echo $search_query; ?> に一致する情報は見つかりませんでした。<?php 
	} ?>


<?php get_footer( 'xxx' ); ?>