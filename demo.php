<?php 

require 'vendor/autoload.php';
use Mailgun\Mailgun;

define('YOUR_API_KEY','b2e83b7c5fb045f409a9b76b30d9818a-835621cf-11080909');
define('YOUR_DOMAIN_NAME','sandbox52645cf5e180498e8dd72523db7fac43.mailgun.org');
define('MAILGUM_URL','https://api.mailgun.net/v3/'.YOUR_DOMAIN_NAME);

$api_key = YOUR_API_KEY;
$domain = YOUR_DOMAIN_NAME;

error_reporting(0);
$request = json_encode($_REQUEST);
$params = $_POST;

$api_val = $params['api'];
unset($params['api']);
$data = validateParams($api_val);
if (strtolower($data['status']) == 'error') {
    echo json_encode($data);
    die();
}
$data = array();
switch ($api_val) {
    case 1: 
        $data = send_message($params);
        break;
    case 2:
        $data = get_all_templates();
        break;    
    default:
        $data = array(
                    'status' => 'Error',
                    'msg' => 'Invalid API',
                    'data' => ''
                );
}
echo json_encode($data); die();

function send_message($params){
	$mgClient = Mailgun::create(YOUR_API_KEY);
	$result = $mgClient->messages()->send(YOUR_DOMAIN_NAME, array(
		'from'	=> $params['first_name'].' '.$params['last_name'].' dilip9903@gmail.com',
		'to'	=> 'dilip9903@gmail.com',
		'subject' => 'Subject Line',
		'template'	=> $params['template']
	));

	$id = $result->getId();
	$message = $result->getMessage();
	if(!empty($id) && !empty($message)){
		return array(
			'status' => 'success',
			'id' => $id,
			'message' => $message
		);
	} else {
		return array(
			'status' => 'Error',
			'msg' => ''
		);
	}
}

function get_all_templates() {
	$param = array(
		'url' => MAILGUM_URL.'/templates'
	);
	$result = json_decode(call_curl($param));
	return array('data' => $result );
}

function call_curl($param = null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, 'api:'.YOUR_API_KEY);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_URL, $param['url']);

	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function validateParams($api)
{
    switch ($api) {
        case '1':
            $valid_params_arr = array(
                'api',
                'first_name',
				'last_name',
                'template'
            );
            break;
        case '2':
            $valid_params_arr = array(
                'api'
            );
            break;   
    }
    $input_array = $_REQUEST;
    foreach ($valid_params_arr as $key => $value) {
        if (! array_key_exists($value, $input_array)) {
            return array(
                'status' => 'Error',
                'msg' => 'Required Parameter ' . $value,
                'data' => ''
            );
        }
    }
    return array(
        'status' => 'Success',
        'msg' => '',
        'data' => ''
    );
}


?>