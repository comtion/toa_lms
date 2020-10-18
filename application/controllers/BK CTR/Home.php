<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "home";

		$this->load->model('News_model','news',TRUE);
		$arr['banners'] = $this->news->get_banner( $lang );
		$arr['hots'] = $this->news->get_hot( $lang,  4 );
		$arr['foods'] = $this->news->get_each( $lang, 'food', 3 );
		$arr['exercises'] = $this->news->get_each( $lang, 'exercise', 3 );
		$arr['moods'] = $this->news->get_each( $lang, 'mood', 3 );
		$arr['events'] = $this->news->get_each( $lang, 'news', 3 );
		$arr['videos'] = $this->news->get_each( $lang, 'video', 3 );

		/*$this->load->model('News_model','news',TRUE);
		$arr['banners'] = $this->news->get_banner( $lang );

		$arr['cptalks'] = $this->news->get_each( $lang, 'cptalk', 3 );

		$arr['cpnews'] = $this->news->get_each( $lang, 'cpnews', 4 );

		$arr['cpcsrs'] = $this->news->get_each( $lang, 'cpcsr', 4 );

		$arr['cpworlds'] = $this->news->get_each( $lang, 'cpworld', 4 );

		$arr['cpinternals'] = $this->news->get_each( $lang, 'cpinternal', 5 );

		$arr['cpreals'] = $this->news->get_each( $lang, 'cpreal', 7 );

		$arr['cpvideos'] = $this->news->get_each( $lang, 'cpvideo', 3 );

		$arr['cplifepluss'] = $this->news->get_each( $lang, 'cplifeplus', 4 );*/

		//$this->load->view('frontend/home', $arr );

		$this->load->view('frontend/home', $arr );
	}

	public function change( $type ){
		$this->session->set_userdata('lang',$type);
		redirect("","refresh");
	}
}
