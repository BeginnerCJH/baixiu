<?php
/**
 * 此页面是用于文章上传图片
 */
  
  // print_r($_FILES);
  // exit();
  // 1获取上传文件的名字
  $name=$_FILES["feature"]["name"];
  // 2获取文件名的后缀
  $ext=strrchr($name,".");
  // 3生成一个唯一的文件名
  $imgName=uniqid().$ext;
  // 4设置一个永久路径 返回到前台页面使用
  $path="../static/uploads/$imgName";
  // 5把文件移动的永久路径中
  move_uploaded_file($_FILES["feature"]["tmp_name"],"../../$path");
  // 6上传成功后 按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"上传成功",
    "src"=>$path
  ];
  // 7返回结果
  echo json_encode($arr);
?>