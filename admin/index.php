<?php
/**
 * 判断用户是否已经登录过  如果未登录先跳转登录页面
 */
  // 1引入外部文件
  require "../dbFunction.php";
  // 检查用户登录状态
  checkLogin();
  //  获取用户登录信息
   $current_user=$_SESSION["userInfo"];
  // 2.1设置sql语句----------查询文章总数
  $sqlPosts="select count(1) from posts";
  // 3.1调用封装好的函数方法

  $posts_count=dbSelect($sqlPosts);
  // 2.2设置sql语句----------查询文章中草稿总数
  $sqlPostsDrafted="select count(1) from posts where status='drafted'";
  // 3.2调用封装好的函数方法
  $posts_drafted_count=dbSelect($sqlPostsDrafted);
  // print_r($posts_drafted_count);
  // exit;
  // 2.3设置sql语句----------查询分类总数
  $sqlCategories="select count(1) from categories";
  // 3.2调用封装好的函数方法
  $categories_count=dbSelect($sqlCategories);

  // 2.4设置sql语句----------查询评论总数
  $sqlComments="select count(1) from comments";
  // 3.4调用封装好的函数方法
  $comments_count=dbSelect($sqlComments);

  // 2.5设置sql语句----------查询评论中待审核的总数
   $sqlCommentsHeld="select count(1) from comments where status='held'";
  // 3.5调用封装好的函数方法
  $comments_held_count=dbSelect($sqlCommentsHeld);
  


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <?php include "./inc/css.php"?>
  
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo isset($posts_count)?$posts_count[0]["count(1)"]:'查询失败'?></strong>篇文章（<strong><?php echo isset($posts_drafted_count)?$posts_drafted_count[0]["count(1)"]:'查询失败'?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo isset($categories_count)?$categories_count[0]["count(1)"]:'查询失败'?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo isset($comments_count)?$comments_count[0]["count(1)"]:'查询失败'?></strong>条评论（<strong><?php echo isset($comments_held_count)?$comments_held_count[0]["count(1)"]:'查询失败'?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  <?php $current_page="index";?>
  <?php include "./inc/aside.php";?>

  <?php include "./inc/js.php";?>
  <script>NProgress.done()</script>
 
</body>
</html>
