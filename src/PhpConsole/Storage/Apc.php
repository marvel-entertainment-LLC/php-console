<?php

namespace PhpConsole\Storage;

/**
 * APC storage for postponed response data.
 *
 * @package PhpConsole
 * @version 3.1
 * @link http://php-console.com
 * @author Eddy Nunez <enunez@marvel.com>
 */
class Apc extends ExpiringKeyValue {

    public function __construct() {
        $ext        = array('apc', 'apcu');
        $apcLoaded  = array_reduce($ext, function($carry, $item){
            return $carry || extension_loaded($item);
        }, false);
        if(!$apcLoaded) {
            throw new \RuntimeException('APC extension is not loaded.');
        }
    }

    /**
     * Save data by auto-expire key
     * @param $key
     * @param string $data
     * @param int $expire
     */
    protected function set($key, $data, $expire) {
        apc_store($key, $data, $expire);
    }

    /**
     * Get data by key if not expired
     * @param $key
     * @return string
     */
    protected function get($key) {
        return apc_fetch($key);
    }

    /**
     * Remove key in store
     * @param $key
     * @return mixed
     */
    protected function delete($key) {
        apc_delete($key);
    }
}
