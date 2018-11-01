<?php
/**
 * 此页面用于分类目录的更新
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2调用封装好的数据更新方法
  $res=dbUpdate("categories",$_POST);
  // 3判断数据是否更新成功------------按照一定的格式返回到浏览器端
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
  // 4把结果响应回来浏览器端
  echo json_encode($arr);
?>