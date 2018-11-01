<?php
  /**
   * 此页面用于批量删除
   */
  // 获取当前登录用户的flag
  // 开启session
  session_start();
  $flag=$_SESSION["userInfo"]["flag"];
  // 判断flag是否等于0
  if($flag!=='0'){
    $arr=array(
      "code"=>-1,
      "msg"=>"批量删除失败，对不起，你没有权限！"
    );
  }else {
    // 1引入外部文件
    require "../../../dbFunction.php";
    // 2获取用户传递过来的id
    $ids=$_GET["ids"];
    // 3调用封装好的删除多个数据的方法
    $res=dbDelMore("users",$ids);
    // 4判断数据是否删除成功---------按照一定的格式返回浏览器端
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
  }
  
  // 5把结果响应回浏览器端
  echo json_encode($arr);
?>