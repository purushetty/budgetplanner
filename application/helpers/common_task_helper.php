<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('CTH_paging'))
{
	function CTH_paging($tables='', $where='', $pg = 0, $rec_per_page='', $sql='' )
	{
		$CI =& get_instance();
		$paging_vars = array();
		if( $sql == '' )
		{
			$sql = "SELECT count(*) as total from ".$tables.$where;
			$query = $CI->db->query($sql);
			if( !$query )
			{
				CTH_log_db_error();
				return false;
			}
			$row = $query->row();
			$total_rec = $row->total;
		}
		else
		{
			$query = $CI->db->query($sql);
			if( !$query )
			{
				CTH_log_db_error();
				return false;
			}

			$rows = $query->result();
			$total_rec = count($rows);
		}

		if( $rec_per_page == '' )
		{
			$rec_per_page = $CI->session->userdata('pagenum');
			if($rec_per_page == "" || $rec_per_page == 0 )
			$rec_per_page = 20;
		}
		$nop = ceil($total_rec/$rec_per_page);
		if($pg=="" || $pg>$nop || $pg<1 )
			$pg = 1 ;
		$limit_start = $rec_per_page*$pg-$rec_per_page;

		$start_record = ($pg-1)*$rec_per_page+1;
		$end_record = $pg*$rec_per_page;
		if( $end_record > $total_rec )
			$end_record = $total_rec;

		if( $pg>1 )
		{
			$prev_page = $pg-1;
			$first_page = 1;
		}
		else
			$prev_page = $first_page = '';
		if( $pg<$nop )
		{
			$last_page = $nop;
			$next_page = $pg + 1;
		}
		else
			$last_page = $next_page = '';

		$paging_vars = array( "current_page"=>$pg, "total_pages"=>$nop, "total_rec"=>$total_rec,
							  "rec_per_page"=>$rec_per_page, "limit_start"=>$limit_start, 'start_record'=>$start_record,
							  'end_record'=>$end_record, 'first_page'=>$first_page, 'last_page'=>$last_page,
							  'prev_page'=>$prev_page, 'next_page'=>$next_page);
		return $paging_vars;
	}
}

if ( ! function_exists('CTH_paging_from_array'))
{
	function CTH_paging_from_array( $records, $rec_per_page, $pg )
	{
		$paging_vars = array();
		$total_rec = count($records);
		$nop = ceil($total_rec/$rec_per_page);
		if($pg=="" || $pg>$nop || $pg<1 )
			$pg = 1 ;
		$limit_start = $rec_per_page*$pg-$rec_per_page;

		$start_record = ($pg-1)*$rec_per_page+1;
		$end_record = $pg*$rec_per_page;
		if( $end_record > $total_rec )
			$end_record = $total_rec;

		if( $pg>1 )
		{
			$prev_page = $pg-1;
			$first_page = 1;
		}
		else
			$prev_page = $first_page = '';
		if( $pg<$nop )
		{
			$last_page = $nop;
			$next_page = $pg + 1;
		}
		else
			$last_page = $next_page = '';

		$paging_vars = array( "current_page"=>$pg, "total_pages"=>$nop, "total_rec"=>$total_rec,
							  "rec_per_page"=>$rec_per_page, "limit_start"=>$limit_start, 'start_record'=>$start_record,
							  'end_record'=>$end_record, 'first_page'=>$first_page, 'last_page'=>$last_page,
							  'prev_page'=>$prev_page, 'next_page'=>$next_page);
		return $paging_vars;
	}
}


if( ! function_exists('CTH_log_db_error'))
{
	function CTH_log_db_error()
	{
		$CI =& get_instance();
		$err_msg = $CI->db->_error_message();
		$err_num = $CI->db->_error_number();
		$err_query = $CI->db->last_query();
		log_message('error', 'Error Message: '.$err_msg.'<br />Error No: '.$err_num.'<br />Query Used: '.$err_query);
		//show_error('Sorry A DB Error Occured' , 500 );
	}
}

if( ! function_exists('CTH_addslashes'))
{
	function CTH_addslashes($data, $usenl2br=false)
	{
		if( is_array( $data ) )
		{
			foreach( $data as $key=>$val )
			{
				if(is_array($val))
					$data[$key] = CTH_addslashes($val);
				else if( !is_null($val) )
				{
					$val = htmlspecialchars($val,ENT_QUOTES);
					if($usenl2br)
						$val = nl2br($val);
					$data[$key] = addslashes($val);
				}
			}
			return $data;
		}
		else
		{
			return addslashes($data);
		}
	}
}

if( ! function_exists('CTH_stripslashes'))
{
	function CTH_stripslashes($data)
	{
		if( is_array( $data ) )
		{
			foreach( $data as $key=>$val )
			{
				if(is_array($val))
					$data[$key] = CTH_stripslashes($val);
				else if( !is_null($val) )
					$data[$key] = stripslashes($val);
			}
			return $data;
		}
		else
		{
			return stripslashes($data);
		}
	}
}

if( ! function_exists('CTH_array_column'))
{
	function CTH_array_column($array, $column)
	{
		$ret = array();
    	foreach ($array as $row) $ret[] = $row[$column];
    	return $ret;
	}
}

if( ! function_exists('CTH_debug_var'))
{
	function CTH_debug_var($var)
	{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
	}
}

if ( ! function_exists('CTH_user_funds'))
{
	function CTH_user_funds($printVal = TRUE)
	{
		$CI =& get_instance();

		if( $CI->session->userdata('user_id') )
		{
			$sql = "SELECT account_balance FROM users WHERE user_id = '".$CI->session->userdata('user_id')."'";
			$query = $CI->db->query($sql);
			$record = $query->result();
			if( $printVal )
				echo number_format($record[0]->account_balance,2);
			else
				return number_format($record[0]->account_balance,2);
		}
		else
		{
			if( $printVal )
				echo '0.00';
			else
				return '0.00';
		}
	}
}

if ( ! function_exists('CTH_user_notification'))
{
	function CTH_user_notification()
	{
		$CI =& get_instance();
		$sql = "SELECT * FROM `notifications` WHERE user_id = '".$CI->session->userdata('user_id')."' and `read` = 0";

		$query = $CI->db->query($sql);
		$record = $query->result();

		echo count($record);
	}
}
//Added by Karishma - To fetch for user unread chats is_read = 0
if ( ! function_exists('CTH_user_unread_chats'))
{
	function CTH_user_unread_chats()
	{
		$CI =& get_instance();
		$sql = "SELECT * FROM `chat` WHERE to_id = '".$CI->session->userdata('user_id')."' and `is_read` = 0";

		$query = $CI->db->query($sql);
		$record = $query->result();

		echo count($record);
	}
}
//Added by Karishma - To fetch for user unread chats

//Added by Karishma - To fetch for all the conversation for admin - is_admin_read
if ( ! function_exists('CTH_admin_chats'))
{
	function CTH_admin_chats()
	{
		$CI =& get_instance();
		$sql = "SELECT * FROM `chat` WHERE `is_admin_read` = 0 GROUP by article_id";

		$query = $CI->db->query($sql);
		$record = $query->result();

		echo count($record);
	}
}
//Added by Karishma - To fetch for user unread chats
if ( ! function_exists('CTH_excluded_words'))
{
	function CTH_excluded_words()
	{
		$CI =& get_instance();
		$sql = "SELECT * FROM `excluded_list`";

		$query = $CI->db->query($sql);
		$record = $query->result();

		$recs = array();

		if( count($record) )
		{
			foreach($record as $rec)
				$recs[] = $rec->words;
		}

		return $recs;
	}
}

if ( ! function_exists('CTH_send_notification'))
{
	function CTH_send_notification($email_to,$email_subject,$email_title,$art_price,$art_title,$comment,$comment_by)
	{
		$CI =& get_instance();

			$to  = $email_to;
			$subject = $email_subject;
			$message = $CI->load->view('email_temp',array('email_title'=>$email_title,'article_price'=>$art_price,'article_title'=>$art_title,'comment'=>$comment,'comment_by'=>$comment_by),true);
			$headers = 'From: support@dotwriter.com';
			$headers .= "\r\nContent-Type: text/html; charset=utf-8\r\n";
			$email_subject = "=?UTF-8?B?".base64_encode($subject)."?=\n";
			$mail = mail($to, $email_subject, $message, $headers);

		return 'Email Send Successfully';
	}
}

if ( ! function_exists('CTH_writer_category'))
{
	function CTH_writer_category($user_id, $status='Approved')
	{
		$CI =& get_instance();

		$CI->load->model('user_model');
		$get_user_row = $CI->user_model->get_row($user_id,'','','','');

		// update writer category
		$articles_approved = $get_user_row['articles_approved']?$get_user_row['articles_approved']:0;

		if( $status == 'Approved' )
		$final_approved_articles = $articles_approved + 1;
		else
		$final_approved_articles = $articles_approved;

		// To calculate The Approved Articles percent %
		$total_articles_submitted = $get_user_row['articles_written'] + 1;

		$approved_articles_percent = $final_approved_articles*100/$total_articles_submitted;

		// To update the writer category
		if( $final_approved_articles < 10 || $approved_articles_percent < 50)
		$change_category = 'Standard';
		else if( $final_approved_articles > 25 && $approved_articles_percent > 75 )
		$change_category = 'Gold';
		else
		$change_category = 'Premium';

		//if( $status != 'Approved' )
		$CI->user_model->update($user_id, array('articles_written'=>$total_articles_submitted, 'writer_category'=>$change_category));


		return array('change_category'=>$change_category,'final_approved_articles'=>$final_approved_articles);
	}
}


if ( !function_exists('CTH_update_stats'))
{
	function CTH_update_stats($col_name='dated', $price=1)
	{
		$CI =& get_instance();

		//echo $col_name."<-->".$price;
		//die();
		$CI->load->model('stats_model');
		$record = $CI->stats_model->get_row(date('Y-m-d'));
		if(is_array($record) && !empty($record))
		{
			//echo "update / insertquery+1 Record";
			$sql = "UPDATE stats SET ".$col_name." = ".$col_name." + ".($price?$price:1)." WHERE dated = '".$record['dated']."'";
			$CI->db->query($sql);
		}
		else
		{
			//echo "Insert record";
			$CI->db->insert('stats', array('dated'=>date('Y-m-d')));
			$rec_id = $CI->db->insert_id();
			$sql = "UPDATE stats SET ".$col_name." = ".$col_name." + ".($price?$price:1)." WHERE id = ".$rec_id;
			$CI->db->query($sql);
		}

	}
}

if ( ! function_exists('CTH_admin_stats'))
{
	function CTH_admin_stats($this_data, $last_data)
	{
		if( $this_data == $last_data )
			return '0.00';
		else if( $this_data == 0 && $last_data > 0 )
			return '-100.00';
		else if( $this_data > 0 && $last_data == 0 )
			return '100.00';
		else
		{
			$diff = count($this_data) - count($last_data);
			$prcnt = ( $diff * 100) / $last_data;
			return number_format($prcnt,2);
		}
	}
}

if ( ! function_exists('CTH_editor_rejected'))
{
	function CTH_editor_rejected($editor_id)
	{
		$CI =& get_instance();
		$sql = "UPDATE editors SET rejected_articles = rejected_articles + 1 WHERE editor_id = '".$editor_id."'";
		$CI->db->query($sql);
	}
}


