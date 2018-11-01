<?php
/**
 * 此页面用于用户信息的更新
 */

  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2调用封装的数据库函数
  $res=dbUpdate("users",$_POST);
  // 3判断数据是修改成功------------按照一定的格式返回到浏览器端
  if($res){
    $arr=array(
      "code"=>1,
      "msg"=>"数据更新成功..."
    );
  }else {
    $arr=array(
      "code"=>0,
      "msg"=>"数据更新失败..."
    );
  }
  // 4返回数据到浏览器端
  echo json_encode($arr);

?>