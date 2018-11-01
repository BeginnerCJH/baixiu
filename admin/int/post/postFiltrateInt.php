<?php
  /**
   * 此页面是用于筛选条件查询
   */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2获取前台传递过来的内容---默认为空
  $category_id=isset($_GET["category_id"])? $_GET["category_id"]:"";
  $status=isset($_GET["status"])? $_GET["status"]:"";
  // 1接收跳转的页码数
  $page=isset($_GET["page"])?$_GET["page"]:1;
  // 2每页显示的文章个数
  $pageSize=10;
  // 3设置每个页面中查询数据是从哪里开始查
  $offset=($page-1)*$pageSize;
  // 设置sql语句查询内容
  $sql = "select posts.id,posts.title,posts.created,posts.status,categories.name,users.nickname
        from posts
        left join users on posts.user_id=users.id 
        left join categories on posts.category_id=categories.id";
  //设置sql语句查询筛选后的总条数
  $sqlCount="select count(*) as pageCounts from posts";
  // 3判断用户传递过来的数据是否为空
  if(empty($_GET["category_id"])&&empty($_GET["status"])){
    // 4设置sql语句
    $sql.=" order by posts.created desc
          limit $offset,$pageSize";
  }else if (!empty($_GET["category_id"]) && empty($_GET["status"])) {
     // 4设置sql语句
    $sql.=" where posts.category_id=$category_id
        order by posts.created desc
        limit $offset,$pageSize";
        //设置sql语句查询筛选后的总条数
    $sqlCount.= " where posts.category_id = $category_id";
  }else if (empty($_GET["category_id"]) && !empty($_GET["status"])) {
     // 4设置sql语句
    $sql.=" where posts.status='$status'
        order by posts.created desc
        limit $offset,$pageSize";
        //设置sql语句查询筛选后的总条数
    $sqlCount.= " where posts.status='$status'";
  }else {
     // 4设置sql语句
    $sql.=" where posts.category_id=$category_id and posts.status='$status'
        order by posts.created desc
        limit $offset,$pageSize";
        //设置sql语句查询筛选后的总条数
    $sqlCount.= " where posts.category_id=$category_id and posts.status='$status'";
  }
    // 调用封装好的查询方法
    $pageCounts= dbSelect($sqlCount);
    // print_r($pageCounts);
    // exit;
    // 计算数据的总页码数
    $pageNum=ceil($pageCounts[0]["pageCounts"]/$pageSize);
    // 5调用封装好的函数查询方法
    $data=dbSelect($sql);
    // 6判断数据是否查询成功----------按照一定的格式返回到浏览器端
    if(is_array($data)){
      $arr=[
        "code"=>1,
        "msg"=>"数据查询成功",
        "pageNum"=>$pageNum,
        "data"=>$data
      ];
    }else {
      $arr=[
        "code"=>0,
        "msg"=>"数据查询失败",
        "data"=>$data
      ];
    }

   // 7把结果响应回浏览器端
    echo json_encode($arr);
?> 