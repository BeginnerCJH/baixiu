<?php
/**
 * 此页面是用于动态渲染页面数据
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql="select `value` from options where id<9";
  // 3调用封装好的数据查询方法
  $data=dbSelect($sql);
  // 4判断数据是否查询成功
  if($data){
    $arr=[
      "code"=>1,
      "msg"=>"数据查询成功",
      "data"=>$data,
    ];
  }else {
    $arr = [
      "code" => 1,
      "msg" => "数据查询成功",
      "data" => $data,
    ];
  }
  // 5返回结果
  echo json_encode($arr);
?>