<?php
/**
 * 此页面是用于编辑文章图片的修改
 */
  // 1获取文件的名字
  $name=$_FILES["feature"]["name"];
  // 2获取文件名的后缀
  $ext=strrchr($name,".");
  // 3生成一个唯一的文件名
  $imgName=uniqid().$ext;
  // 4设置一个路径 返回前台使用
  $path="../static/uploads/$imgName";
  // 5把文件移动到指定路径
  move_uploaded_file($_FILES["feature"]["tmp_name"],"../../$path");
  // 6按一定的格式返回到浏览器端
  $arr=[
    "code"=>1,
    "msg"=>"上传成功",
    "src"=>$path
  ];
  // 7返回结果
  echo json_encode($arr);
?>