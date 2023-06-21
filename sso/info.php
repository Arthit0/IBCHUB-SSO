<?php
function ini_flatten($config) {
    $flat = array();
    foreach ($config as $key => $info) {
        $flat[$key] = $info['local_value'];
    }
    return $flat;
}

function ini_diff($config1, $config2) {
    $diff = array();
    $flat1 = ini_flatten($config1);
    $flat2 = ini_flatten($config2);
    foreach ($flat1 as $key => $value1) {
        if (isset($flat2[$key])) {
            $value2 = $flat2[$key];
            if ($value1 !== $value2 && (!is_null($value1) || !is_null($value2))) {
                $diff[$key] = array($value1, $value2);
            }
        } else {
            if (!is_null($value1)) {
                $diff[$key] = array($value1, null);
            }
        }
    }
    foreach ($flat2 as $key => $value2) {
        if (!isset($flat1[$key]) && !is_null($value2)) {
            $diff[$key] = array(null, $value2);
        }
    }
    return $diff;
}

$config1 = ini_get_all();

$export_script = 'https://sso.ditp.go.th:6633/sso/diff.php';
$config2_raw = @file_get_contents($export_script);
if ($config2_raw === false) {
    echo "Error fetching configuration from $export_script\n";
    exit();
}

$config2_raw = trim($config2_raw); // Trim whitespace and newline characters
$config2 = @unserialize($config2_raw);
if ($config2 === false) {
    echo "Error unserializing configuration data from $export_script\n";
    exit();
}

$diff = ini_diff($config1, $config2);

echo "<pre>";
if (empty($diff)) {
    echo "The configuration options are identical.\n";
} else {
    echo "The following configuration options differ:\n";
    foreach ($diff as $key => $values) {
        echo "<b style='color:green'>$key</b>: <br> <b>PRD VALUE</b>  = " . var_export($values[0], true) . " <b>DOCKER VALUE</b> = " . var_export($values[1], true) . "\n";
    }
}
echo "</pre>";
?>