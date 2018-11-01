<?php
/**
 * 此页面是用于评论的驳回
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取用户传递过来的id
  $id=$_GET["id"];
  // 3设置一个数组
  $comArr=[
    "id"=>$id,
    "status"=> "rejected"
  ];
  // 3调用封装好的数据更新方法
  $res=dbUpdate("comments",$comArr);
  // 4判断数据是否更新成功------------按照一定的格式返回到浏览器端
  if ($res) {
    $arr = array(
      "code" => 1,
      "msg" => "数据更新成功..."
    );
  } else {
    $arr = array(
      "code" => 0,
      "msg" => "数据更新失败..."
    );

  }
  // 5把结果响应回来浏览器端
  echo json_encode($arr);

?>