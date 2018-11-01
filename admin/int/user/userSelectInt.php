<?php
  /**
   * 此页面用户动态获取数据库的数据来渲染页面
   */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句
  $sql="select * from users where flag=1";
  // 3调用封装好的数据语句
  $data=dbSelect($sql);
  // 4判断数据是否查询成功---按照一定的格式返回浏览器端
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

  // 5把结果响应回浏览器端
  echo json_encode($arr);


?>