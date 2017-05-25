<?php

// Just make notice to be exception for easier error handling.
function exception_error_handler($no, $str, $file, $line) {
    throw new ErrorException($str, 0, $no, $file, $line);
}
set_error_handler("exception_error_handler");

// Invalid the library from composer.
require_once('../vendor/autoload.php');

function array_get($array, $key, $defaultValue = null) {
    if (isset($array[$key])) {
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

function handle($input) {
    $whip = new \Vectorface\Whip\Whip(\Vectorface\Whip\Whip::REMOTE_ADDR);
    $now = time();

    $response = $input + [
        'current_client_ip' => $whip->getValidIpAddress(),
        'current_timestamp' => $now,
        'expires' => nextWeekAtMidnight($now),
    ];

    if (!isset($input) || empty($input)) {
        return $response;
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
                'user_agent' => array_get($input, 'user_agent'),
            ])
        );

        return ['secure_url' => $signedUrl] + $response;
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()] + $response;
    }
}

// Start
$response = handle($_POST);
include('../views/index.php');
