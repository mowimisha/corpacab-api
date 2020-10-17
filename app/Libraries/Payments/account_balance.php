

  <?php


    //ACCESS TOKEN
    $consumerKey = '1GQRaQGr1DdfM4RWiFGN1f4JXpyy0VDQ'; //Fill with your app Consumer Key
    $consumerSecret = 'HSCRjAWCqFpKLIRe'; // Fill with your app Secret
    $headers = ['Content-Type:application/json; charset=utf8'];
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    $access_token = $result->access_token;
    curl_close($curl);




    //ACCOUNT BALANCE
    $url = 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token)); //setting custom header


    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'CommandID' => ' ',
        'Initiator' => 'safaricom.10',
        'SecurityCredential' => 'AhSk+L+D4FnwjB4AszLWKCviBjLfOmDIlYeBkBUynAFPIAza2q8cXUSlsnwBqfMb2AeFN/FU1F9tLNI2/bTCcYVzqngZ+oRyrvTHrA9YwOhMncikSd9nHg6iEwsQpZZEn8X+0cwE0ppF0srQNOxR96bH8vt9U1/7iAf8qolVmi6j6SZyT7LNm4raTHpJBKdOTwhwl/R8AY4OHyqjAH1vqrK2IXIbpfXflTfZtIZRfdRvmM3C65ZRcul7gl7x6o0lwAHu2SoaTS+kLrRxGdSYmHMyokDcxATVFVRCiMAZY1gWrOwvpSyK55BWAlzRUj6Y/zleXn70IvC1BNd1xtzKAg==',
        'CommandID' => 'AccountBalance',
        'PartyA' => '603055',
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
    print_r($curl_response);

    echo $curl_response;
