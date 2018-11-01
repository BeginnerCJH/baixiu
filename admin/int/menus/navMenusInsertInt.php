<?php
/**
 * 此页面是用于添加新数据
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句查询数据
  $sqlS= "select `value` from options where `key`='nav_menus'";
  // 3调用封装好的查询方法
  $data=dbSelect($sqlS)[0]['value'];//返回的结果是字符串
  // print_r($data);
  // exit;
  // 4把字符串转成我们想要的对象或者数组
  $dataArr=json_decode($data,true);//返回的结果是一个数组
  // print_r($dataArr);
  // exit;
  // 5把用户传过来的数据添加到查询的结果数组中
  $dataArr[]=$_POST;
  // print_r($dataArr);
  // exit;
  // 6把添加数据后的数组转成字符串 再存储到数据库中
  $dataStr=json_encode($dataArr,JSON_UNESCAPED_UNICODE);//返回的结果是一个字符串
  // 7调用封装好的数据修改方法
  // 7.1设置sql语句
  $sqlU="update options set `value`='$dataStr' where `key` ='nav_menus'";
  // 7.2调方法
  $res=dbUpdateMore($sqlU);
  // 8判断数据是否添加成功
  if($res){
    $arr=[
      "code"=>1,
      "msg"=>"数据增加成功"
    ];
  }else {
    $arr = [
      "code" => 0,
      "msg" => "数据增加失败"
    ];
  }
  // 返回结果
  echo json_encode($arr);
?>