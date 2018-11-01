<?php
/**
 * 此页面是用于动态渲染页面首页的数据
 */
  // 1引入外部文件
  require "../dbFunction.php";
  // 2调用方法查询导航栏在数据库的数据
  $dataMenus=dbSelect("select `value` from options where `key` = 'nav_menus'")[0]["value"];//返回的是字符串
  // 3把查询结果转成我们想要的数组或对象
  $dataMenusArr=json_decode($dataMenus,true);
  // 4查询轮播图在数据库中的数据
  $dataSlides= dbSelect("select `value` from options where `key` = 'home_slides'")[0]["value"];//返回的是字符串
  // 5把查询结果转成我们想要的数组或对象
  $dataSlidesArr = json_decode($dataSlides, true);
  // n按一定的格式返回
  $arr=[
    "code"=>1,
    "msg"=>"数据查询成功",
    "dataMenus"=> $dataMenusArr,
    "dataSlides"=>$dataSlidesArr
  ];
  // sleep(1);
  // n+1返回结果
  echo json_encode($arr);


?>