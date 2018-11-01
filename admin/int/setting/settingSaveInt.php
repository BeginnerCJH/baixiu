<?php
/**
 * 此页面用于保存设置
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的数据 重新修改
  $_POST["comment_status"]=isset($_POST["comment_status"])?1:0;
  $_POST["comment_reviewed"]=isset($_POST["comment_reviewed"])?1:0;
  // 3遍历数组 
  $flag=true;//定义一个变量 默认是true
  foreach ($_POST as $key => $val) {
    // 4设置sql语句
    $sql="update options set `value`='$val' where `key`='$key'";
    //5调用封装好的修改数据方法
    $res=dbUpdateMore($sql);
    // 6判断数据是否修改成功 只要有一个不成功就跳出循环
    if(!$res){
      $flag=false;//
      break;
    }
  }
  // 7判断数据是否 修改成功
  if($flag){
    $arr=[
      "code"=>1,
      "msg"=>"数据修改成功"
    ];
  }else {
    $arr = [
      "code" => 0,
      "msg" => "数据修改失败"
    ];
  }
  // 8返回结果
  echo json_encode($arr);
?>