<?php
/**
 * 此页面是用于更新数据
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2调用数据更新方法
  $res=dbUpdate("posts",$_POST);
  // 3判断数据是否更新成功
  if($res){
    $arr=[
      "code"=>1,
      "msg"=>"数据修改成功"
    ];
  }else {
    $arr = [
      "code" => 1,
      "msg" => "数据修改成功"
    ];
  }
  // 4返回结果
  echo json_encode($arr);
?>