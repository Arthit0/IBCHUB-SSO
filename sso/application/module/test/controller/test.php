<?php

require APPPATH.'/library/PHPMailer_v5.0.2/class.phpmailer.php';

class test extends Controller
{
  private $test = 5;
  function __construct()
  {
    parent::__construct();
    // code...
    $this->get_model('test_model');
    $this->get_library('lb_main');
  }

  function index()
  {
    //file_get_contents('sso/asset/js/source/country.json');
  
    /*echo "<pre>";
    print_r($this->test_model->get_test());
    echo "</pre>";
    exit();*/
    //date_default_timezone_set('Asia/Bangkok');
 
    /*****
    //echo APPPATH;
    $mail = new PHPMailer();
    //$mail->IsSMTP();    
    $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้                        
    $mail->Host     = ""; //  mail server ของเรา
    $mail->SMTPAuth = true;     //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "s6002041510012@email.kmutnb.ac.th";   //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "1559900321727";  //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง

    $mail->From     = "s6002041510012@email.kmutnb.ac.th";  //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "ชื่อผู้ส่ง"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
    $mail->AddAddress("thekitkitter@gmail.com");            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
    $mail->IsHTML(true);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
    $mail->Subject     =  "Test Subject";        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body     = "test Body";                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
    $result = $mail->send();       
    echo $result;*/

    /*$mail = "<center><div style = '
    border: solid #bfbfbf 1px;
    border-radius: 20px;
    width: 80%;'>";
    $mail .= "<img src='".BASE_PATH."asset/img/sso-logo.png' style='width:80px; padding-top: 10px;'>&nbsp;&nbsp;";
    $mail .= "<img src='".BASE_PATH."asset/img/ditp-logo.png' style='width:120px;padding-bottom: 11px;'>";
    //$mail .= "<h2>DITP SSO : Code Reset Password</h2><hr width='80%'>";
    $mail .= "<hr width='80%'><center style='color:black'><h4>กรุณาใช้ตัวเลข 4 หลัก ในการรีเซ็ตรหัสผ่าน</h4>";
    $mail .= "<h1 style='color: #08bf11;'><b>5568</b></h1>";
    $mail .= "----------------------------------------------";
    $mail .= "<p align='left' style='padding-left:10px;'><b>ขั้นตอนการใช้งาน</b></p>";
    $mail .= "<p align='left' style='padding-left:15px; margin-top:-12px'>1. นำตัวเลข 4 หลักกรอกในช่องที่ปรากฏ <br> 
              2. จากนั้นจะปรากฏหน้าสำหรับ รีเซ็ตรหัสผ่าน <br>
              3. ทำการกรอก รหัสผ่านใหม่ <br>
              4. กด \"ยืนยัน\" เพื่อบันทึกรหัสผ่านใหม่</p>";
    $mail .= "</div></center>";
    echo $mail;*/

    //echo BASE_URL.'asset/img/sso-logo.png';

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://caredev.ditp.go.th/api/api_caresaveuser.php?code=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF90b2tlbiI6IjZiYzFhMWFiNWE4OTRlYTBkMzI3NWM5NzAzNTk0ZTdhZTEzYjczNTgiLCJyZWZyZXNoX3Rva2VuIjoiZDE1YmMwODliY2JlZjIzZTdhMzNkZDIxZWRjYmVkN2Q2NDAxZDY2YyIsImVuZF9kYXRlIjoiMjAyMC0wOS0zMCAxNzowNToyOCIsImVuZF9kYXRlX3JlZnJlc2giOiIyMDIwLTEwLTE0IDE1OjA1OjI4IiwidG9rZW5fdHlwZSI6IkJlYXJlciJ9.8JzIn1XqArgag5TN0xAmSSphieepVceyYDKRyXQhf4M",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Cookie: PHPSESSID=7i5rf3p851p0vlmeq7hc523um5"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

  }

  function con($i = '')
  {

    // $this->test_model->get_test();

    $data =  $this->paser('testview', ['test' => 123546]);

    $this->view('testpaser', ['data' => $data]);
  }

  function test()
  {
    echo $_SERVER['HTTP_USER_AGENT'];
  }
}
