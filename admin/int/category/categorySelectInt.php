<?php
  /**
   * 此页面用于是分类目录的数据的动态渲染
   */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql="select * from categories";
  // 3调用封装好的数据查询方法
  $data=dbSelect($sql);
  // 4判断数据是否查询成功---------按照一定的格式返回到浏览器端
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
  // 5把结果响应回来浏览器端 ajax前后端交互只能传输字符串或者是二进制的格式
  echo json_encode($arr);

?>