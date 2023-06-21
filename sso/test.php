<?php

phpinfo();
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://testappapi.ditp.go.th/api/ActivityTraining/genform/header/type/personal',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);
echo "eiei";
var_dump($response);
exit;

echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
exit;

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.ditptouch.com/v1/ditp-one/auth/with-password',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('username' => 'test@ibusiness.go.th', 'password' => '0856225746'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

exit;
// echo getenv('HTTP_CLIENT_IP');
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// exit;
// echo $_SERVER['SERVER_ADDR'];
// exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$data_insert = "register_type=FORM&";
$data_insert .= "identify=PERSONAL&";
$data_insert .= "email=test@ibusiness.go.th&";
$data_insert .= "password=0856225746&";
$data_insert .= "firstname=กิตติพร&";
$data_insert .= "lastname=สินนุรักษ์กูล&";
$data_insert .= "citizen_id=1559900321727&";
$data_insert .= "mobile=0856225746";

$curl = curl_init();
curl_setopt_array($curl, array(
    //CURLOPT_URL => "https://api.ditptouch.rgb72.dev/v1/signup",
    //CURLOPT_URL => "https://api.ditptouch.com/v1/signup",
    CURLOPT_URL => "https://api.ditptouch.com/v1/ditp-one/signup",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    //CURLOPT_PROXY => '103.225.168.203',
    //CURLOPT_INTERFACE => '103.225.168.203',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $data_insert,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
        "REMOTE_ADDR:103.225.168.203",
        "HTTP_X_FORWARDED_FOR:103.225.168.203",
        "HTTP_X_FORWARDED:103.225.168.203",
        "CLIENT-IP:103.225.168.203",
        "REMOTE_ADDR:103.225.168.203",
        "HTTP_FORWARDED:103.225.168.203",
        "HTTP_FORWARDED_FOR:103.225.168.203",
        "HTTP_CLIENT_IP:103.225.168.203",
        "HTTPs_CLIENT_IP:103.225.168.203",
        "HTTP_CF_CONNECTING_IP:103.225.168.203",

    ),
));

$response = curl_exec($curl);
curl_close($curl);
echo "eiei = " . $response;

exit;

echo phpinfo();
exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
var_dump(extension_loaded('ldap'));
exit;
//"ibusiness@ditp.go.th","Subsange123"
echo "<pre>";
print_r(authLdapDitp('sippakornn@ditp.go.th', 'Ditp2020'));
echo "</pre>";

//----- ldap -----//
function authLdapDitp($username, $password)
{
    $return = [
        'res_code' => '01',
        'res_text' => 'Login fail',
    ];

    $ldap_uri = "ldap://10.8.99.17";

    $ds = ldap_connect($ldap_uri) or die('Could not connect to LDAP server.');
    $r = ldap_bind($ds); // this is an "anonymous" bind, typically
    // read-only access
    $sr = ldap_search($ds, "ou=mail,dc=linux,dc=co,dc=th", "mail=" . $username);
    $info = ldap_get_entries($ds, $sr);
    //print_r($info);

    if ($info["count"] > 0) {
        $first_name = $info[0]["cn"][0];
        $last_name = $info[0]["sn"][0];
        $uid = $info[0]["uid"][0];
        $displayname = $info[0]["displayname"][0];
        $title = $info[0]["title"][0];
        $employeetype = $info[0]["employeetype"][0];
        $telephonenumber = $info[0]["telephonenumber"][0];
        $mail = $info[0]["mail"][0];

        $result = [
            'uid' => $uid,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'displayname' => $displayname,
            'title' => $title,
            'employeetype' => $employeetype,
            'telephonenumber' => $telephonenumber,
            'mail' => $mail,
        ];

        $dn = $info[0]["dn"];
        $cn = $info[0]["cn"][0];
        $sn = $info[0]["sn"][0];
        $ldapbind = @ldap_bind($ds, $dn, $password);

        if ($ldapbind) {
            $return = [
                'res_code' => '00',
                'res_text' => 'success',
                'res_result' => $result,
            ];
        } else {
            $return = [
                'res_code' => '01',
                'res_text' => 'Password incorrect',
            ];
        }

    } else {
        $return = [
            'res_code' => '01',
            'res_text' => 'Username not found',
        ];
    }

    ldap_close($ds);
    return $return;
}

exit;

//echo ini_get('display_errors');
//echo phpinfo();
//echo "test";

// $data_login_care = [
//     'email' => 'test6@email.com',
//     'password' => '0856225746aa'
// ];

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "http://care.ditp.go.th/api/v2/login",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => array('email' => 'test6@email.com','password' => '0856225746aa'),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://sso.ditp.go.th/sso/api/getinfo",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//     "client_id: ssoidtest",
//     "code: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF90b2tlbiI6IjJhMGVhYjJlM2Y3ODc0YTc4ODM1NTYwOWMwMTcwYjVjYTNiZGNkNGUiLCJyZWZyZXNoX3Rva2VuIjoiYjdlMjc2ODQxZWQxN2IyNTI5M2JlMjI3YTIyMDEyZmU5NWU5YTA3MSIsImVuZF9kYXRlIjoiMjAyMC0xMC0xNSAxMjo1Mjo1OCIsImVuZF9kYXRlX3JlZnJlc2giOiIyMDIwLTEwLTI5IDEwOjUyOjU4IiwidG9rZW5fdHlwZSI6IkJlYXJlciJ9.Vt0bN7QP8G3BKzgaHprD_z-X5Y31HlL35jgGlFXJtCk",
//   ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;

// try{
//   $url = "https://care.ditp.go.th/api/api_caresaveuser.php?code=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF90b2tlbiI6IjUzMDEzOTI1OTRlNmM4NWUyMjVlOWJmODUzOGQ0NmI2NjQ3ZDYzN2QiLCJyZWZyZXNoX3Rva2VuIjoiZTA0ODA3NmY2MDQ2M2M3ODRjZDgxYzVjZjQxOGQ4YTRjYWRlOGJmNSIsImVuZF9kYXRlIjoiMjAyMC0xMC0yMCAxMjo0MzowNCIsImVuZF9kYXRlX3JlZnJlc2giOiIyMDIwLTExLTAzIDEwOjQzOjA0IiwidG9rZW5fdHlwZSI6IkJlYXJlciJ9.cf8fiyTYNFJo2rBiQlktHSEZhbRf9PIznY7fsIcnGeo&xx=0105537041030";
//   $curl = curl_init();

//   curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://care.ditp.go.th/api/api_caresaveuser.php?code=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF90b2tlbiI6IjUzMDEzOTI1OTRlNmM4NWUyMjVlOWJmODUzOGQ0NmI2NjQ3ZDYzN2QiLCJyZWZyZXNoX3Rva2VuIjoiZTA0ODA3NmY2MDQ2M2M3ODRjZDgxYzVjZjQxOGQ4YTRjYWRlOGJmNSIsImVuZF9kYXRlIjoiMjAyMC0xMC0yMCAxMjo0MzowNCIsImVuZF9kYXRlX3JlZnJlc2giOiIyMDIwLTExLTAzIDEwOjQzOjA0IiwidG9rZW5fdHlwZSI6IkJlYXJlciJ9.cf8fiyTYNFJo2rBiQlktHSEZhbRf9PIznY7fsIcnGeo&xx=0105537041030",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "GET",
//     CURLOPT_HTTPHEADER => array(
//       "Cookie: PHPSESSID=ln3btit3nbujcb881t49vabbl2"
//     ),
//   ));
//   $response = curl_exec($curl);

//   curl_close($curl);
//   echo $response;

// }catch(Exception $ex){
//   echo $ex;
// }

// function get_info_drive($userid = ''){
//   $curl = curl_init();
//   curl_setopt_array($curl, array(
//     CURLOPT_URL => "https://driveapi.ditp.go.th/api/UserProfile?token=46c6f9c9-b624-4ce4-969b-8c56e136314c&userid=5650900019510",
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_HTTPHEADER => array('Content-Length: 0')
//   ));
//   $response = curl_exec($curl);
//   curl_close($curl);
//   echo $response;
// }

// $result = get_info_drive('eiei');
// print_r($result);

if ($_SERVER['HTTPS'] != "on") {
    $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location:$redirect");
}
