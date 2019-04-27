<?php 
function get_new_access_token( $auth )
{
  // get new token
  $token = "unset";
  
  // PREPARE DATA FOR SEND
  $clientid_clientsecret = $auth['client_id'] .":".$auth['$client_secret'];
  $clientid_clientsecret_base64 = base64_encode($clientid_clientsecret);

  // CURL CONFIG DATA 
  $url = 'https://accounts.spotify.com/api/token';

  $data = "grant_type"."="."refresh_token".
      "&refresh_token"."=".$auth['refresh_token'];

  $curl_headers_authorization = "Authorization: Basic " . $clientid_clientsecret_base64 . '=';
  $curl_headers_contenttype = "Content-Type: application/json";
  $curl_headers_contentlength = "Content-Length: 1024";

  // PERFORM CURL
  try {
      $ch = curl_init($url);
      
      if (FALSE === $ch) {
          throw new Exception('failed to initialize');
      } else {
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array( $curl_headers_authorization ));
          curl_setopt($ch, CURLOPT_TIMEOUT, 5);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

          $output = curl_exec($ch);
          // $info = curl_getinfo($ch);
      if (FALSE === $output) {
          throw new Exception(curl_error($ch), curl_errno($ch));
      } else {
        // CURL IS SUCCESSFUL, PROCESS OUTPUT
        $curl_data = json_decode($output);
        $_SESSION["access_token"] = "$curl_data->access_token";
        $_SESSION["token_expires"] = "$curl_data->expires_in";
        echo "SOMETHING HAPPENED";
        echo $curl_data->access_token;
      }
    }
  } catch(Exception $e) {
      trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
  }
}

?>
