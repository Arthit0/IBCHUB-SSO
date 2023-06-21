<?php 

class home extends Controller {

	function __construct() {
		parent::__construct();

		// code...
		$this->get_model('home_model');
		$this->get_template();
		// header("location: https://sso-uat.ditp.go.th/sso/portal"); 
	}

	function index () {
		$this->template->home('home','dashboard',[]);
	}

	function login () {
		$this->template->home('new_login','login',[]);
	}

	function register () {
		$this->template->home('new_login','register', []);
	}

	function news () {
		$this->template->home('home', 'news', []);
	}

	function profile () {
		$this->template->home('home', 'profile', []);
	}
	function profile_edit () {
		$this->template->home('home', 'profile_edit', []);
	}
	function contact () {
		$this->template->home('home', 'contact', []);
	}
	function forget () {
		$this->template->home('home', 'forget', []);
	}
	function fetch_data () {
		$data = $this->home_model->dummy_data();
		$this->respone_json($data);
	}
	function test_mail () {
		$this->view('test_mail', []);
		// $this->template->home('home','test_mail',[]);
	}
}
