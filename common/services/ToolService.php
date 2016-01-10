<?php

namespace common\services;

class ToolService {
    /*
      21、写出一个能创建多级目录的PHP函数
     */

    public static function createdir($path, $mode) {
        if (!is_dir($path)) {  //判断目录存在否，存在不创建
            mkdir($path, $mode, true);
        }
    }

}
