<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require 'parampos/_config.php';


class Parampos {

protected $CI;


    /**
     * @param string $CLIENT_CODE : Terminal ID. It can access from Param account
     * @param string $CLIENT_USERNAME : Username. It can access from Param account
     * @param string $CLIENT_PASSWORD : Password. It can access from Param account
     * @param string $GUID : Key belonging to member workplace
     * @param string $MODE : PROD/TEST
     **/

//
    /*
     * $test_url = 'http://test-dmz.ew.com.tr:8080/turkpos.ws/service_turkpos_test.asmx';
     * $prod_url = 'https://dmzws.ew.com.tr/turkpos.ws/service_turkpos_prod.asmx';
     */
    private $_url = 'https://dmzws.ew.com.tr/turkpos.ws/service_turkpos_prod.asmx';
    private $GUID;
    private $CLIENT_CODE;
    private $CLIENT_USERNAME;
    private $CLIENT_PASSWORD;
    private $MODE;
    private $hosturl;
    private $failUrl;
    private $successUrl;
    private $payAction;
    private $ipAddress;
    private $cardHolderPhone;
    private $transactionId;
    private $orderId ;
    private $referenceUrl;
    private $extraData1;
    private $extraData2;
    private $extraData3;
    private $extraData4;
    private $extraData5;

    private $hash;



    public function __construct($params=array()){
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();

        $this->GUID = isset($params['GUID']) ?$params['GUID']  : '';
        $this->CLIENT_CODE = isset($params['CLIENT_CODE']) ?$params['CLIENT_CODE']  : '';
        $this->CLIENT_USERNAME = isset($params['CLIENT_USERNAME']) ?$params['CLIENT_USERNAME'] : '';
        $this->CLIENT_PASSWORD = isset($params['CLIENT_PASSWORD']) ?$params['CLIENT_PASSWORD'] : '';

        $this->MODE = isset($params['MODE']) ? $params['MODE']: 'TEST';
        $this->hosturl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $this->failUrl =  isset($params['failUrl']) ? $params['failUrl']: 'www.ornek.com.tr';
        $this->successUrl =  isset($params['successUrl']) ? $params['successUrl']: 'www.ornek.com.tr';
        $this->payAction =  isset($params['payAction']) ? $params['payAction']: '/';
        $this->ipAddress = ($_SERVER['REMOTE_ADDR']=="::1")?'127.0.0.1':$_SERVER['REMOTE_ADDR'];

        $this->cardHolderPhone =  isset($params['cardHolderPhone']) ? $params['cardHolderPhone']: '5xxxxxxxxx';

        $this->transactionId =  isset($params['transactionId']) ? $params['transactionId']: time();
        $this->orderId  =  isset($params['orderId']) ? $params['orderId']: 0;
        $this->extraData1 =  isset($params['']) ? $params['']: '';
        $this->extraData2 =  isset($params['']) ? $params['']: '';
        $this->extraData3 =  isset($params['']) ? $params['']: '';
        $this->extraData4 =  isset($params['']) ? $params['']: '';
        $this->extraData5 =  isset($params['']) ? $params['']: '';

        $this->hash = $this->createHash();

}

    // create HASH 
    function createHashSecurityKey($securityString){
        $xml_data = '<x:Envelope xmlns:x="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tur="https://turkpos.com.tr/">
    <x:Header/>
    <x:Body>
        <tur:SHA2B64>
            <tur:Data>'.$securityString.'</tur:Data>
        </tur:SHA2B64>
    </x:Body>
</x:Envelope>';
        $ch = curl_init($this->_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $output);
        $xml = simplexml_load_string($clean_xml);
        return $xml->Body->SHA2B64Response->SHA2B64Result;
    }


//Get paid function
function setPaid($post){
        $cardNumber = $post['card_number'];
        $cardName = $post['card_name'];
        $cardExpmonth = $post['card_expmonth'];
        $cardExpyear = $post['card_expyear'];
        $cardCvv = $post['card_cvv'];
        $installment = 1;//Taksit sayısı
        $description = 'DESC';
       // $securityType = '3D'; // NS (NonSecure) veya 3D gönderilir.
        $securityType = $post['securityType'];
        $total_price = $post['total_price'];
        if(!strstr($total_price, ".")) {
            $total_price = $total_price.",00";
        }
        if(!strstr($total_price, ",")){
            $total        =  number_format($total_price,2,",",".");
        } else{
            $total        = $total_price;
        }
        $securityString      = $this->CLIENT_CODE.$this->GUID.$installment.$total.$total.$this->orderId.$this->failUrl.$this->successUrl;
        $myHash = $this->createHashSecurityKey($securityString);


        $xml_data = '<?xml version="1.0" encoding="utf-8"?> <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
<soap:Body>
<Pos_Odeme xmlns="https://turkpos.com.tr/">
<G>
<CLIENT_CODE>'.$this->CLIENT_CODE.'</CLIENT_CODE>
<CLIENT_USERNAME>'.$this->CLIENT_USERNAME.'</CLIENT_USERNAME>
<CLIENT_PASSWORD>'.$this->CLIENT_PASSWORD.'</CLIENT_PASSWORD>
</G>
<GUID>'.$this->GUID.'</GUID>
<KK_Sahibi>'.$cardName.'</KK_Sahibi>
<KK_No>'.$cardNumber.'</KK_No>
<KK_SK_Ay>'.$cardExpmonth.'</KK_SK_Ay>
<KK_SK_Yil>'.$cardExpyear.'</KK_SK_Yil>
<KK_CVC>'.$cardCvv.'</KK_CVC>
<KK_Sahibi_GSM>'.$this->cardHolderPhone.'</KK_Sahibi_GSM>
<Hata_URL>'.$this->failUrl.'</Hata_URL>
<Basarili_URL>'.$this->successUrl.'</Basarili_URL>
<Siparis_ID>'.$this->orderId.'</Siparis_ID>
<Siparis_Aciklama></Siparis_Aciklama>
<Taksit>'.$installment.'</Taksit>
<Islem_Tutar>'.$total.'</Islem_Tutar>
<Toplam_Tutar>'.$total.'</Toplam_Tutar>
<Islem_Hash>'.$myHash.'</Islem_Hash>
<Islem_Guvenlik_Tip>'.$securityType.'</Islem_Guvenlik_Tip>
<Islem_ID></Islem_ID>
<IPAdr>'.$this->ipAddress.'</IPAdr>
<Ref_URL></Ref_URL>
<Data1></Data1>
<Data2></Data2>
<Data3></Data3>
<Data4></Data4>
<Data5></Data5>
<Data6></Data6>
<Data7></Data7>
<Data8></Data8>
<Data9></Data9>
<Data10></Data10>
</Pos_Odeme>
</soap:Body>
</soap:Envelope>';


    $ch = curl_init($this->_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $clean_xml = str_ireplace(['soap:Envelope:', 'soap:'], '', $output);
    $xml = simplexml_load_string($clean_xml);
    $result = $xml->Body->Pos_OdemeResponse->Pos_OdemeResult;

    $resultFin=array();
    $resultFin['success'] = $result->Islem_ID->__toString()=="0"?false:true;
    $resultFin['code'] = $result->Islem_ID->__toString();
    $resultFin['bank_code'] = $result->Banka_Sonuc_Kod->__toString();
    $resultFin['message'] = $result->Sonuc_Str->__toString();
    $resultFin['redirect'] = $result->UCD_URL->__toString();


    return $resultFin;

}


}