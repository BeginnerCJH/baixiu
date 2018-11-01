<?php
/**
 * 此页面是用于个人中心信息的修改
 */
  
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取当前登录用户的id
  session_start();
  $id=$_SESSION["userInfo"]["id"];
  // 3把id添加到数组中
  $_POST["id"]=$id;
  // 4邮箱是不允许编辑的 所以从数组中删除
  unset($_POST["email"]);
  // print_r($_POST);
  // 5调用封装的数据修改方法
  $res=dbUpdate("users",$_POST);
  // 6判断数据是否修改成功
  if($res){
    $arr=[
      "code"=>1,
      "msg"=>"数据修改成功"
    ];
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"数据修改失败"
    ];
  }
  // 7把结果返回
  echo json_encode($arr);
?>