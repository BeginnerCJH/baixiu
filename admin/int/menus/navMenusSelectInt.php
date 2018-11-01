<?php
/**
 * 此页面是用于菜单栏的动态渲染
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql= "select `value` from options where `key`='nav_menus'";
  // 3调用封装好的数据查询方法
  $data=dbSelect($sql)[0]["value"];//返回的结果是字符串
  // echo $data;
  // exit;
  // 4把字符串转为我们想要的对象或者数组
  $dataArr=json_decode($data,true);//返回的结果是数组
  // print_r($arr);
  // exit;
  // 5按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"查询成功",
    "data"=>$dataArr
  ];

  // 6返回结果
  echo json_encode($arr);
?>