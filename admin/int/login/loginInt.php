<?php 
/**
 * 此页面是用于登录验证
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2接收用户传递过来的内容
    $email=$_POST["email"];
    $password=$_POST["password"];
  // 3设置sql语句
   $sql="select * from users where email = '$email' limit 1";
  //  4调用封装的查询方法
  $res=dbSelect($sql);
  // print_r($res);
  // exit;
  // 5判断数据是否查询成功
  if(is_array($res)){
    if($password==$res[0]["password"]){
      if($res[0]["status"]=="unactivated"){
        $arr=[
          "code"=>3,
          "msg"=>"账号未激活，请联系超级管理员"
        ];
      }else if ($res[0]["status"]=="forbidden") {
        $arr=[
          "code"=>4,
          "msg"=>"账号被禁用，请联系超级管理员"
        ];
      }else if ($res[0]["status"]=="trashed") {
        $arr=[
          "code"=>5,
          "msg"=>"账号已废弃，请联系超级管理员"
        ];
      }else {
        $arr=[
          "code"=>1,
          "msg"=>"登录成功"
        ];
        // 开启session
        session_start();
        // 设置session的值
        $_SESSION["userInfo"]=$res[0];
      }
    }else {
      $arr=[
        "code"=>2,
        "msg"=>"邮箱与密码不匹配"
      ];
    }
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"用户不存在"
    ];
  }
  // 6把结果返回到浏览器端
  echo json_encode($arr);
?>