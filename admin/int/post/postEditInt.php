<?php
/**
 * 此页面是用于文章的编辑的数据渲染
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id
  $id=$_GET["id"];
  // 3设置sql语句
  $sql="select * from posts where id=$id";
   // 4调用封装好的查询方法
  $postData = dbSelect($sql);
  // 3.1设置sql语句查询分类目录
  $ctgSql="select * from categories";
  // 4.1调用封装好的查询方法
  $ctgData=dbSelect($ctgSql);
  // 5判断数据是否查询成功 按一定的格式返回
  if(is_array($postData)){
    $arr=[
      "code"=>1,
      "msg"=>"数据查询成功",
      "ctgData"=> $ctgData,
      "postData"=> $postData
    ];
  }else {
    $arr = [
      "code" => 0,
      "msg" => "数据查询失败",
      "postData" => $postData
    ];
  }
  // 6返回结果
  echo json_encode($arr);
?>