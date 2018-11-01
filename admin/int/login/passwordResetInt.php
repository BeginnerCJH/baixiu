<?php 
/**
 * 此页面用于修改密码
 */
//  1引入外部文件
    require "../../../dbFunction.php";
    //  print_r($_POST);
    //  exit;
    // 2调用修改函数的方法
    $res=dbUpdate("users",$_POST);
     // 3判断数据是修改成功------------按照一定的格式返回到浏览器端
    if($res){
      $arr=array(
        "code"=>1,
        "msg"=>"密码更改成功..."
      );
    }else {
      $arr=array(
        "code"=>0,
        "msg"=>"密码更改失败..."
      );
    }
    // 4返回数据到浏览器端
    echo json_encode($arr);
?>