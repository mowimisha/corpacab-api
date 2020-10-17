<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mpesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class MpesaController extends Controller
{

    public function driver_payments()
    {
        $transactions = Mpesa::OrderBy('created_at', 'desc')->get();
        $drivers = User::where('role', 'driver')->get();
        $callback_file_Contents =  file_get_contents('https://corpcab.co.ke/safdaraja/liveCallbackResponse.json');
        $callback_file_decoded = json_decode($callback_file_Contents, TRUE);

        foreach ($callback_file_decoded as $key => $value) {
            if ($value['Body']['stkCallback']['ResultCode'] == 0) {
                if ($value['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Name'] == "PhoneNumber" || $value['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Name'] == "PhoneNumber") {
                    if (count($value['Body']['stkCallback']['CallbackMetadata']['Item']) == (int) 4) {
                        $receipts = DB::table('mpesa_payments')->where(['receipt_number' => $value['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value']])->first();

                        if (!$receipts) {
                            $mpesa = new Mpesa();
                            $mpesa->amount = $value['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
                            $mpesa->receipt_number = $value['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
                            $mpesa->transaction_date = $value['Body']['stkCallback']['CallbackMetadata']['Item'][2]['Value'];
                            $mpesa->phone = $value['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
                            $mpesa->save();
                            return $mpesa;
                        }
                    }

                    if (count($value['Body']['stkCallback']['CallbackMetadata']['Item']) == (int) 5) {
                        $receipts = DB::table('mpesa_payments')->where(['receipt_number' => $value['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value']])->first();

                        if (!$receipts) {
                            $mpesa = new Mpesa();
                            $mpesa->amount = $value['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
                            $mpesa->receipt_number = $value['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
                            $mpesa->transaction_date = $value['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
                            $mpesa->phone = $value['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
                            $mpesa->save();
                            return $mpesa;
                        }
                    }
                }
            }
        }
    }

    public function generateAccessToken()
    {
        $consumerKey = 'riTU124QLlDnrDSAuritJxGdNNaLrX7u'; //Fill with your app Consumer Key
        $consumerSecret = 'X19r9BbSgGZ5P5CP'; // Fill with your app Secret
        $headers = ['Content-Type:application/json; charset=utf8'];
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;
        curl_close($curl);
        return $access_token;
    }

    public function security_credentials()
    {
        $publicKey = file_get_contents("https://corpcab.co.ke/safdaraja/cert.cer");
        $plaintext = "0701P991";
        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }

    public function password()
    {
        $shortcode = '793906';
        $passkey = 'a5d7c09ea9eb5a5513ddbf220298f1016685f98c212786f180014ea227d73cf1';
        $timestamp = Carbon::now()->format('YmdHis');
        $encoded_password = base64_encode($shortcode . $passkey . $timestamp);
        return $encoded_password;
    }

    public function STKPush800(Request $request)
    {
        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '800',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush1000(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1000',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush1200(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1200',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush1300(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1300',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush1500(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1500',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }
    public function STKPush1600(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1600',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }
    public function STKPush1700(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1700',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }
    public function STKPush1800(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1800',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }


    public function STKPush2000(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '2000',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush2500(Request $request)
    {
        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';



        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '2500',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush3000(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '3000',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush3500(Request $request)
    {
        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '3500',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush4000(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '4000',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush4500(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '4500',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }

    public function STKPush5000(Request $request)
    {

        $driver_number = "254" . substr($request->original_number, 1);
        $callBackUrl =  'https://corpcab.co.ke/safdaraja/live_stk.php';
        $token = $this->generateAccessToken();
        $password = $this->password();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = '793906';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '5000',
            'PartyA' => $driver_number,
            'PartyB' => $shortcode,
            'PhoneNumber' => $driver_number,
            'CallBackURL' => $callBackUrl,
            'AccountReference' => 'COPRCAB LIMITED',
            'TransactionDesc' => 'DRIVERPAY'
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return back();
    }


    public function accountBalance()
    {
        $token = $this->generateAccessToken();
        $security = $this->security_credentials();
        $url = 'https://api.safaricom.co.ke/mpesa/accountbalance/v1/query';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token)); //setting custom header
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'CommandID' => 'AccountBalance',
            'Initiator' => 'Okepapin',
            'SecurityCredential' => $security,
            'PartyA' => '793906',
            'IdentifierType' => '4',
            'Remarks' => 'Balance',
            'ResultURL' => 'https://corpcab.co.ke/safdaraja/account_balance_response.php',
            'QueueTimeOutURL' => 'https://corpcab.co.ke/safdaraja/account_balance_timeout.php',
        );
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        //print_r($curl_response);

        // $postData =  file_get_contents('https://corpcab.co.ke/safdaraja/balanceResponse.json');
        //$request = json_decode($postData, true);
        //$balance = $request['Result']['ResultParameters']['ResultParameter'][0]['Value'];
        return view('admin.payments.balance');
        //->with('balance', $balance);
    }
}
