<?php


// $keyFile = "/home/care/www_dev/dbd/ditp.key";
// $caFile = "/home/care/www_dev/dbd/ditp.ca";
// $certFile = "/home/care/www_dev/dbd/ditp.crt";
//$keyFile = "/home/care/www_dev/dbd/ditp.key";
//$caFile = "/home/care/www_dev/dbd/ditp.ca";
//$certFile = "/home/care/www_dev/dbd/ditp.crt";

$keyFile = "/home/care/www_dev/dbd/ditp.key";
$caFile = "/home/care/www_dev/dbd/ditp.ca";
$certFile = "/home/care/www_dev/dbd/ditp.crt";

$keyFile = "/home/care/ssl/www.key";
$caFile = "/home/care/ssl/www.ca";
$certFile = "/home/care/ssl/www.crt";

if(empty($_GET['page'])){


$id_val = '';
$xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
<soapenv:Header/>
<soapenv:Body>
   <ser:getData>
      <!--Optional:-->
      <subscriberId>6211005</subscriberId>
      <!--Optional:-->
      <subscriberPwd>$PSk3754</subscriberPwd>
      <!--Optional:-->
      <serviceId>0001</serviceId>
      <!--Zero or more repetitions:-->
      <params>
         <!--Optional:-->
         <name>JURISDICTION_ID</name>
         <!--Optional:-->
         <value>0125550046368</value>
      </params>
   </ser:getData>
</soapenv:Body>
</soapenv:Envelope>';


$contentlength = strlen($xml_data);
$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService";
// $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
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
//print_r($output);
//exit();
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
    //   echo htmlentities($output);
}
curl_close($ch);

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
$array = json_decode(json_encode((array) $body), TRUE);
$data = $array['ns0getDataResponse']['return']['arrayRRow']['childTables'];
$com = $array['ns0getDataResponse']['return']['arrayRRow']['columns'];
$da = [];
if (!empty($data) && count($data) ) {

    foreach ($data as $k => $v) {
        if (!empty($v['rows'][0])) {
            foreach ($v['rows'] as $key => $val) {
                if ($val['columns']) {
                    foreach ($val['columns'] as $kk => $vv) {
                        $da[$v['adServiceName']][$key][$vv['columnName']] = $vv['columnValue'];
                    }
                }
            }
        } else if (!empty($v['rows']['columns'])) {
            $val = $v['rows']['columns'];
            if (empty($val[0])) {
                $da[$v['adServiceName']][$val['columnName']] = $val['columnValue'];
            } else {
                foreach ($val as $kk => $vv) {
                    $da[$v['adServiceName']][$vv['columnName']] = $vv['columnValue'];
                }
            }
        }
    }
}

if (!empty($com) && count($com) ) {
    foreach ($com as $k => $v) {
        $da['etc'][$v['columnName']]=$v['columnValue'];
    }
}

echo "<pre>";
print_r($da);
echo "</pre>";
exit();
}else if(!empty($_GET['page']) && $_GET['page'] == 'img'){
    $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
    <soapenv:Header/>
    <soapenv:Body>
       <ser:getBytePDFFinancialByJuristicIDAndYear>
          <!--Optional:-->
          <subscriberId>6211005</subscriberId>
          <!--Optional:-->
          <subscriberPwd>$PSk3754</subscriberPwd>
          <!--Optional:-->
          <serviceId>IMG002</serviceId>
          <!--Optional:-->
          <mfno1>0125550046368</mfno1>
          <!--Optional:-->
          <year>2561</year>
       </ser:getBytePDFFinancialByJuristicIDAndYear>
    </soapenv:Body>
 </soapenv:Envelope>';
    
    
    $contentlength = strlen($xml_data);
    $URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/ImagesService";
    // $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
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
    //print_r($output);
    //exit();
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
        //   echo htmlentities($output);
    }

    curl_close($ch);

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
$array = json_decode(json_encode((array) $body), TRUE);
header('Content-Type: application/pdf');
$bin = base64_decode($array['ns0getBytePDFFinancialByJuristicIDAndYearResponse']['return']['pdfBuffer'], true);
echo $bin;


exit();
}else if(!empty($_GET['page']) && $_GET['page'] == 'img003'){
    $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
    <soapenv:Header/>
    <soapenv:Body>
       <ser:getBytePDFBorikonByJuristicID>
          <!--Optional:-->
          <subscriberId>6211005</subscriberId>
          <!--Optional:-->
          <subscriberPwd>$PSk3754</subscriberPwd>
          <!--Optional:-->
          <serviceId>IMG003</serviceId>
          <!--Optional:-->
          <mfno1>0125550046368</mfno1>
       </ser:getBytePDFBorikonByJuristicID>
    </soapenv:Body>
 </soapenv:Envelope>';
    
    
    $contentlength = strlen($xml_data);
    $URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/ImagesService";
    // $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
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
    //print_r($output);
    //exit();
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
        //   echo htmlentities($output);
    }

    curl_close($ch);

$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
$array = json_decode(json_encode((array) $body), TRUE);
header('Content-Type: application/pdf');
$bin = base64_decode($array['ns0getBytePDFBorikonByJuristicIDResponse']['return']['pdfBuffer'], true);
echo $bin;
// echo "<pre>" ;
// print_r($array);
// echo "</pre>" ;
// exit();

exit();
}
