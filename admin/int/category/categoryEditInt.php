<?php
  /**
   * 此页面用于分类页面的编辑
   */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id
  $id=$_GET["id"];
  // 3设置sql语句
  $sql="select * from categories where id=$id";
  // 4调用封装好的数据查询方法
  $data=dbSelect($sql);
  // 5判断数据是否查询成功 ----------- 按照一定的格式返回到浏览器端
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
  // 6把结果返回到浏览器端
  echo json_encode($arr);

?>