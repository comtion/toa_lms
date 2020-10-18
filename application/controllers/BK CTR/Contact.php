<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

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
		$arr['page'] = "contact";

		$this->load->view('frontend/contact', $arr );
	}
	public function sendEmail(){
		require 'class/class.simple_mail.php';
		$name = $_POST["firstname"].' '.$_POST["lastname"];
		$email = $_POST["email"];
		$tel = $_POST["telephone"];
		$sub = "ข้อความจากเวบไซต์";
		$mes = $_POST["message"];

		$mail_to = "thaiheartfoundation2@gmail.com";//"thaiheart_fd@hotmail.com" ; // Change to thaiheart email when it live !!s
		$message = '<table width="600" border="0" cellpadding="0" cellspacing="3" bgcolor="#FFFFFF">
			<tr>
				<td colspan="3"><img src="'.base_url().'assets/img/skin/headcontact.png" width="600" height="133" /></td>
			</tr>
			<tr>
				<td width="20">&nbsp;</td>
				<td width="65">&nbsp;</td>
				<td width="509">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalText">Name :</td>
				<td class="normalText_Blue">'.$name.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalText">Email :</td>
				<td class="normalText_Blue">'.$email.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalText">Tel :</td>
				<td class="normalText_Blue">'.$tel.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="normalText">Message :</td>
				<td class="normalText_Blue">'.$mes.'</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>';

		$mail = new SimpleMail();
// แก้ไขค่า ->serForm ด้วย Email ของทางมูลนิธิ เพื่อให้สามารถส่งเมลได้
		$mail->setTo($mail_to,'')
			->setFrom('contact@previewcampaign.com', 'มูลนิธิหัวใจแห่งประเทศไทย')
			->setSubject('มูลนิธิหัวใจแห่งประเทศไทย Auto Reply Contact us')
			->addGenericHeader('MIME-Version', '1.0')
			->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
			->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
			->setMessage($message);
		$send = $mail->send();

		if ($send) {
			echo "<meta http-equiv='refresh' content='0'>" ;
			echo"<script language='JavaScript'>";
			echo"alert('ส่งข้อความเรียบร้อยแล้วครับ ทางเราจะติดต่อกลับภายหลังครับ ขอบคุณครับ');";
			echo"window.location='".base_url()."contact';";
			echo"</script>";
		} else {
			echo "<meta http-equiv='refresh' content='0'>" ;
			echo"<script language='JavaScript'>";
			echo"alert('ระบบส่งข้อความมีปัญหา กรุณาลองใหม่อีกครั้ง');";
			echo"window.location='".base_url()."contact';";
			echo"</script>";
		}

	}
}
