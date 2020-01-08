<?php
/**
 * Created by IntelliJ IDEA.
 * User: zhmhbest
 * Date: 2019/7/13
 * Time: 9:15
 */

namespace commonModule {

    //PHP define
    (function() {
        //File Name Separator
        if ( 'WINNT' === PHP_OS) {
            //WINNT
            define('PHP_FNS', '\\');
        } else {
            //Linux
            define('PHP_FNS', '/');
        }

        //Installation directory
        define('PHP_INSTALLATION_PATH',
            splitFileName(PHP_BINARY, PHP_FNS)['d']
        );

        //Configure Filepath
        define('PHP_INI_FILE_PATH',
            PHP_INSTALLATION_PATH . PHP_FNS . 'php.ini'
        );
    })();

    /**
     * @param string $key
     * @param $default
     * @return string || array
     */
    function getParam($key, $default='') {
        if( $key && is_string($key) ) {
            $val = isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default);
            return is_string($val) ? trim($val) : $val;
        } else {
            return $default; //无效key
        }
    }

    /**
     * @param $t_dirname
     * @param $callback
     */
    function enumLocalFiles($t_dirname, $callback) {
        //commonModule\enumLocalFiles(__DIR__, function ($index, $fullname, $filename){});
        $t_handle = opendir($t_dirname);
        $t_filenum = 0;
        $t_filename = null;
        $t_first = null;
        while( $t_filename=readdir($t_handle) ) {
            $t_first = substr($t_filename, 0, 1);
            if( '.'== $t_first || '$'== $t_first || '#'== $t_first || ' '== $t_first) continue;
            $callback(
                ++$t_filenum, //次序
                $t_dirname . PHP_FNS .  $t_filename,//全名
                $t_filename //文件名
            );
        }
    }

    /**
     * @return string
     */
    function getLocalIP() {
        return (
            empty( $_SERVER['HTTP_CLIENT_IP'] ) ? (
                empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? (
                    empty($_SERVER['REMOTE_ADDR']) ? (
                        '0.0.0.0'
                    ) : $_SERVER['REMOTE_ADDR']
                ) : $_SERVER['HTTP_X_FORWARDED_FOR']
            ) : $_SERVER['HTTP_CLIENT_IP']
        );
    }

    /**
     * @param $size
     * @return string
     */
    function formatSize($size) {
        static  $FILE_SIZE_UNITS = array(
            0 => ' B ', 1 => ' KB ', 2 => ' MB ', 3 => ' GB ', 4 => ' TB '
        );
        $prec = 3;
        $size = round(abs($size));
        if ($size == 0) {
            return '0' . $FILE_SIZE_UNITS[0];
        }
        $unit = min(4, floor(log($size) / log(2) / 10));
        $size = $size * pow(2, -10 * $unit);
        $digi = $prec - 1 - floor(log($size) / log(10));
        $size = round($size * pow(10, $digi)) * pow(10, -$digi);
        return $size . $FILE_SIZE_UNITS[$unit];
    }

    /**
     * @param $fullname
     * @param string $fns
     * @return mixed
     */
    function splitFileName($fullname, $fns = PHP_FNS) {
        $pos = strrpos($fullname, $fns);
        //split1 d fe
        $parts['d'] = substr($fullname, 0, $pos); //目录
        $parts['f'] = substr($fullname, $pos + 1); //文件名 + 扩展名
        //split2 f e
        $pos = strrpos($parts['f'], '.');
        $parts['n'] = substr($parts['f'], 0, $pos); //文件名
        $parts['e'] = substr($parts['f'], $pos + 1); //扩展名
        return $parts;
    }

    function fileWrite($fullname, $content) {
        $fp = fopen($fullname,"w") or exit("Unable to open file!");
        fputs($fp, $content);
        //fwrite($fp,$content, $length);
        fclose($fp);
    }
    function fileRead($fullname, $size=0) {
        $fp = fopen($fullname,"r") or exit("Unable to open file!");
        if(0==$size) {
            return fread($fp, filesize($fullname));
        } else {
            return fread($fp, $size);
        }
        fclose($fp);
    }

    /**
     * @param array $argv = [
     *    'Url': 必填
     *    'User-Agent':
     *    'Cookie-Request': 为空时使用File请求
     *    'Cookie-File':
     *    'Refer':
     *    'Timeout':
     * ]
     */
    function getHTTPContents($argv=[]) {
        /*
         * @file: PHP_INI_FILE_PATH
         * extension=php_curl.dll
         * extension=php_mbstring.dll
         */
        //■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
        //修饰 $argv
        $url = isset($argv['Url']) ? $argv['Url'] : ( isset($argv['url']) ? $argv['url'] : '');
        if('' == $url) {
            //没有 url 直接放弃
            $content['info'] = '';
            $content['head'] = '';
            $content['file'] = '';
            return $content;
        }
        if(!isset($argv['User-Agent'])) {
            $argv['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36';
        }
        if(!isset($argv['Timeout'])) {
            $argv['Timeout'] = 600;
        }
        //■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
        //初始化 $curl
        $curl = curl_init(); if(!$curl) { print( '使用curl前请确定您已正确配置: ' . PHP_INI_FILE_PATH . PHP_EOL); }
        $opts = [
            CURLOPT_RETURNTRANSFER => true,     // 以文件流的形式返回
            CURLOPT_FOLLOWLOCATION => true,     // 服务器返回的"Location"放在header中递归的返回给服务器
            CURLOPT_MAXREDIRS => 6,             // 重定向最大深度
            CURLOPT_AUTOREFERER => true,        // 自动设置header中的Referer信息
            CURLOPT_ENCODING => "",             // 发送所有支持的编码类型
            CURLOPT_CONNECTTIMEOUT_MS =>
                $argv['Timeout'],               // （二选一）连接超时时间 单位（毫秒）
            //CURLOPT_TIMEOUT => 5,             // （二选一）连接超时时间 单位（秒）
            CURLOPT_HEADER => true,             // 文件流包含 Header
            //URL
            CURLOPT_URL => $url,
            //User-Agent
            //CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
            //证书
            CURLOPT_SSL_VERIFYPEER => 0,        //
            CURLOPT_SSL_VERIFYHOST => 2,        //
            //header
            CURLOPT_HTTPHEADER => [
                'Connection: keep-alive',
                'User-Agent: ' . $argv['User-Agent'],
                'HTTP_ACCEPT_LANGUAGE: zh-CN,zh-HK;q=0.9,zh;q=0.8,en-US;q=0.7,en;q=0.6,ja-JP;q=0.5,ja;q=0.4',
                'HTTP_ACCEPT_ENCODING: gzip, deflate, br'
            ],
        ];
        curl_setopt_array($curl, $opts);
        //■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
        //请求时 Cookie
        if(isset($argv['Cookie-Request'])) {
            if(''===$argv['Cookie-Request']) {
                //使用Cookie文件请求
                if(isset($argv['Cookie-File'])) {
                    curl_setopt($curl, CURLOPT_COOKIEFILE, $argv['Cookie-File']);
                }
            } else {
                //使用字符串模拟Cookie
                //eg: "tool=curl; fun=yes;"
                curl_setopt($curl, CURLOPT_COOKIE, $argv['Cookie-Request']);
            }
        }
        //返回时 Cookie
        if(isset($argv['Cookie-File'])) {
            curl_setopt($curl, CURLOPT_COOKIEJAR, $argv['Cookie-File']);
        }
        //引用地址
        if(isset($argv['Refer'])) {
            curl_setopt($curl, CURLOPT_REFERER, $argv['Refer']);
        }
        //■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
        //返回数据
        $response = curl_exec($curl); //失败时返回布尔值false
        $content = null; //声明
        if ($response === false) {
            $content['info'] = '';
            $content['head'] = '';
            $content['file'] = '';
        } else {
            //执行成功！
            $info = curl_getinfo($curl); //MimeType
            $content['info'] = $info;
            $content['head'] = substr($response, 0, $info['header_size']);
            $content['file'] = substr($response, $info['header_size']);
        }
        curl_close($curl);
        return $content;
    }

}