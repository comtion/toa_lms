<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

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
		redirect(base_url());
	}
	public function lists( $cat ){
    $lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('News_model','news',TRUE);
		$arr['lang'] = $lang;
		$arr['page'] = $cat;
		if( $cat == "video"){
			if( isset( $_GET['filter'] ) ){
				$start = isset( $_GET['start'] ) ? $_GET['start'] : "";
				$end = isset( $_GET['end'] ) ? $_GET['end'] : "";
				$cat_fil = isset( $_GET['cat'] ) ? $_GET['cat'] : "";
				$sortby = isset( $_GET['sortby'] ) ? $_GET['sortby'] : "";

				$arr['lists'] = $this->news->get_list_video_filter( $lang, $cat, $start, $end, $cat_fil, $sortby );
				$arr['cats'] = $this->news->get_all_cat();
				$arr['page'] = $cat;
				$this->load->view('frontend/video', $arr );
			}else{
				$arr['lists'] = $this->news->get_list_video( $lang, $cat );
				$arr['cats'] = $this->news->get_all_cat();
				$arr['page'] = $cat;

				$this->load->view('frontend/video', $arr );
			}

		}else{
			if( $cat == "food" || $cat == "exercise" || $cat == "mood" || $cat == "news"){
				$arr['cats'] = $this->news->get_all_cat();
				$lists = $this->news->get_list( $lang, $cat );
				$arr['lists'] = $lists;
				$tags = array();
				foreach( $lists as $list ){
					$tag_ar = explode(',', $list['cp_tag']);
					foreach( $tag_ar as $tag ){
						$tag = strtolower( $tag );
						$tag = trim($tag," ");
						if ( !in_array( $tag, $tags ) ){
					  	array_push($tags, $tag);
					  }
					}
				}
				$arr['tags'] = $tags;
		    $arr['page'] = $cat;
				$id = "";
				$arr['postviews'] = $this->news->get_postview( $id, $lang, $cat, 4 );
		    $this->load->view('frontend/category', $arr );
			}else{
				$this->load->view('frontend/comingsoon' );
			}

		}

	}

	public function details( $cat, $id ){
    $lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;

		$this->load->model('News_model','news',TRUE);
		$this->news->update_postview( $id );
		$arr['details'] = $this->news->get_details( $id, $cat , $lang);

    $arr['page'] = $cat;

		$arr['postviews'] = $this->news->get_postview( $id, $lang, $cat, 4 );

    $arr['relates'] = $this->news->get_relate( $id, $lang, $cat, 4 );

    $arr['cats'] = $this->news->get_all_cat();

    $this->load->view('frontend/content', $arr );
		//$this->session->set_userdata('lang',$type);
		//redirect("","refresh");
	}

	public function loadMore( $index, $cat ){
		$arr = array();
		$lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$this->load->model('News_model','news',TRUE);
		$lists = array();
		$lists = $this->news->get_load( $lang, $cat );
		//print_r( $lists );
		$this->load->helper('fn');
		$y = 0;
		$load = array();
		for( $i = $index ; $i < intval($index)+6 ; $i++ ){
			if( isset($lists[$i]) ){
				$load[$y] = $lists[$i];
				$load[$y]['cp_lastupdate'] = changeDate( $lists[$i]['cp_lastupdate'], $lang );
				$load[$y]['cp_postview'] = $lists[$i]['cp_postview'] == "" ? 0 : $lists[$i]['cp_postview'];
				$y++;
			}

		}
		//print_r($load);
		$arr['load'] = $load;
		$arr['rs'] = true ;
		echo json_encode($arr);
	}
	public function results( $cat = "", $tag_set = "" ){
    $lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$start = isset( $_GET['start'] ) ? $_GET['start'] : "";
		$end = isset( $_GET['end'] ) ? $_GET['end'] : "";
		$keyword = isset( $_GET['keyword'] ) ? $_GET['keyword'] : "";
		$search_head = isset( $_GET['search-head'] ) ? $_GET['search-head'] : "";

		$this->load->model('News_model','news',TRUE);
		if( $tag_set == ""){
			$lists = $this->news->get_result( $lang, $cat, $start, $end, $keyword, $search_head );
		}else{
			$lists = $this->news->get_result_tag( $lang, $cat, urldecode($tag_set) );
		}
		$arr['lists'] = $lists;
		$id = "";
		$arr['postviews'] = $this->news->get_postview( $id, $lang, $cat, 4 );
		$tags = array();
		if( sizeof($lists) > 0 ){
			foreach( $lists as $list ){
				$tag_ar = explode(',', $list['cp_tag']);
				foreach( $tag_ar as $tag ){
					$tag = strtolower( $tag );
					$tag = trim($tag, " ");
					if ( !in_array( $tag, $tags ) ){
				  	array_push($tags, $tag);
				  }
				}
			}
		}

		$arr['tags'] = $tags;

    $arr['page'] = $cat;

    $arr['cats'] = $this->news->get_all_cat();

    $this->load->view('frontend/result', $arr );
	}

	public function shareMail( $id ){
		$lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;

		$this->load->model('News_model','news',TRUE);
		$arr['details'] = $this->news->get_details_mail( $id, $lang);

		require 'class/class.simple_mail.php';
		//$from_name = isset($_POST["name"]) ? $_POST["name"] : "" ;
		$mail_to = isset($_POST["email_to"]) ? $_POST["email_to"] : "" ;
		//$name_to = isset($_POST["name_to"]) ? $_POST["name_to"] : "" ;
		/*$from_name = "โอม" ;
		$mail_to = "wutikornj@gmail.com";
		$name_to = "โอม Nex" ;*/
		$message = $arr['details'][0]['cp_content'];
		$image = base_url().'assets/filemanager/userfiles/';
		$message = str_replace("/heart/assets/filemanager/userfiles/", $image , $message );

		$mail = new SimpleMail();

			$mail->setTo($mail_to,'')
				->setFrom('contact@previewcampaign.com', 'มูลนิธิหัวใจแห่งประเทศไทย')
				->setSubject($arr['details'][0]['cp_titlehead'])
				->addGenericHeader('MIME-Version', '1.0')
				->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
				->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
				->setMessage($message);
			$send = $mail->send();
			$arr_result = array();
			if ($send) {
			    $arr_result['rs'] = true;
			} else {
				$arr_result['rs'] = false;
			}

			echo json_encode( $arr_result ) ;
	}

	public function updatePostview( $id ){
		$arr = array();
		$this->load->model('News_model','news',TRUE);
		$this->news->update_postview( $id );

		$arr['rs'] = true;
		echo json_encode($arr);
	}

}
