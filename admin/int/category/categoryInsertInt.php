<?php
/**
 * 此页面用于分类目录的添加
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2调用封装好的数据添加方法
  $res=dbInsert("categories",$_POST);
  // 3判断数据是否添加成功---------按照一定的格式返回到浏览器端 code msg  data 
  if($res){
    $arr=array(
      "code"=>1,
      "msg"=>"数据添加成功..."
    );
  }else {
    $arr=array(
      "code"=>0,
      "msg"=>"数据添加失败..."
    );
  }
  // 4把结果返回到浏览器端
  echo json_encode($arr);

?>