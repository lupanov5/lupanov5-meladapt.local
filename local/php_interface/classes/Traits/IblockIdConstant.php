<?php

namespace dnext\Traits;

use dnext\Exceptions\IBlockNotFoundCodeException;
use Exception;

trait IblockIdConstant
{
    public function getId()
    {
        try {
            if(defined($this->modelConstant)) {
                return constant($this->modelConstant);
            } else {
                throw new IBlockNotFoundCodeException($this->modelConstant . ': Iblock Constant not defined!');
            }
        } catch (IBlockNotFoundCodeException $exception) {
            if(DEBUG_ENABLE) {
                die($exception->getMessage());
            }
        }

        return false;
    }
}