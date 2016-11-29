<?php
/**
 * Webhook for Time Bot- Facebook Messenger Bot
 * User: adnan
 * Date: 24/04/16
 * Time: 3:26 PM
 */

$access_token = "EAAOZAgG3mWPYBAFRhUt6HTgugVZAIghzDzEZBi6UegSwZCz0jZBmESIDUiYkFqqyjLJs0r4D4GCoD1aQbaNhwtJqU4fZCM2VBGolYe1ALB59MvmZCt4Iel0SEK4feE5YHZCK3H3abA1dvgCffpuR65P1IoMQQ1ziT50de6lfCY23aQZDZD";
$verify_token = "fb_test_bot";
$hub_verify_token = null;

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}


if ($hub_verify_token === $verify_token) {
    echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

$message_to_reply = '';

/**
 * Some Basic rules to validate incoming messages
 */
if(preg_match('[salut|bonjour|salam|hello|hola|slm|hi]', strtolower($message))) {

        $message_to_reply = 'Bonjour, bienvenue à la page de la Royal Air Maroc';
    
} else {
    $message_to_reply = 'Excusez moi, je n\'ai pas bien compris :)';
}

//API Url
$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;


//Initiate cURL.
$ch = curl_init($url);

//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"'.$sender.'"
    },
    "message":{
        "text":"'.$message_to_reply.'"
    }
}';

//Encode the array into JSON.
$jsonDataEncoded = $jsonData;

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

//Execute the request
if(!empty($input['entry'][0]['messaging'][0]['message'])){
    $result = curl_exec($ch);
}

?>