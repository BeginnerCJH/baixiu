<?php 
/**
 * 此页面是用于批量批准
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id值
  $ids=$_GET["ids"];//结果是一个数组
  // 3把数组连接成字符串
  $idsStr=implode(",",$ids);
  
  // 4设置sql语句
  $sql= "update comments set status = 'approved' where id in ($idsStr)"; 
  
  // 5调用封装好的数据修改放方法
  $res=dbUpdateMore($sql);
  // 6判断数据是否更新成功------------按照一定的格式返回到浏览器端
  if ($res) {
    $arr = array(
      "code" => 1,
      "msg" => "数据批量更新成功..."
    );
  } else {
    $arr = array(
      "code" => 0,
      "msg" => "数据批量更新失败..."
    );
  
  }
  // 7把结果响应回来浏览器端
  echo json_encode($arr);


?>