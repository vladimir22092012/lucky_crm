<?php

/**
 * Caches
 * 
 */
class Caches extends Core
{
    private $cache_dir = 'files/cache/';
    
    public function __construct()
    {
    	parent::__construct();
        
        $this->cache_dir = $this->config->root_dir.$this->cache_dir;
    }
        
    /**
     * Caches::get_cache()
     * Получить кешированные данные
     * @param string $hash
     * @param int $cache_lifetime - seconds 
     * @return mixed
     */
    public function get_cache($hash, $cache_lifetime)
    {
    	$filename = $this->cache_dir.$hash;
        if (file_exists($filename) && (filemtime($filename) > (time() - $cache_lifetime)))
        {
            $cache = file_get_contents($filename);
        
            return unserialize($cache);
        }
        
        return null;
    }
    
    /**
     * Caches::set_cache()
     * Записать кешированные данные
     * 
     * @param string $hash
     * @param mixed $data
     * @return null
     */
    public function set_cache($hash, $data)
    {
    	$filename = $this->cache_dir.$hash;
        
        file_put_contents($filename, serialize($data));
    }
    
    /**
     * Caches::clear_cache()
     * Очистить кеш
     * 
     * @param string $hash
     * @return null
     */
    public function clear_cache($hash)
    {
        $filename = $this->cache_dir.$hash;
        
        @unlink($filename);
    }
    
    /**
     * Caches::get_hash()
     * Получить хеш для сохранения кеша
     * 
     * @param int $type
     * 1 - comments
     * 2 - credit_history
     * @param mixed $data
     * @return string
     */
    public function get_hash($type, $data)
    {
    	$hash = $type.'/'.md5($data);
        
        return $hash;
    }
    
}