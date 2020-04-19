<?php
 include ("helper.php");
 include ("base.php");
 include ("restHttpCaller.php");
 include ("BinNumberInquiryRequest.php");
 include ("BankCardInquiryRequest.php");
 include ("ApiPaymentRequest.php");
 include ("BankCardCreateRequest.php");
 include ("BankCardDeleteRequest.php");
 include ("PaymentInquiryRequest.php");
 
 include ("ThreeDPaymentInitRequest.php");
 include ("ThreeDPaymentCompleteRequest.php");

 
/*
Tüm çağrılarda kullanılacak ayarların tutulduğu sınıftır. 
Bu sınıf üzerinde size özel parametreler fonksiyonlar arasında taşınabilir.
Bu sınıf üzerinde tüm sistemde kullanacağımız ayarları tutar ve bunlara göre işlem yaparız.
Bu sınıf örnek projemizde BaseController içerisinde kullanılmıştır. Ve tüm ayarların kullanılacağı yerde karşımıza çıkmaktadır.
*/   
    class Settings
    {     
        public $PublicKey="Public Key";//"Public Magaza Anahtarı - size mağaza başvurunuz sonucunda gönderilen publik key (açık anahtar) bilgisini kullanınız.",
        public $PrivateKey="Private Key";//"Private Magaza Anahtarı  - size mağaza başvurunuz sonucunda gönderilen privaye key (gizli anahtar) bilgisini kullanınız.",
        public $BaseUrl="https://api.ipara.com/"; //iPara web servisleri API url'lerinin başlangıç bilgisidir. Restful web servis isteklerini takip eden kodlar halinde bulacaksınız.
        public $Version="1.0";// Kullandığınız iPara API versiyonudur. 
        public $Mode="T"; // Test -> T, entegrasyon testlerinin sırasında "T" modunu, canlı sisteme entegre olarak ödeme almaya başlamak için ise Prod -> "P" modunu kullanınız.            
        public $HashString="";// Kullanacağınız hash bilgisini, bağlanmak istediğiniz web servis bilgisine göre doldurulmalıdır. Bu bilgileri Entegrasyon rehberinin ilgili web servise ait bölümde bulabilirsiniz.
        public $transactionDate;
    }
