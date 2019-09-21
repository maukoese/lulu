<?php
class Lulu
{
function __construct()
{
}

function send()
{
// Sets our destination URL

    $AccountNo = XXX ;             // Automatically assigned when you register on www.lulusms.com
    $UserName  = '072XXXXX' ;     //  Mobile Number used to register on @ www.lulusms.com
    $Password  = '*****';          // Your PAssword on www.lulusms.com
    $From      = 'lulusms.com';     // Can change to your alpha numeric short code when assigned
    $To        = '254XXXXXX';    // Mobile number of receipient, format 254XX... or 07XX....
    $SMS       = "Hello World " ;   // Message to be sent out to customer

    // Creates our data array that we want to post to the endpoint
    $data_to_post = [
     'AccountNo' => $AccountNo,
     'UserName' => $UserName,  
     'Password' => $Password ,  
     'To' => $To ,  
     'SMS' => $SMS,
     'From' => $From ,

    ];

    // Sets our options array so we can assign them all at once
    $options = [
     CURLOPT_URL             => 'https://www.lulusms.com/api/sendsmsapiv3',
     CURLOPT_POST            => true,
     CURLOPT_SSL_VERIFYHOST  => 0, 
     CURLOPT_SSL_VERIFYPEER  => 0, 
     CURLOPT_POSTFIELDS      => $data_to_post,
        CURLOPT_RETURNTRANSFER  => 1, // Return the transfer as a string
    ];

    // Initiates the cURL object
    $curl = curl_init();

    // Assigns our options
    curl_setopt_array($curl, $options);


    // Executes the cURL POST
    $results = curl_exec($curl);
 
  
    // Turn the results into an associative array
    $returned_text = json_decode($results, true);

    // Get the status of message
    $Status = trim($returned_text['Status']);

 
    // Get the message status
    $StatusMessage = $returned_text['StatusMessage'];
     
     
    // If status is OK proceed
    if (strcasecmp($Status, "OK")== 0)
    {
     $SMSRefNumber = $returned_text['SMSRefNumber'];
     $SMSUnitsBalance = $returned_text['SMSUnitsBalance'];

        /*
        echo "Text sent successfully to remote server '<br>'";// comment out when live
        echo "The Units balance is $SMSUnitsBalance '<br>'";// comment out when live
    
        echo "The status message returned by the server is  - $StatusMessage ";// comment out when live
        echo "<br>";// comment out when live
     */
        if ($SMSUnitsBalance < 10) {
            /*
            echo '<br>'; // comment out when live
       echo "YOU NEED TO TOP UP. The balance is " . $SMSUnitsBalance . "<br>";// comment out when live
            */
     }
        ///////////// Your code processing logic here including updating your database
    }
    else 
    {
        /*
        echo '<br>'; // comment out when live
      echo "ERROR *******************Not successful. The following error has been generated " . $StatusMessage . '<br>';
             ///////////// Your code error processing logic here including updating your database
         */
    }
 
    // Be kind, tidy up!
    curl_close($curl);
    }
}
?>
