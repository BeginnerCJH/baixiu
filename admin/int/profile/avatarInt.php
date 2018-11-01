<?php
/**
 * 此页面是用于头像预览
 */
  // 1获取图片的文件名
  $name=$_FILES["avatar"]["name"];
  // 2获取文件后缀名
  $ext=strrchr($name,".");
  // 3生成一个为一个名称的图片
  $imgname=uniqid().$ext;
  // 4设置文件存储的永久路径
  $path="../static/uploads/$name";
  // 5把文件路径存储到数组中
  
  // 6移动文件到指定路径
  move_uploaded_file($_FILES["avatar"]["tmp_name"],"../../$path");
  // 7把路径存储到数据库中
  // 7.1引入外部文件
  require "../../../dbFunction.php";
  // 7.2获取当前登录对象的id
  session_start();
  $id=$_SESSION["userInfo"]["id"];
  // 7.3把id跟路径存储到数组中
  $arr=[
    "id"=>$id,
    "avatar"=>$path
  ];
  // 7.4调用修改数据的方法
  $res=dbUpdate("users",$arr);
  // 7.5判断 // 把结果按一定格式返回到浏览器端
  if($res){
      $arr=[
       "code"=>1,
       "msg"=>"上传成功",
       "path"=>$path
    ];
  }else {
     $arr=[
      "code"=>0,
      "msg"=>"上传失败"
    ];
  }
  // 返回结果
  echo json_encode($arr);

?>