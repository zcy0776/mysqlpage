<?php
header("Content-type:text/html;charset=utf-8");  //统一输出编码为utf-8
require("./Tools/config.php");
//$db=new MysqlDB($config);  //用下面这个最安全
$db = MysqlDB::GetDB($config);
$sql = 'select * from p38_goods';
$result_arr = $db->getRows($db->link, $sql);
$total = $db->getTotalNum($db->link, $sql);
$total2 = count($result_arr);
var_dump($result_arr);


