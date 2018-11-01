<?php 
/**
 * 此页面用于页面上文章的动态渲染
 */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 2设置sql语句 多表查询语句 select * from posts,users,categories where posts.user_id=users.id and // posts.category_id=categories.id;
  // order by posts.id 按照什么来排序默认是升序 asc 是默认的升序排列,desc是默认的降序排列 
  // where category_id=3 and posts.status='drafted'
  // $sql="select * from posts users";
  // $sql="select * from posts,users,categories where posts.user_id=users.id and posts.category_id=categories.id order by posts.id";
  // 判断是否传递页数过来
  $page=isset($_GET["page"])?$_GET["page"]:1;
  // 2查询数据库中有多少条数据
  $sqlCount="select count(*) as pageCounts from posts";
   // 3调用封装好的函数查询方法
  $pageCount = dbSelect($sqlCount);
  // print_r($pageCount);
  // exit;
  // array(
  //   [0] => array(
  //     [pageCounts] => 1000
  //   )
    
  // )
  // 4设置默认每页显示的文章个数
  $pageSize=10;
  // 5设置分页的页数 向上取整
  $pageNum=ceil($pageCount[0]["pageCounts"] / $pageSize);
  // 5设置每页数据是从哪里开始查询
  $offset=($page-1)*$pageSize;
  $sql="select posts.id,posts.title,posts.created,posts.status,categories.name,users.nickname
        from posts
        left join users on posts.user_id=users.id 
        left join categories on posts.category_id=categories.id
        order by posts.created desc
        limit $offset,$pageSize";
  // 3调用封装好的函数查询方法
  $data=dbSelect($sql);
  // 4判断数据是否查询成功----------按照一定的格式返回到浏览器端
  if(is_array($data)){
    $arr=[
      "code"=>1,
      "msg"=>"数据查询成功",
      "pageNum"=> $pageNum,
      "data"=>$data
    ];
  }else {
    $arr=[
      "code"=>0,
      "msg"=>"数据查询失败",
      "data"=>$data
    ];
  }
  // 5把结果响应回浏览器端
  echo json_encode($arr);
?>