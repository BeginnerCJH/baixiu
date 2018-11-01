<?php

/**
 * 此页面是用于页面上的删除数据
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
    // 2获取用户传递过来的index
  $index = $_GET["index"];
    // echo $index;
    // exit;
    // 3设置查询sql语句
  $sqlS = "select `value` from options where `key` = 'home_slides'";
    // 4调用封装好的查询方法
  $data = dbSelect($sqlS)[0]["value"];//返回的结果是字符串
    // 5把字符串转成我们想要的数组
  $dataArr = json_decode($data, true);//返回的结果是数组
    // print_r($dataArr) ;
    // exit;
    // 6根用户传过来的索引删除数组中值
  array_splice($dataArr, $index, 1);//三个参数分别是数组 从哪里开始删除 删除的数量
    // 7把数组转成字符串  再存储到数据库中
  $dataStr = json_encode($dataArr, JSON_UNESCAPED_UNICODE);
    // 8设置sql语句
  $sqlU = "update options set `value`='$dataStr' where `key` ='home_slides'";
    // 9调用封装好的数据修改方法
  $res = dbUpdateMore($sqlU);
     // 10判断数据是否添加成功
  if ($res) {
    $arr = [
      "code" => 1,
      "msg" => "数据删除成功"
    ];
  } else {
    $arr = [
      "code" => 0,
      "msg" => "数据删除失败"
    ];
  }
      // 返回结果
  echo json_encode($arr);
?>