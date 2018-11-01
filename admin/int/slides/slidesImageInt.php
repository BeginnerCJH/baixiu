<?php
/**
 * 此页面是用于文件上传
 */
  // 1获取文件的名字
  $name=$_FILES["image"]["name"];
  // 2截取文件后缀
  $ext=strrchr($name,".");
  // 3生成一个唯一的文件名
  $imgName=uniqid().$ext;
  // 4. 将图片在服务器的路径存到一个变量当中
  $path="../static/uploads/$imgName";
  // 5把文件移动到指定路径
  move_uploaded_file($_FILES["image"]["tmp_name"],"../../$path");
  // 6按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"上传成功",
    "src"=>$path
  ];
  // 7返回结果
  echo json_encode($arr);
?>