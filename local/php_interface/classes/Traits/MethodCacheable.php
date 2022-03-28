<?php

namespace dnext\Traits;

use Bitrix\Main\Data\Cache;
use Exception;
use dnext\Helpers\LogHelper;
use dnext\Exceptions\IblockNotFoundMethodException;


trait MethodCacheable
{
    public function getCached($method, $param = '')
    {
        $result = null;

        if(NX_CACHE_ENABLED) {

            $cache = Cache::createInstance(); // получаем экземпляр класса
            $cacheCode = $this->getCacheTag($method, $param);

            if ($cache->initCache(CACHE_TTL_M, $cacheCode)) { // проверяем кеш и задаём настройки
                $result = $cache->getVars()[$cacheCode];
//                echo 'from cache! CacheID: ' . $result;
////                dd($result);
            } elseif ($cache->startDataCache()) {
                $result = $this->getMethodByName($method, $param);

                $cache->endDataCache([$cacheCode => $result]); // записываем в кеш
            }
        } else {
            $result = $this->getMethodByName($method, $param);
        }

        return $result;
    }

    private function getCacheTag($method, $param)
    {
        $hash = md5(serialize($param));

        return NX_CACHE_CODE . self::$iblockCode . $method . $hash;
    }

    public function clearCache($method, $param = '')
    {
        if(NX_CACHE_ENABLED) {
            $cache = Cache::createInstance(); // получаем экземпляр класса
            $cacheCode = $this->getCacheTag($method, $param);
            $cache->clean($cacheCode);
        }
    }

    private function getMethodByName($method, $param)
    {
        if(method_exists($this, $method) && is_callable($method, true, $callable_name)) {
            if(!$param) {
                $result =  $this->$method();
            } else {
                $result =  $this->$method($param);
            }
        } else {
          //  throw new IblockNotFoundMethodException('(nx) Method isn`t exists or not callable');
            $result = null;
        }

        return $result;
    }

    public function getFirstCached()
    {
        return $this->getCached('getFirstElement');
    }
}