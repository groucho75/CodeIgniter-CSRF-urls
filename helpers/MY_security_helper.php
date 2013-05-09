<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Security helper extended
 *
 * @package 	CodeIgniter
 * @subpackage 	Helper
 * @category 	Security
 */


/**
 * Append CSRF token to URL
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('csrf_site_url'))
{
	function csrf_site_url($uri = '')
	{	
		$CI =& get_instance();
		
		$CI->load->helper('url');
		
		// Make URI relative: trim base url
		if ( $uri != '' ) $uri = str_replace( site_url(), '', $uri );
		
		if ( $CI->config->item('csrf_protection') == false ) {
			 log_message('error', 'Helper: Security - csrf_protection is false');
		}
		
		$csrf_name 	= config_item('csrf_token_name');
		$csrf_value	= $CI->security->get_csrf_hash();
		
		if ( is_array($uri) )
		{
			$uri[] = $csrf_name;
			$uri[] = $csrf_value;
		}
		else
		{
			$uri = rtrim( $uri, '/' );
			$uri .= '/' . $csrf_name . '/' . $csrf_value;
		}
		return site_url($uri);
		
	}
}


/**
 * Check CSRF token appended to URL
 *
 * @access	public
 * @param	string	the url to check, or current URI if empty
 * @return	bol
 */
if ( ! function_exists('check_csrf_url'))
{
	function check_csrf_url( $uri='' )
	{	
		$CI =& get_instance();
		
		$CI->load->helper('url');
		
		if ( $CI->config->item('csrf_protection') == false )
		{
			log_message('error', 'Helper: Security - csrf_protection is false');
			return TRUE;
		}
		
		if ( $uri == '' )
		{	
			// Get current URI	
			$segments = $CI->uri->total_segments();
		}
		else
		{
			// Make URI relative: trim base url
			$uri = trim( str_replace( site_url(), '', $uri ), '/' );
			$uri_array = explode( '/', $uri );
			$segments = count( $uri_array );
		}
		
		// Less than 2 segments? Error
		if ( $segments < 2 )
		{
			$CI->security->csrf_show_error();
		}
		
		// Get appended CSRF
		if ( $uri == '' )
		{					
			$appended_csrf_name = $CI->uri->segment( ($segments-1) );
			$appended_csrf_value = $CI->uri->segment( $segments );
		}
		else
		{
			$appended_csrf_name = $uri_array[ ($segments-2) ];
			$appended_csrf_value = $uri_array[ ($segments-1) ];
		}
				
		// Get CSRF values form config
		$csrf_token_name = config_item('csrf_token_name');
		$csrf_cookie_name = config_item('csrf_cookie_name');
		
		if (config_item('cookie_prefix'))
		{
			$csrf_cookie_name = config_item('cookie_prefix').$csrf_cookie_name;
		}
		
		// The cookie is empty: false
		if ( ! isset($_COOKIE[$csrf_cookie_name]))
		{
			$CI->security->csrf_show_error();
		}

		// Check if match
		if ( $appended_csrf_name != $csrf_token_name || $appended_csrf_value != $_COOKIE[$csrf_cookie_name] )
		{
			$CI->security->csrf_show_error();
		}
		
		return TRUE;
	}
}

/* EOF */
