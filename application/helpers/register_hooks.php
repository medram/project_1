<?php

$CI =& get_instance();

function handle_page_content($content){
	global $CI;

	$countries = $CI->db->select('*')->from('countries')->join('publisher_rates', 'countries.id = publisher_rates.country_id')->get()->result();

	$data['countries'] = $countries;
	$data['world_wide'] = (float)get_config_item('world_wide');
	$data['currency'] = get_currency('currency');

	if (strpos($content, '{{PUBLISHER_RATES}}') !== false)
	{
		return str_replace('{{PUBLISHER_RATES}}', $CI->load->view('pages/publisher_rates_page', $data, true), $content);
	}

	return $content;
}

add_filter('page_content', 'handle_page_content');


