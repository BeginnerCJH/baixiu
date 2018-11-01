<?php
/**
 * 此页面是用于页面右侧的动态渲染
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql= "select `value` from options where `key` = 'home_slides'";
  // 3调用封装好的查询方法
  $data=dbSelect($sql)[0]["value"];//返回的是字符串
  // 4把字符串转成我们想要的数组
  $dataArr=json_decode($data,true);//返回的结果是字符串
  // 5按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"数据查询成功",
    "data"=>$dataArr
  ];
  // 6返回结果
  echo json_encode($arr);

?>