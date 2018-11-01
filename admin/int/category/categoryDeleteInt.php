<?php
/**
 * 此页面用户分类目录的删除
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id
  $id=$_GET["id"];
  // 3调用封装好的数据删除方法
  $res=dbDelete("categories",$id);
  // 4判断数据是否删除成功----------------------按照一定的格式返回到浏览器端
  if($res){
    $arr=array(
      "code"=>1,
      "msg"=>"数据删除成功..."
    );
  }else {
     $arr=array(
      "code"=>0,
      "msg"=>"数据删除失败..."
    );
  }
  // 5把结果响应回来浏览器端
  echo json_encode($arr);


?>