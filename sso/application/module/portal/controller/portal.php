<?php 

class portal extends Controller {

	function __construct() {
		parent::__construct();

		// code...
		$this->get_model('portal_model');
		$this->get_template();
		if (empty($_SESSION)) {
			header("location: ".BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1");
		}
		if (isset($_COOKIE['ssoid'])) {
			$info = $this->portal_model->get_sesstion();
		} else {
			header( "location: ".BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1" );
		}


		if (empty($_SESSION['client_id']) || empty($_SESSION['response_type'])) {
			$_SESSION['client_id'] = 'SS8663835';
			$_SESSION['response_type'] = 'token';
		}


	}

	function index () {

		$data = $this->portal_model->user_info();
		$portal = $this->portal_model->portal_list();

	
		// $this->portal_model->get_sesstion();
		$this->template->home('home','dashboard',['user_data' => $data, 'portal' => $portal]);
	}
	function test_session () {
		$data = $this->portal_model->user_info();
		$portal = $this->portal_model->portal_list();
		$this->portal_model->get_sesstion();
		$this->template->home('home','dashboard',['user_data' => $data, 'portal' => $portal]);
	}
	function destroy () {
		session_destroy();
	}

	function ck_portal () {
		// var_dump($this->get('code'));
		// die();
		$data = $this->portal_model->ck_portal($this->get('code'));

		if ($data->res_code == "01") {
			header("location: $data->redirect");
		}

		header("location: ".BASE_URL."portal"); 
	}

	function login () {
		$this->template->home('new_login','login',[]);
	}

	function logout () {
		unset($_COOKIE['ssoid']); 
		unset($_COOKIE['type']); 
		setcookie('ssoid', null, -1, '/'); 
		setcookie('type', null, -1, '/'); 
		unset($_SESSION['client_id']);
		unset($_SESSION['response_type']);
		unset($_SESSION['info']);
		// session_destroy();
		header( "location: ".BASE_URL."index.php/auth?response_type=token&client_id=SS8663835&redirect_uri=".BASE_URL."portal/ck_portal&state=1");
	}

	function register () {
		$this->template->home('new_login','register', []);
	}

	function news () {
		if (!empty($this->get('view'))) {
			$data = $this->portal_model->model_news($this->get('view'));
			$this->template->home('home', 'news_view', ['data' => $data]);
		} else {
			$this->template->home('home', 'news', []);
		}
		
	}

	function news_list () {
		$data = $this->portal_model->model_news_list();
		echo json_encode($data);
		
	}

	function profile () {
		$data = $this->portal_model->user_info();
		$fo = array(2,4);
		if (in_array($data['type'], $fo)) {
			$this->template->home('home', 'profile_fo', ['user_data' => $data]);
		} elseif ($data['type'] == 3) {
			$this->template->home('home', 'profile_type3', ['user_data' => $data]); 
		} else {
			$this->template->home('home', 'profile', ['user_data' => $data]);
		}
		
	}
	function profile_edit () {
		$data = $this->portal_model->user_info();
		$callback = $this->get('callback');
		$callback = isset($callback)?$callback:'';
		$fo = array(2,4);
		if (in_array($data['type'], $fo)) {
			$this->template->home('home', 'profile_fo_edit', ['user_data' => $data, 'callback' => $callback]);
		} elseif ($data['type'] == 3) {
			$this->template->home('home', 'profile_type3_edit', ['user_data' => $data, 'callback' => $callback]);
		} else {
			$this->template->home('home', 'profile_edit', ['user_data' => $data, 'callback' => $callback]);
		}
		
	}
	function profile_update () {
		$data = $this->portal_model->model_profile_update();
		$this->respone_json($data);
	}
	function contact () {
		$this->template->home('home', 'contact', []);
	}
	function forget () {
		$this->template->home('home', 'forget', []);
	}
	function changepassword_save () {
		$data = $this->portal_model->model_newpassword();
		$this->respone_json($data);
	}
	function user_log () {
		$data = $this->portal_model->user_log();
		$this->respone_json($data);
	}
	function fetch_data () {
		$data = $this->portal_model->dummy_data();
		$this->respone_json($data);
	}
	function test_mail () {
		$data = $this->portal_model->test_ldap();
		$this->view('test_mail', []);
		// $this->template->home('home','test_mail',[]);
	}

	function send_email_verify () {
		$data = $this->portal_model->model_send_email_verify();
		$this->respone_json($data);

	}
}
