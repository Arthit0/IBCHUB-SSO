<?php 
$entityBody = file_get_contents('php://input');
// exit();
$keyFile = "/home/sso/www/dbdws/ditp.key";
$caFile = "/home/sso/www/dbdws/ditp.ca";
$certFile = "/home/sso/www/dbdws/ditp.crt";

$id_val = '';
$xml_data = $entityBody;
// echo "test";
// die();
$contentlength = strlen($xml_data);
$wsdl='';
$_GET['wsdl']='wsdl';
if(isset($_GET['wsdl']) || isset($_GET['WSDL']) ){
    $wsdl="?WSDL";
} 

$URL = "https://sso-uat.ditp.go.th/dbdws/genServ.php?".$_SERVER['QUERY_STRING'];

$output = shell_exec("cd /home/ssodev/www/dbdws; curl -X POST  '".$URL."'  -H  'Content-Type: text/xml'  -d '".$xml_data."'  -k -v --key ditp.key --cacert ditp.ca --cert ./ditp.crt");

header ("Content-Type:text/xml");
var_dump($output);
die();
// echo str_replace("https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService","https://sso.ditp.go.th/dbdws",$output);
echo str_replace("https://sso-uat.ditp.go.th/dbdws/genServ.php","https://sso-uat.ditp.go.th/dbdws/genServ.php",$output);
die();

?>

