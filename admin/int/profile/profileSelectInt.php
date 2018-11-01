<?php
/**
 * 此页面用于动态渲染个人中心
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取当前登录用户的id
  // 开启session
  session_start();
  $id=$_SESSION["userInfo"]["id"];
  // 设置sql语句
  $sql="select * from users where id= $id";
  // 3调用封装好的查询方法
  $data=dbSelect($sql);
  // 4判断是否查询成功--------按一定的格式返回
  if(is_array($data)){
    $arr=[
      "code"=>1,
      "msg"=>"数据查询成功",
      "data"=>$data
    ];
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"数据查询失败",
      "data"=>$data
    ];
  }
  // 5返回结果
  echo json_encode($arr);
?>