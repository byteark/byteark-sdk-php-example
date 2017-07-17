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

function makeDefaultResponseFields() {
    $whip = new \Vectorface\Whip\Whip(\Vectorface\Whip\Whip::REMOTE_ADDR);
    $now = time();

    return [
        'current_client_ip' => $whip->getValidIpAddress(),
        'current_user_agent' => array_get($_SERVER, 'HTTP_USER_AGENT', ''),
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

        $signedUrl = $signer->sign(
            array_get($input, 'url'),
            (int) array_get($input, 'expires'),
            array_filter([
                'method' => array_get($input, 'method'),
                'path_prefix' => array_get($input, 'path_prefix'),
                'client_ip' => array_get($input, 'client_ip'),
                'referer' => array_get($input, 'referer'),
                'user_agent' => array_get($input, 'user_agent'),
            ])
        );

        return ['secure_url' => $signedUrl] + makeDefaultResponseFields() + $input;
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()] + makeDefaultResponseFields() + $input;
    }
}

// Start
$response = handle($_POST);
include('../views/index.php');
