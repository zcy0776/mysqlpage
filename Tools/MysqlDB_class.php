<?php

class MysqlDB
{
    private $host;
    private $port;
    private $user;
    private $password;
    private $database;
    private $charset;
    public $link;
    //单例第1步：定义一个私有静态变量用于存放实例化的对象。
    private static $instance = null;

    //单例第2步：私有化构造函数
    private function __construct($config)
    {
        //var_dump($config);
        $this->host = $config['host'] ? $config['host'] : 'localhost';
        $this->port = $config['port'] ? $config['port'] : '3306';
        $this->user = $config['user'] ? $config['user'] : 'root';
        $this->password = $config['password'] ? $config['password'] : 'bs2691000';
        $this->charset = $config['charset'] ? $config['charset'] : 'utf8';
        $this->database = $config['database'] ? $config['database'] : 'php38';
        $this->link = mysqli_connect("{$this->host}:{$this->port}", "{$this->user}", "{$this->password}", "{$this->database}") or die('连接数据库失败');
        $this->setCharset($this->link, $this->charset);
        //$this->selcteDB($this->link,$this->database);
    }

    public function connent()
    {
        //  $config=array('host'=>SELF::HOST,'port'=>SELF::POST,'user'=>SELF::USER,'password'=>SELF::PASSWORD,'database'=>SELF::DATABASE);
        $config = array('host' => HOST, 'port' => POST, 'user' => USER, 'password' => PASSWORD, 'database' => DATABASE);
        $con = mysqli_connect(
            $config['host'], $config['user'], $config['password'], $config['database']
        );
        return $con;
    }

    //单例第3步：建一个公共静态方法，专门用于外部实例化对象，即只能通过本方法实例化对象。
    static function GetDB($conf)
    {
        if (empty(self::$instance)) {
            self::$instance = new MysqlDB($conf);
            return self::$instance;
        } else {
            return self::$instance;
        }
    }


    //单例第4步：禁止克隆
    private function __clone()
    {
    }

    public function setCharset($conn, $charset)
    {
        mysqli_query($conn, "set names '$charset'");
    }

    public function selcteDB($conn, $dbname)
    {
        mysqli_select_db($conn, $dbname);
    }

    public function query($conn, $sql)
    {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "<br>发生错误SQL语句:<font color='#ff0816'>" . $sql . "</font>";
            echo "<br>发生错误原因:" . mysqli_error();
            echo "<br>发生错误代号:" . mysqli_errno();
            die();
        }
        return $result;
    }

    //取所有记录
    public function getRows($conn, $sql)
    {
        $result = $this->query($conn, $sql);
        $arr = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr[] = $row;
            }
        }
        return $arr;
    }

    //取所一行记录
    public function getOneRow($conn, $sql)
    {
        $result = $this->query($conn, $sql);
        //$arr=array();
        if ($row = mysqli_fetch_assoc($result)) {
            $arr = $row;
        }
        return $arr;
    }

    //取所一个字段
    public function getOneData($conn, $sql)
    {
        $result = $this->query($conn, $sql);
        if ($row = mysqli_fetch_row($result)) {
            return $row[0];
        }
        return FALSE;
    }

    //获取记录数
    public function getTotalNum($conn, $sql)
    {
        $result = $this->query($conn, $sql);
        return mysqli_num_rows($result);
    }
}

