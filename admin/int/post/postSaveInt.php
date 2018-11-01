<?php
/**
 * 此页面用于保存编写的文章
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取当前登录用户的id
  session_start();
  $id=$_SESSION["userInfo"]["id"];
  // 3把id加入数组中
  $_POST["user_id"]=$id;
  // print_r($_POST);
  // 4调用封装好的数据添加方法
  $res=dbInsert("posts",$_POST);
  // 5判断数据是否添加成功---------按一定的格式返回
  if($res){
    $arr=[
      "code"=>1,
      "msg"=>"数据添加成功"
    ];
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"数据添加失败"
    ];
  }
  // 6返回结果
  echo json_encode($arr);
?>