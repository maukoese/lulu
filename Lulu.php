<?php
class Lulu
{
    protected $AccountNo; // Automatically assigned when you register on www.lulusms.com
    protected $UserName; //  Mobile Number used to register on @ www.lulusms.com
    protected $Password; // Your PAssword on www.lulusms.com
    
function __construct($AccountNo, $UserName, $Password)
{
    $this->$AccountNo = $AccountNo;
    $this->$UserName = $UserName;
    $this->$Password = $Password;
}

function sms($To , $SMS, $From = 'lulusms.com')
{
    // Creates our data array that we want to post to the endpoint
    $data_to_post = [
     'AccountNo' => $this->AccountNo,
     'UserName' => $this->UserName,  
     'Password' => $this->Password ,  
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
