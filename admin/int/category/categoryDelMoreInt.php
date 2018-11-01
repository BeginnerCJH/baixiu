<?php
/**
 * 此页面用于目录分类的批量删除
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取传递过来的id值
  $ids=$_GET["ids"];
  // 3调用封装好的删除批量的方法
  $res=dbDelMore("categories",$ids);
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