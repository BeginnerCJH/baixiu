<?php
/**
 * 此页面用于页面上的添加数据
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql = "select `value` from options where `key` = 'home_slides'";
    // 3调用封装好的查询方法
  $data = dbSelect($sql)[0]["value"];//返回的是字符串
    // 4把字符串转成我们想要的数组
  $dataArr = json_decode($data, true);//返回的结果是字符串
  // 5把用户提交过来的内容添加到查询的结果数组中
  $dataArr[]=$_POST;
  // 6把数组转成字符串 再存储到数据库中
  $dataStr=json_encode($dataArr,JSON_UNESCAPED_UNICODE);
   // 7.1设置sql语句
  $sqlU = "update options set `value`='$dataStr' where `key` ='home_slides'";
    // 7.2调方法
  $res = dbUpdateMore($sqlU);
    // 8判断数据是否添加成功
  if ($res) {
    $arr = [
      "code" => 1,
      "msg" => "数据增加成功"
    ];
  } else {
    $arr = [
      "code" => 0,
      "msg" => "数据增加失败"
    ];
  }
    // 返回结果
  echo json_encode($arr);
  
?>