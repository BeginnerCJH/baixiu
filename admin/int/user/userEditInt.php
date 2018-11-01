<?php
/**
 * 此页面用于用户的编辑
 */
  // 获取当前登录用户的flag值
  // 开启session
  session_start();
  $flag=$_SESSION["userInfo"]["flag"];
  // 判断flag的值是否等于0
  if($flag!=='0'){
    $arr=array(
      "code"=>-1,
      "msg"=>"编辑失败，对不起，你没有权限！"
    );
  }else {
    // 1引入外部文件
    require "../../../dbFunction.php";
    // 2获取用户点击按钮传递过来的id
    $id=$_GET["id"];
    // 3设置sql语句
    $sql="select * from users where id=$id";
    // 4调用封装的函数方法
    $data=dbSelect($sql);
    // 5判断数据是否查询成功 ------按照一定的格式返回到浏览器端
    if(is_array($data)){
     $arr=array(
       "code"=>1,
       "msg"=>"数据查询成功...",
       "data"=>$data
     );
    }else {
     $arr=array(
       "code"=>0,
       "msg"=>"数据查询失败...",
       "data"=>$data
     );
    }
  }
  // 6把数据响应到浏览器端
  echo json_encode($arr);
?>