<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csrf_test extends CI_Controller {


  public function index()
	{
		$this->load->helper('security');
		
		// 'csrf_protection' config must be true
		if ( ! $this->config->item('csrf_protection') )
		{
			$data['text'] = 'To use CSRF you must set <strong>csrf_protection</strong> option to true in configuration file!';
		}
		else
		{
			$data['text'] = 'You can move the mouse over the link and see the last 2 segments: the token name and the cookie name.<br />';
			
			// Appends CSRF arguments to url 
			$data['sample_link'] = csrf_site_url( 'csrf_test/result' );
		}
		
		$this->load->view('csrf_test', $data);
	}
	
	
	public function result()
	{
		$this->load->helper( array('security','url') );
		
		// If the check returns false, the app dies and shows the alert
		check_csrf_url();
		
		/*
		// If you prefer, you can make other than show default error (e.g. show another view or redirect)
		if ( check_csrf_url( '', false) )
		{
			// success
		}
		else
		{
			// failed
		}	  
		*/
		
		$data['text'] = '<strong>You passed the csrf validation!</strong><br /><br />The next link is WRONG: just to make you see the CSRF ERROR:';
		
		$data['sample_link'] = site_url( 'csrf_test/result/wrong_token_name.../wrong_cookie_name...' );
		$this->load->view('csrf_test', $data);
	}	
	
}

/* EOF */
