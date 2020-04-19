<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index(){
		$data['get_all'] = $this->db->from('products')->get()->result();
		$this->load->view('products', $data);
	}

	public function basket($id){
		
		$get_item = $this->db->get_where('products', array('product_id' => $id))->row();

		if(!$_POST){
		
			if(!empty($get_item)){
				$data['get_item'] = $get_item;
				
				$this->load->view('basket', $data);
			} else {
				redirect('products');
			}
		} else {
		
			$this->ipara_trigger($get_item);
		}
		
	}

	function ipara_trigger($products){
		$firstName = "Test";//isim
		$lastName = "Name";//soyisim
		$email = "eposta@adresi.com"; // Eposta adresi
		$cardType = 1; //Kredi kartı tipi, master, visa vb.
		$amount = $products->product_amount; // Ürün fiyatı
		$installment = 1; //Taksit ayarları için
		$nameSurname = 'Cardname Surname'; // Kredi kartı adı soyadı
		$month = 12; // Kredi kartı son kullanma ay
		$year = 22; // Kredi kartı son kullanma yıl
		$cardNumber = '4282209004348015'; //Kredi kartı numarası
		$cvc = 123; //Kredi kartı CVC Kodu
	
		$settings = new Settings ();
		$orderId = Helper::Guid ();
	

		$array = array(
		    'payment_orderid' => $orderId,
			'payment_name' =>  $firstName,
			'payment_surname' =>  $lastName,
			'payment_email' =>  $email,
			'payment_amount' =>  $amount,
			'payment_cardownername' =>  $nameSurname,
			'payment_cardnumber' =>  $cardNumber,
			'payment_cardmonth' =>  $month,
			'payment_cardyear' =>  $year,
			'payment_cardcvc' =>  $cvc,
			'payment_installment' => $installment
		);

		$insert = $this->db->insert('payments', $array); //Daha sonra bazı bilgilere ulaşmak için önce geçici olarak siparişi kayıt altına alıyoruz.

	
		if ( $insert ){
			$request = new ThreeDPaymentInitRequest ();
			$request->OrderId = $orderId;
			$request->Echo = "echo";
			$request->Mode = $settings->Mode;
			$request->Version = $settings->Version;
			$request->Amount = $amount; // 100 tL
			$request->CardOwnerName = $nameSurname;
			$request->CardNumber = $cardNumber;
			$request->CardExpireMonth = $month;
			$request->CardExpireYear = $year;
			$request->Installment = $installment;
			$request->Cvc = $cvc;
			$request->ThreeD = "true";
			
			$request->PurchaserName = $firstName;
			$request->PurchaserSurname = $lastName;
			$request->PurchaserEmail = $email;
			$request->SuccessUrl = "http://localhost/projects/ci-ipara/products/success";
			$request->FailUrl = "http://localhost/projects/ci-ipara/products/fail";
			
			$response = ThreeDPaymentInitRequest::execute ( $request, $settings ); // 3D secure ödeme başlatmamıza olanak sağlar.
			print $response;
		}
	}
	
	function success(){
		/*
		* 	3D Secure işleminin 2. adımında 1. adımda bizlere post edilen dataları alıyoruz.
		*	Bu dataları settings ayarlarımızla birlikte Validate3DReturn metoduna post ediyoruz. 
		*  ThreeDPaymentCompleteRequest sınıfımıza ürün,sipariş ve müşteri bilgilerimizle post ediyoruz.
		* Eğer işlem başarılı ise başarılı mesajını ekranda gösteriyoruz.
		* Başarılı değilse fail.php sayfasına gönderiyoruz.
		*/

		$settings = new Settings();

		$paymentResponse=new ThreeDPaymentInitResponse();
		$paymentResponse->OrderId =$_POST['orderId'];
		$paymentResponse->Result=$_POST['result'];
		$paymentResponse->Amount=$_POST['amount'];
		$paymentResponse->Mode=$settings->Mode;
		$paymentResponse->ErrorCode=$_POST['errorCode'];
		$paymentResponse->ErrorMessage=$_POST['errorMessage'];
		$paymentResponse->TransactionDate=$_POST['transactionDate'];
		$paymentResponse->Hash= $_POST['hash'];

		$data = $this->db->get_where('payments', array('payment_orderid' => $_POST['orderId']))->row_array();
		if ( $data ){
			if (Helper::Validate3DReturn($paymentResponse, $settings)){
				$request = new ThreeDPaymentCompleteRequest();
				$request->OrderId = $_POST['orderId'];
				$request->Echo = "Echo";
				$request->Mode = $settings->Mode;
				$request->Amount = $_POST['amount']; // 100 tL
				$request->CardOwnerName = $data['payment_cardownername'];
				$request->CardNumber = $data['payment_cardnumber'];
				$request->CardExpireMonth = $data['payment_cardmonth'];
				$request->CardExpireYear = $data['payment_cardyear'];
				$request->Installment = $data['payment_installment'];
				$request->Cvc = $data['payment_cardcvc'];
				$request->ThreeD = "true";
				$request->ThreeDSecureCode = $_POST['threeDSecureCode'];

				#region Sipariş veren bilgileri
				$request->Purchaser = new Purchaser();
				$request->Purchaser->BirthDate = date('Y-m-d');
				$request->Purchaser->GsmPhone = "0000000000";
				$request->Purchaser->IdentityNumber = "1234567890";
				#endregion

				#region Fatura bilgileri

				$request->Purchaser->InvoiceAddress = new PurchaserAddress();
				$request->Purchaser->InvoiceAddress->Name = $data['payment_name'];
				$request->Purchaser->InvoiceAddress->SurName = $data['payment_surname'];
				$request->Purchaser->InvoiceAddress->Address = "address";
				$request->Purchaser->InvoiceAddress->ZipCode = "00000";
				$request->Purchaser->InvoiceAddress->CityCode = "00";
				$request->Purchaser->InvoiceAddress->IdentityNumber = "1234567890";
				$request->Purchaser->InvoiceAddress->CountryCode = "TR";
				$request->Purchaser->InvoiceAddress->TaxNumber = "123456";
				$request->Purchaser->InvoiceAddress->TaxOffice = "taxoffice";
				$request->Purchaser->InvoiceAddress->CompanyName = "iPara";
				$request->Purchaser->InvoiceAddress->PhoneNumber = "0000000000";
				#endregion

				#region Kargo Adresi bilgileri
				$request->Purchaser->ShippingAddress = new PurchaserAddress();
				$request->Purchaser->ShippingAddress->Name = $data['payment_name'];
				$request->Purchaser->ShippingAddress->SurName = $data['payment_surname'];
				$request->Purchaser->ShippingAddress->Address = "address";
				$request->Purchaser->ShippingAddress->ZipCode = "00000";
				$request->Purchaser->ShippingAddress->CityCode = "00";
				$request->Purchaser->ShippingAddress->IdentityNumber = "1234567890";
				$request->Purchaser->ShippingAddress->CountryCode = "TR";
				$request->Purchaser->ShippingAddress->PhoneNumber = "0000000000";
				#endregion

				#region Ürün bilgileri
				$request->Products =  array();
				$p = new Product();
				$p->Title = "Cari Bakiye";
				$p->Code = "iPara Test";
				$p->Price = $_POST['amount'];
				$p->Quantity = 1;
				$request->Products[0]=$p;

				#endregion

				$this->db->where('payment_orderid', $_POST['orderId'])->delete('payments'); //Geçici olarak aldığımız veriyi burada siliyoruz.

				$response=ThreeDPaymentCompleteRequest::execute($request,$settings); //3D secure 2. adımının başlatılması için gerekli servis çağrısını temsil eder.
			
				if($response){
					$return = htmlentities(Helper::formattoXMLOutput($response));
				}
			} else {
				redirect('http://localhost/projects/ci-ipara/products/fail');exit();
			}
		} else {
			redirect('http://localhost/projects/ci-ipara/products/fail');exit();
		}

		if($return){
			$this->load->view('success');
		}
	}

	function fail(){
		$this->load->view('fail');
	}

}
