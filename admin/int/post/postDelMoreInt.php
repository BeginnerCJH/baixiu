<?php

/**
 * 此页面是用于批量删除
 */

  //  1引入外部文件
require "../../../dbFunction.php";
  // 2获取用户传递过来的id
$ids = $_GET["ids"];
  // 3调用封装删除多个数据的方法
$res = dbDelMore("posts", $ids);
  // 4判断数据是否删除成功 ---------按一定的格式返回
if ($res) {
  $arr = [
    "code" => 1,
    "msg" => "数据批量删除成功"
  ];
} else {
  $arr = [
    "code" => 0,
    "msg" => "数据批量删除失败"
  ];
}
  // 5返回结果
echo json_encode($arr);
?>