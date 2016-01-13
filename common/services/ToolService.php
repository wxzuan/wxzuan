<?php

namespace common\services;

class ToolService {
    /*
      21、写出一个能创建多级目录的PHP函数
     */

    public static function createdir($path, $mode) {
        
        $adir = explode('/', $path);
        $dirlist = '';
        $rootdir = array_shift($adir);
        if (($rootdir != '.' || $rootdir != '..') && !file_exists($rootdir)) {
            @mkdir($rootdir);
        }
        foreach ($adir as $key => $val) {
            if ($val != '.' && $val != '..') {
                $dirlist .= "/" . $val;
                $dirpath = $rootdir . $dirlist;
                if (!file_exists($dirpath)) {
                    @mkdir($dirpath);
                    @chmod($dirpath, 0777);
                }
            }
        }
    }

}
