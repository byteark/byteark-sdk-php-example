<?php

// Just make notice to be exception for easier error handling.
function exception_error_handler($no, $str, $file, $line) {
    throw new ErrorException($str, 0, $no, $file, $line);
}
set_error_handler("exception_error_handler");

// Invalid the library from composer.
require_once('../vendor/autoload.php');

function array_get($array, $key, $defaultValue = null) {
    if (isset($array[$key]) && $array[$key]) {
        return trim($array[$key]);
    } else {
        return $defaultValue;
    }
}

function array_except($array, $exceptKeys) {
    $result = [];
    foreach ($array as $key => $value) {
        if (!in_array($key, $exceptKeys)) {
            $result[$key] = $value;
        }
    }
    return $result;
}

function nextWeekAtMidnight($from) {
    return $from - ($from % 86400) + (86400 * 7);
}

function removeSecretFromStringToSign($stringToSign) {
    $lines = explode("\n", $stringToSign);
    array_pop($lines);
    return implode("\n", $stringToSign);
}

function makeDefaultResponseFields() {
    $requestInfo = new \ByteArk\Request\RequestInfo();
    $now = time();

    return [
        'current_client_ip' => $requestInfo->get('client_ip'),
        'current_client_subnet16' => $requestInfo->get('client_subnet16'),
        'current_client_subnet24' => $requestInfo->get('client_subnet24'),
        'current_user_agent' => $requestInfo->get('user_agent'),
        'current_timestamp' => $now,
        'suggested_expires' => nextWeekAtMidnight($now),
    ];
}

function handle($input) {
    if (!isset($input) || empty($input)) {
        return makeDefaultResponseFields() + $input;
    }

    try {
        $signer = new \ByteArk\Signer\ByteArkV2UrlSigner([
            'access_id' => array_get($input, 'access_id'),
            'access_secret' => array_get($input, 'access_secret'),
            'skip_url_encoding' => array_get($input, 'skip_url_encoding'. false),
        ]);

        $options = array_filter([
            'method' => array_get($input, 'method'),
            'path_prefix' => array_get($input, 'path_prefix'),
            'client_ip' => array_get($input, 'client_ip'),
            'client_subnet16' => array_get($input, 'client_subnet16'),
            'client_subnet24' => array_get($input, 'client_subnet24'),
            'referer' => array_get($input, 'referer'),
            'user_agent' => array_get($input, 'user_agent'),
        ]);

        $stringToSign = removeSecretFromStringToSign(
            $signer->makeStringToSign(
                array_get($input, 'url'),
                (int) array_get($input, 'expires'),
                $options
            )
        );

        $signedUrl = $signer->sign(
            array_get($input, 'url'),
            (int) array_get($input, 'expires'),
            $options
        );

        return [
            'string_to_sign' => $stringToSign,
            'secure_url' => $signedUrl,
          ]
          + makeDefaultResponseFields()
          + $input;
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()] + makeDefaultResponseFields() + $input;
    }
}

// Start
$response = handle($_POST);
include('../views/index.php');
