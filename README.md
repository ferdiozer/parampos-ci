# parampos-ci

Parampos Codeigniter Library

## Parampos Codeigniter - PHP

Parampos payment system Codeigniter version



## Use



Example

```
//Controller
	public function index($orderId){

		if(isset($_POST['pos_id'])){
            $config['GUID'] = '0c13d406-873b-403b-9c09-a5766840d98c';
            $config['CLIENT_CODE'] ='10738';
            $config['CLIENT_USERNAME'] ='Test';
            $config['CLIENT_PASSWORD'] ='Test';
            $config['MODE'] = "TEST"; // PROD or TEST
            $config['orderId'] = $orderId;
            $config['cardHolderPhone'] ="5445555555";

            $config['payAction'] = base_url('/checkout/payment/'.$orderId);
            $config['successUrl'] =base_url('/checkout/result/'.$orderId.'success=true');
            $config['failUrl'] = base_url('/checkout/result/'.$orderId);
            // Include the library
            $this->load->library('Parampos',$config);

            $post['card_number'] = $_POST['card_number'];
            $post['card_name'] = $_POST['card_name'];
            $post['card_expmonth'] = $_POST['card_expmonth'];
            $post['card_expyear'] = $_POST['card_expyear'];
            $post['card_cvv'] = $_POST['card_cvv'];
            $post['total_price']= '10,00';

            $payed = $this->Parampos->setPaid($post);
            if ($payed["success"]){
                redirect( '/Welcome/index/'.$orderId.'?success');
            }
            else{
                redirect('/Welcome/index/'.$orderId);
            }
        }

		$this->load->view('welcome_message',$data);
	}
```

### To include the library in an existing project

* Copy 'application/libraries/Parampos.php'
* Your projects 'application/libraries' folder

and you can use it like in the example above.





Example Bank Cards

```

ZİRAAT BANKASI
Card Number (Visa): 4546711234567894
Kart Numarası (Master Card): 5401341234567891
Expiration Date: 12/26
CVV: 000
3D Secure Password: a

FİNANSBANK
Card Number (Visa): 4022774022774026
Kart Numarası (Master Card): 5456165456165454
Expiration Date: 12/26
CVV: 000
3D Secure Password: a

AKBANK
Card Number (Visa): 4355084355084358
Kart Numarası (Master Card): 5571135571135575
Expiration Date: 12/26
CVV: 000
3D Secure Password: a

İŞ BANKASI
Card Number (Visa): 4508034508034509
Kart Numarası (Master Card): 5406675406675403
Expiration Date: 12/26
CVV: 000
3D Secure Password: a

HALK BANKASI
Card Number (Visa): 4531444531442283
Kart Numarası (Master Card): 5818775818772285
Expiration Date: 12/26
CVV: 001
3D Secure Password: a

DENİZBANK
Card Number (Visa): 4090700101174272
Expiration Date: 12/22
CVV: 104
3D Secure Password:123

Card Number (Visa): 4090700090840057
Expiration Date: 11/22
CVV: 592
3D Secure Password:123

Card Number (Visa): 5200190006338608
Expiration Date: 05/21
CVV: 306
3D Secure Password:123

Card Number (Visa): 5200190009721495
Expiration Date: 05/21
CVV: 200
3D Secure Password:123

YAPIKREDİ
Card Number (Visa): 4506347027911094
Card Number (Master Card):5400619360964581
Expiration Date: 03/22
CVV: 000
3D Secure Password:34020
HALK BANKASI
Card Number (Visa): 4531444531442283
Card Number (Master Card): 5818775818772285
Expiration Date: 12/26
CVV: 001
3D Secure Password: a

```

Note: Test cards only work in the test environment.


## Support
Documentation :
[Param Dev](https://dev.param.com.tr/en/)



## Author

[Ferdi Özer](https://github.com/ferdiozer) (info@ferdiozer.com).