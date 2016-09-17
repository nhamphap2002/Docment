<?php

function sha($data, $direction) {
    if ($direction == 'in') {
        $passphrase = 'SHA-INlexuanchien123!@#';
    } else {
        if (isset($data['SHASIGN'])) {
            unset($data['SHASIGN']);
        }
        if(isset($data['txtcolor'])){
            unset($data['txtcolor']);
        }
        $passphrase = 'SHA-OUTlexuanchien123!@#';
    }
    $data = array_change_key_case($data, CASE_UPPER);
    ksort($data, SORT_STRING);
    $subj = '';
    foreach ($data as $key => $value) {
        if (strlen($value) !== 0) {
            $subj .= sprintf('%s=%s%s', $key, $value, $passphrase);
        }
    }
    $method = str_replace('-', '', 'SHA-1');
    $sha = strtoupper(hash($method, $subj));
    return $sha;
}

?>
