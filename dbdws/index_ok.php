<?php 
$entityBody = file_get_contents('php://input');
//exit();
$keyFile = "/home/care/www_dev/dbd/ditp.key";
$caFile = "/home/care/www_dev/dbd/ditp.ca";
$certFile = "/home/care/www_dev/dbd/ditp.crt";

$id_val = '';
$xml_data = $entityBody;

$contentlength = strlen($xml_data);
$wsdl='';
$_GET['wsdl']='wsdl';
if(isset($_GET['wsdl']) || isset($_GET['WSDL']) ){
    $wsdl="?WSDL";
} 

$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService?".$_SERVER['QUERY_STRING'];


//$pos = strpos($_SERVER['QUERY_STRING'], 'GeneralService');

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
//if ($pos === false) {

//}else{
//   $URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService?".$_SERVER['QUERY_STRING'];
///}

//echo $URL;
//exit();
/*
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_TIMEOUT, 86400);
// this with CURLOPT_SSLKEYPASSWD
curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
// // The --cacert option
curl_setopt($ch, CURLOPT_CAINFO, $caFile);
//curl_setopt($ch, CURLOPT_CAPATH, '');
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
*/
//echo "cd /home/care/www_dev/dbd; curl -X POST  ".$URL."  -H  'Content-Type: text/xml' -d '".$xml_data."'  -k -v --key ditp.key --cacert ditp.ca --cert ./ditp.crt";
//echo 'cd /home/care/www_dev/dbd; curl -k "'.$URL.'" -v --key ditp.key --cacert ditp.ca --cert ./ditp.crt -X POST -d "<soapenv:Envelopexmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"xmlns:ser="http://service.wsdata.dbd.gov/"><soapenv:Header/><soapenv:Body><ser:getData><!--Optional:--><subscriberId>?</subscriberId><!--Optional:--><subscriberPwd>?</subscriberPwd><!--Optional:--><serviceId>?</serviceId><!--Zeroormorerepetitions:--><params><!--Optional:--><name>?</name><!--Optional:--><value>?</v^Cue></params></ser:getData></soapenv:Body></soapenv:Envelope>" -H "Content-Type: text/xml"';
//exit();
$output = shell_exec("cd /home/care/www_dev/dbd; curl -X POST  '".$URL."'  -H  'Content-Type: text/xml'  -d '".$xml_data."'  -k -v --key ditp.key --cacert ditp.ca --cert ./ditp.crt");

//$output = shell_exec('cd /home/care/www_dev/dbd; curl -k "'.$URL.'" -v --key ditp.key --cacert ditp.ca --cert ./ditp.crt -X POST -d "<soapenv:Envelopexmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"xmlns:ser="http://service.wsdata.dbd.gov/"><soapenv:Header/><soapenv:Body><ser:getData><!--Optional:--><subscriberId>?</subscriberId><!--Optional:--><subscriberPwd>?</subscriberPwd><!--Optional:--><serviceId>?</serviceId><!--Zeroormorerepetitions:--><params><!--Optional:--><name>?</name><!--Optional:--><value>?</v^Cue></params></ser:getData></soapenv:Body></soapenv:Envelope>" -H "Content-Type: text/xml"');
/*
$errno = curl_errno($ch);
        $err = curl_error($ch);
 
      //  curl_close($ch);
      
        if ($errno) {
            echo  "cURL Error #:" . $err;
        } else {
            echo "OK 200";
            echo  $response;
        }
echo "END";*/
//print_r($output);
//curl_close($ch);
//exit();


header ("Content-Type:text/xml");

$a=str_replace("https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService","https://ssodev.ditp.go.th/dbdws",$output);

//$a=str_replace("http://service.wsdata.dbd.gov/GeneralService/getDataRequest","https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService/getDataRequest",$a);

echo $a;
die();

?>