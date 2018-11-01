<?php

/**
 * 此页面是用于批量删除
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
    // 2接收用户传递过来的index值
  $indexs = $_GET["indexs"];
    // print_r($indexs);
    // exit;
    // 3查询数据库中数据
  $data = dbSelect("select `value` from options where `key` ='home_slides'")[0]["value"];//返回的是字符串
    // print_r($data);
    // exit;
    // 4把字符串转成我们想要的数组
  $dataArr = json_decode($data, true);
    // print_r($dataArr);
    // exit;
    // 5遍历传递过来的index 删除结果数组中的元素
  foreach ($indexs as $key => $val) {
    unset($dataArr[$val]);//删除元素 不重置索引
  }
    // print_r($dataArr);
    // exit;
    // 6把数组转成字符串 再存储到数据库中
  $dataStr = json_encode($dataArr, JSON_UNESCAPED_UNICODE);
    // 7设置sql语句
  $sql = "update options set `value`='$dataStr' where `key` ='home_slides'";
    // 8调用函数
  $res = dbUpdateMore($sql);
    // 9判断数据是否删除成功
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
    // 10返回结果
  echo json_encode($arr);

?>