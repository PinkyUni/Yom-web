<?php

class Cache {

    private $cache_file = '';
    private $cache_time = 60;

    function get_cache_file() {
        return $this->cache_file;
    }

    function set_cache_file($cache_file) {
        $this->cache_file = $cache_file;
    }

    function read_cache() {
        $file = 'main';
        $links = explode('/', $_SERVER['REQUEST_URI']);
        if (!empty($links[1])) {
            $file = $links[1];
        }
        $cache_file = "application/cache/$file.html";
        $this->set_cache_file($cache_file);
        if (file_exists($cache_file)) {
            if ((time() - $this->cache_time) < filemtime($cache_file)) {
                echo file_get_contents($cache_file);
                exit;
            }
        }
        ob_start();
    }

    function write_cache() {
        $cache_file = $this->get_cache_file();
        $handle = fopen($cache_file, 'w');
        fwrite($handle, ob_get_contents());
        fclose($handle);
        ob_end_flush();
    }

}

?>