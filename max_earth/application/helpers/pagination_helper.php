<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('create_links'))
{
	function create_links($per_page,$total_rows,$base_url)
	{		
		$CI = & get_instance();
		
		$CI->load->library('pagination');
		
		$base_url = preg_replace('/(&per_page=\d)/i', '', $base_url);
		
		$config['per_page'] = $per_page; 
		$config['page_query_string']= TRUE;			
		$config['num_links'] = 20;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li class="paginate_button next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="paginate_button previous">';
		$config['prev_tag_close'] = '</li>';
		
		$config['base_url'] = $base_url;
		$config["total_rows"] = $total_rows;
		
		$CI->pagination->initialize($config);
		$links = $CI->pagination->create_links();
		return $links;
	}
}

if(!function_exists('create_links_front'))
{
	function create_links_front($per_page,$total_rows,$base_url)
	{		
		$CI = & get_instance();
		
		$CI->load->library('pagination');
		
		$config['per_page'] = $per_page; 
		$config['page_query_string']= TRUE;			
		$config['display_pages'] = FALSE;
		$config['next_link'] = 'NEXT > ';
		$config['next_tag_open'] = '<div class="next-link">';
		$config['next_tag_close'] = '</div>';
		$config['prev_link'] = '< PREVIOUS';
		$config['prev_tag_open'] = '<div class="previous-link">';
		$config['prev_tag_close'] = '</div>';
		
		$config['base_url'] = $base_url;
		$config["total_rows"] = $total_rows;
		
		$CI->pagination->initialize($config);
		$links = $CI->pagination->create_links();
		return $links;
	}
}
