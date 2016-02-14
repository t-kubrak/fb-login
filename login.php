<!--Facebook server-side login with php-->
<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$fb = new Facebook\Facebook([
	'app_id' => 'APP ID HERE',
	'app_secret' => 'APP SECRET ID HERE',
	'default_graph_version' => 'v2.2',
]);

$helper = $fb->getJavaScriptHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if (! isset($accessToken)) {
	echo 'No cookie set or no OAuth data could be obtained from cookie.';
	header('Location: home.php');
	exit;
}else{
	$_SESSION['fb_access_token'] = (string) $accessToken;

	try {
		$response = $fb->get('/me?fields=id,name,age_range,picture,email,gender,link', $_SESSION['fb_access_token']);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$user = $response->getGraphUser();

	$_SESSION['fb_user'] = (string) $user;
	$_SESSION['id'] = $user['id'];
	$_SESSION['name'] = $user['name'];

	// User is logged in!
	// We can redirect them to another page.
	header('Location: home.php');
}
?>
