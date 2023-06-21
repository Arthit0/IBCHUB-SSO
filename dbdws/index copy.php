<?php





// $keyFile = "/home/care/www_dev/dbd/ditp.key";
// $caFile = "/home/care/www_dev/dbd/ditp.ca";
// $certFile = "/home/care/www_dev/dbd/ditp.crt";
$keyFile = "/home/sso/www/dbdws/ditp.key";
$caFile = "/home/sso/www/dbdws/ditp.ca";
$certFile = "/home/sso/www/dbdws/ditp.crt";


$id_val = '';
$entityBody = file_get_contents('php://input');
$xml_data = $entityBody;

$contentlength = strlen($xml_data);
$wsdl = '';
if (isset($_GET['wsdl']) || isset($_GET['WSDL'])) {
    $wsdl = "?WSDL";
}


$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService".$wsdl;
//https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService
//$URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService".$wsdl;
// $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService" . $_SERVER['QUERY_STRING'];
// $URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService".$wsdl;
//$_SERVER['QUERY_STRING']

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_VERBOSE, true);
// this with CURLOPT_SSLKEYPASSWD
curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
// // The --cacert option
curl_setopt($ch, CURLOPT_CAINFO, $caFile);
curl_setopt($ch, CURLOPT_CAPATH, '');
// // The --cert option
curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: text/xml'
    )
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);


if ($output === false) {
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close($ch);

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    echo "<pre>";
    print_r($header);
    echo "</pre>";
    exit();
} else {

}




curl_close($ch);
// $xml = new SimpleXMLElement($output);
// $doc = new DOMDocument();
// $doc->loadXML($output);
// $tt =$doc->getElementsByTagName('NAME')->nodeValue;
header("Content-type: text/xml");
//echo $output;
echo str_replace("https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService", "https://ssodev.ditp.go.th/dbdws", $output);
die();