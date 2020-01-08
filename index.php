<?php
    header('Content-Type: text/html;');
    define('PAGE_EOL', '<br/>');
    function PRINT_TITLE($title='', $line) {
        static $i = 0;
        //print('<div style="font-size: x-large; >' . PAGE_EOL . PAGE_EOL);
        print('<color style="font-size: x-large; color: #4670ff">' . PAGE_EOL . PAGE_EOL);
        /* Line1 */print (str_repeat('■', 50) . PAGE_EOL);
        /* Line2 */print ('【' . ++$i . '.' . $title . '】 @' .$line . PAGE_EOL);
        /* Line3 */print (str_repeat('■', 50) . PAGE_EOL);
        print('</color>');
    }
    function TEXT_START() {
        print('<pre style="background-color: #eeeeee">');
    }
    function TEXT_END() {
        print('</pre>');
    }
    function printline($what='', $eol=PHP_EOL) {
        if( is_array($what) || is_object($what) ) {
            foreach ($what as $i_key => $i_val) {
                print('    ' . $i_key . ' = ');
                if( is_array($what) || is_object($what) ) {
                    print_r($i_val);
                } else {
                    print($i_val . $eol);
                }
            }
        } else {
            print($what . $eol);
        }
    }
?><html><body style="font-family: 'Consolas'; font-size: large;"><?php
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■

/**
 * Created by IntelliJ IDEA.
 * User: zhmhbest
 * Date: 2019/7/12
 * Time: 19:22
 */
PRINT_TITLE('单引号与双引号',  __LINE__);
TEXT_START();
    printline('单引号: [Hello\t]');
    printline("双引号: [Hello\t]");
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('定义常量',  __LINE__);
TEXT_START();
    const PI1 = 3.14;
    define("PI2", 3.1415);
    printline('PI1 = ' . PI1);
    printline('PI2 = ' . PI2);
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('数据类型',  __LINE__);
TEXT_START();
    //获得变量类型方法
    var_dump(null);
    printline(gettype(null));
    //int
    var_dump(100);
    var_dump(-100);
    var_dump(0xFF);
    var_dump(077);
    //float
    var_dump(3.14);
    var_dump(618e-3);
    var_dump(2E-4);
    //bool
    var_dump(true);
    var_dump(false);
    //date
    printline( date("Y-m-d h:m:s") ); //格式化输出日期
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('数据转换与比较',  __LINE__);
TEXT_START();
    //类型转换 包含自动类型转换
    printline( (int)3.1415926535 );
    printline( (int)"3.1415926535" );
    printline( (float)"3.1415926535" );
    printline( (double)"3.1415926535" );
    //类型比较
    /*T*/printline( 0 ==  '0'       ? 'true':'false' );
    /*T*/printline( 0 ==  ''        ? 'true':'false' );
    /*T*/printline( 0 ==  false     ? 'true':'false' );
    /*T*/printline( 0 ==  null      ? 'true':'false' );
    /*F*/printline( '0' ==  ''      ? 'true':'false' );
    /*T*/printline( '0' ==  false   ? 'true':'false' );
    /*F*/printline( '0' ==  null    ? 'true':'false' );
    /*T*/printline( '' ==  false    ? 'true':'false' );
    /*T*/printline( '' ==  null     ? 'true':'false' );
    /*T*/printline( false ==  null  ? 'true':'false' );
    /*F*/printline( '0' === 0       ? 'true':'false' );
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('数组和关联数组',  __LINE__);
TEXT_START();
    //数组定义
    $colors1 = ['Blue', 'Red', 'Yellow', 'Green'];
    $colors2 = array('Blue2', 'Red2', 'Yellow2', 'Green2');
    print_r($colors1);
    print_r($colors2);
    printline( 'element: ' . $colors1[0] . ', ' . $colors1[3] );
    printline( 'length: ' . count($colors1) );
    //关联数组
    $prizes1 = [
        'Coffee' => 12,
        'Tea' => 26,
        'Beverage' => 5
    ];
    $prizes2 = array(
        'Coffee2' => 12,
        'Tea2' => 26,
        'Beverage2' => 5
    );
    print_r($prizes1);
    foreach($prizes2 as $i_key=>$i_val) { //遍历数组
        printline( $i_key . '=' . $i_val );
    }
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('全局作用域',  __LINE__);
TEXT_START();
    //定义全局变量
    $GlobalTestVar = 99;
    //执行空间
    (function() { //这是一个执行域，用于隔离变量和类的定义。
        $LocalTestVar = 66;
        global $GlobalTestVar; //引用全局变量
        printline( '$GlobalTestVar = ' .  $GlobalTestVar);
    })();
    printline('【报错】');
    /*报错（超出作用域）*/printline( '$LocalTestVar = ' .  $LocalTestVar);
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('超级全局变量',  __LINE__);
TEXT_START();
    (function() { //这是一个执行域，用于隔离变量和类的定义。
        //设置Cookie
        $value = time();
        $expire = time() + 60; //过期时间一分钟
        setcookie("cookie_key", $value, $expire);
        //设置Session
        session_start();
        $_SESSION['seson_key']='seson_val';
        $_SESSION['seson_key2']='seson_val2';
        print_r($_SESSION);
        unset($_SESSION['seson_key2']);
        //session_destroy(); //清除Session
    })();
    printline('$GLOBALS: 全部变量'); foreach($GLOBALS as $i_key=> $i_val) { printline( '    ' . $i_key); }
    printline('$_SERVER: 服务端环境变量'); //foreach($_SERVER as $i_key=>$i_val) { prinln( '    ' . $i_key); }
    printline('$_REQUEST: '); //foreach($_REQUEST as $i_key=>$i_val) { prinln( '    ' . $i_key); }
    printline('$_POST: '); //foreach($_POST as $i_key=>$i_val) { prinln( '    ' . $i_key); }
    printline('$_GET: '); //foreach($_GET as $i_key=>$i_val) { prinln( '    ' . $i_key); }
    printline('$_COOKIE: '); foreach($_COOKIE as $i_key=> $i_val) { printline( '    ' . $i_key . '=' . $i_val); }
    printline('$_SESSION: '); foreach($_SESSION as $i_key=> $i_val) { printline( '    ' . $i_key . '=' . $i_val); }
    printline('$_FILES: '); //foreach($_FILES as $i_key=>$i_val) { prinln( '    ' . $i_key); }
    printline('$_ENV: '); //foreach($_ENV as $i_key=>$i_val) { prinln( '    ' . $i_key); }
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('魔术常量',  __LINE__);
TEXT_START();
    printline('__LINE__: ' . __LINE__);
    printline('__DIR__: ' . __DIR__);
    printline('__FILE__: ' . __FILE__);
    (function() { //这是一个执行域，用于隔离变量和类的定义。
        class MagicCls {
            public function MagicFun() {
                printline('__FUNCTION__: ' . __FUNCTION__);
                printline('__METHOD__: ' . __METHOD__);
                printline('__CLASS__: ' . __CLASS__);
                printline('__NAMESPACE__: ' . __NAMESPACE__);
            }
            public function testMagic() {
                self::MagicFun();
            }
        }
        $obj = new MagicCls();
        $obj->testMagic();
    })();
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('模块化',  __LINE__);
TEXT_START();
    //模块导入方法
    printline('include');
    printline('include_once');
    printline('require');
    printline('require_once');

    //模块使用
    require_once('./commonModule.php');
    printline(PHP_OS . PHP_FNS);
    //post get
    printline(commonModule\getParam('id', '请在地址后加上: ?id=123'));
    //files
    commonModule\enumLocalFiles(__DIR__, function ($index, $fullname, $filename){
        printline($index . ',' . $fullname . ',' . $filename);
    });
    print_r(commonModule\splitFileName('C:\Windows\notepad.exe'));
    printline(commonModule\formatSize(95638));
    //ip
    printline(commonModule\getLocalIP());
    //curl
    (function() {
        printline('curl');
        $content = commonModule\getHTTPContents(['Url'=>'https://www.baidu.com']);
        print($content['head']);
    })();

    //函数定义
    function funAdd1($num1,$num2) {
        return $num1 + $num2;
    }
    $funAdd2 = function($num1,$num2) {
        return $num1 + $num2;
    };
    printline(funAdd1(1,2));
    printline($funAdd2(2,3));

    //闭包函数
    printline('closer');
    $closerFun = (function() { //闭包利用了语言的GC机制。
        //这是闭包工作的空间
        $closer_var1 = '闭包字段1'; //该字段对外部不可见
        $closer_var2 = '闭包字段2'; //该字段对外部不可见
        return function() use($closer_var1, $closer_var2) {
            //这是闭包返回的函数即【闭包函数】
            //【闭包函数】可使用对外隐藏的字段
            printline($closer_var1 . ', ' . $closer_var2);
        };
    })();
    $closerFun();
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('JSON & SQL',  __LINE__);
TEXT_START();
    //JSON
    (function() {
        $arr1 = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $str_json = json_encode($arr1);
        printline('STT_JSON: '. $str_json);
        $arr2 = json_decode($str_json);
        foreach($arr2 as $i_key=> $i_val) {
            printline( '    ' . $i_key . '=' . $i_val);
        }
    })();
    //SQL
    printline( '使用SQL前请确定您已正确配置: ' . PHP_INI_FILE_PATH );
    /*
     * @file: PHP_INI_FILE_PATH
     * extension=php_mysqli.dll
     */
    (function() {
        printline('SQL:');
        $hostname = '127.0.0.1';
        $username = 'root';
        $password = '';
        $database = ''; //可选参数
        $port = '3306'; //可选参数

        // 创建连接
        $mysql = new mysqli($hostname, $username, $password, $database, $port); printline('打开连接.');
        /*
         * connect_errno: number 返回最后一次连接的错误，如果返回0则连接成功。
         * connect_error: string 返回连接错误的原因。
         * errno: number 调用函数的最后一个错误代码。
         * error: string 用函数的最后一个错误描述。
         */
        if ( 0!=$mysql->connect_errno ) { die('连接失败: ' . $mysql->connect_error) . PHP_EOL; }
        $mysql->set_charset('utf8');
        //事务
        /*
         * $mysql->begin_transaction();
         * $mysql->rollback();
         * $mysql->commit();
         */

        // DQL & DML
        $value = $mysql->query('show databases;');
        if(  $mysql->error ) {
            die('查询失败: ' . $mysql->error);
        }
        print_r($value);

        //关闭连接
        $mysql->close(); printline('关闭连接.');
    })();
TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□

PRINT_TITLE('面向对象',  __LINE__);
TEXT_START();

    interface Animal {
        public const LivingPlace = 'Earth'; //接口仅可添加常量和方法
        public function getAge();
        public function setAge($age);
        public function getGender();
        public function setGender($gender);
    }

    abstract class BigAnimal implements Animal {
        //抽象类可以不实现其继承的接口或类，但其不可被实例化
        //抽象类，其中抽象方法必须在（非抽象）子类中实现
        protected $name; //protected关键字: 字段仅可在当前类内部或其子类内部访问。
        protected $age;
        protected $gender;
        public abstract function getName(); //声明抽象方法，其效果类似接口
        public abstract function setName($name);
    }

    class People extends BigAnimal {
        public function __construct() { //PHP仅允许有一个构造函数
            print('construct' . PHP_EOL);
        }
        function __destruct() { //析构函数
            print('destruct : ' . $this->name . PHP_EOL);
        }

        //Get Set
        public function getGender() { return $this->gender; }
        public function setGender($gender) { $this->gender = $gender; }

        public function getAge() { return $this->age; }
        public function setAge($age) { $this->age = $age; }

        public function getName() { return $this->name; }
        public function setName($name) { $this->name = $name; }

        //Methods default
        public function printAll() {
            print('Print : ' . $this->name . ' ' . $this->age . ' ' . $this->gender . PHP_EOL);
        }

        //Methods static 不需要实例化便可以使用
        public static function staticFun() {
            print('静态方法' . PHP_EOL);
            //self::staticFun();
        }

        //Methods final 该方法无法被子类重写
        public final function finalFun() {
            print('最终方法' . PHP_EOL);
        }
    }

    class Chinese extends People {
        private $skinColor; //私有字段，仅内在声明的类内访问

        //辅助构造1
        private function __construct_0() {
            $this->name = '';
            $this->age  = 0;
            $this->gender = 'male';
        }
        //辅助构造2
        private function __construct_3($name, $age, $gender) {
            $this->name = $name;
            $this->age  = $age;
            $this->gender = $gender;
        }
        public function __construct() {
            parent::__construct(); //父类构造方法
            $this->skinColor = 'yellow';
            //↓↓↓↓↓↓↓↓↓↓↓↓↓↓动态调用方法↓↓↓↓↓↓↓↓↓↓↓↓↓↓
            $argv = func_get_args();
            $argc = func_num_args();
            if(
                    method_exists($this, $fun='__construct_'.$argc) //检查构造的函数名是否存在
            ) {
                call_user_func_array(array($this, $fun), $argv);
            }
            //↑↑↑↑↑↑↑↑↑↑↑↑↑↑动态调用方法↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        }

        //析构函数
        function __destruct() {
            parent::__destruct(); //父类析构方法
        }

        //Methods overwrite
        public function printAll() {
            //parent::printAll();
            print('Print : ' .
                $this->name . ' ' .
                $this->age . ' ' .
                $this->gender . ' ' .
                $this->skinColor .
                PHP_EOL
            );
        }
    }

    People::staticFun(); //调用静态方法，内部使用self关键字。
    $peoples = [
        new Chinese("周姗姗", 18, "female"),
        new Chinese("王大嘴", 12, "male")
    ];
    $peoples[0]->printAll();
    $peoples[1]->printAll();

TEXT_END();
//□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□
//■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
?></body></html>
