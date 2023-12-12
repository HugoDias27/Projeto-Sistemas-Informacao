<?php

namespace common\models;

class GuidGenerator
{
    static function getGUID() {
        $guid = com_create_guid();
        $guid = substr($guid, 1, 36);
        return $guid;
    }
}