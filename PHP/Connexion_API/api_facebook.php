
<?php
 require_once 'facebook-graph-sdk/src/Facebook/Facebook.php';
 require_once 'facebook-graph-sdk/src/Facebook/autoload.php';
 require_once 'facebook-graph-sdk/src/Facebook/Exceptions/FacebookResponseException.php';
 require_once 'facebook-graph-sdk/src/Facebook/Exceptions/FacebookSDKException.php';
 require_once 'facebook-graph-sdk/src/Facebook/Helpers/FacebookRedirectLoginHelper.php';
 
// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
 
$appId = '622140349634869';
$appSecret = '72bb685d61dd0c231434e013480541dd';
 
$fb = new Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.1',   
]);
 
 
// YOUR user's access token, refer
// "https://developers.facebook.com/tools/explorer/"
$accessToken='EAAI11VaKWTUBAJBRvFFIFiW0GL0ZB9B7ir37K1OaSSVDKDGpNg4a6c6lJRgMZBDZARr0mdl1OYlCPnHQr9bfgpA79jZBm8CWzw2A3DEoJ4CwJN2DYQPs0Fdd6w1ETbZCvsAmrE4tSk4IxU5iLmwLOOOT8Bta5yTZCjBZAurqKx1Ih5wHv18m6b4oBxocj3o62ClujGKgZCGSoydYdlkLjiGSRZBuvY6BQhJosApLbmL06MnTo38XsxK7BSy00Iod7Yc8ZD';
 
$response= "";
 
try
{
    $response = $fb->get('/me', $accessToken);
    $response = $fb->get('/me?fields=id, name', $accessToken);   
}
catch(FacebookResponseException $e)
{
     echo 'Graph returned an error:' . $e->getMessage();
     exit();
}
catch(FacebookSDKException $e)
{
    echo 'Facebook SDK returned an error:' . $e->getMessage();
     exit();
}
$me = $response->getGraphUser();
echo 'Logged in as (username) : ' . $me->getName().'<br/>';
?>