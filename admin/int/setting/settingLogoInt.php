<?php
/**
 * 此页面是用于文件上传
 */
  // 1获取上传文件名
  $name=$_FILES["logo"]["name"];
  // print_r($_FILES);
  // exit;
  // 2获取文件名后缀
  $ext=strrchr($name,".");
  // 3生成一个唯一的标识符
  $imgName=uniqid().$ext;
  // 4把服务器的图片地址存储到变量中
  $path="../static/uploads/$imgName";
  // 5把文件移动到指定文件中
  move_uploaded_file($_FILES["logo"]["tmp_name"],"../../$path");
  // 6按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"上传成功",
    "src"=>$path
  ];
  // 7返回结果
  echo json_encode($arr);
?>