<?php
function &get_config(array $replace = array())
{
    static $config;

    if (empty($config)) {

        $file_path = APPPATH . 'config/config_code.php';
        $found = FALSE;
        if (file_exists($file_path)) {
            $found = TRUE;
            require($file_path);
        }

        // Is the config file in the environment folder?
        if (file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/config.php')) {
            require($file_path);
        } elseif (!$found) {
            http_response_code(503);
            echo 'The configuration file does not exist.';
            exit(3); // EXIT_CONFIG
        }

        // Does the $config array exist in the file?
        if (!isset($config) or !is_array($config)) {
            http_response_code(503);
            echo 'Your config file does not appear to be formatted correctly.';
            exit(3); // EXIT_CONFIG
        }
    }

    // Are any values being dynamically added or replaced?
    foreach ($replace as $key => $val) {
        $config[$key] = $val;
    }

    return $config;
}



class Config
{

    public $test;
    function __construct()
    {
        $this->test ='132';
    }

    function items($item = '')
    {
        $config = get_config();
        return (empty($config[$item])) ? '' : $config[$item];
    }
    function set_items($item = '', $value = '')
    {

        get_config([$item => $value]);
        return true;
    }
}



if (!function_exists('base_url')) {
    /**
     * Base URL
     *
     * Create a local URL based on your basepath.
     * Segments can be passed in as a string or an array, same as site_url
     * or a URL to a file can be passed in, e.g. to an image file.
     *
     * @param	string	$uri
     * @param	string	$protocol
     * @return	string
     */
    function base_url($uri = '', $protocol = NULL)
    {
        return get_config()['base_url'];
    }
}
