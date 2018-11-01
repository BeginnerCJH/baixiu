<?php
/**
 * 此页面用于添加新用户
 */
  
  // 获取用户当前的flag值
  // 开启session
  session_start();
  $flag=$_SESSION["userInfo"]["flag"];
  // print_r($flag);
  // var_dump(is_int($flag));
  // exit;
  // 判断当前用户的flag是否==0，如果不等于0直接返回提示错误信息
  if($flag!=='0'){
    $arr=array(
      "code"=>-1,
      "msg"=>"添加失败，对不起，你没有权限！"
    );
  }else {
    // 1引入外部文件
    require "../../../dbFunction.php";
    // 添加默认的状态为激活
    $_POST["status"]="activated";
    // 2调用封装的添加函数
    $res=dbInsert("users",$_POST);
    // print_r($_POST);
    // exit;
    // 3判断数据是否增加成功-------按照一定的格式返回浏览器端
    if($res){
      $arr=array(
        "code"=>1,
        "msg"=>"数据添加成功..."
      );
    }else {
      $arr=array(
        "code"=>0,
        "msg"=>"数据添加失败..."
      );
    }
  }
 
  // 4把结果响应回浏览器端
  echo json_encode($arr);



?>