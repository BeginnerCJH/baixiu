<?php
/**
 * 此页面是用于删除文章
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id
  $id=$_GET["id"];
  // 3调用封装好的数据删除方法
  $res=dbDelete("posts",$id);
  // 4判断数据是否删除成功 ---------按一定的格式返回
  if($res){
    $arr=[
      "code"=>1,
      "msg"=>"数据删除成功"
    ];
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"数据删除失败"
    ];
  }
  // 5返回结果
  echo json_encode($arr);
?>