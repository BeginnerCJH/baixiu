<?php 
  /**
   * 此页面是用于动态渲染页面数据
   */
  // 1引入外部文件
  require "../../../dbFunction.php";
  // 设置sql语句查询数据库中评论的总数
  $sqlCount="select count(*) as comCounts from comments";
  // 调用封装好的数据查询语句
  $pageCount=dbSelect($sqlCount);
  
  // 定义每页要显示评论的个数
  $pageSize=10;
  // 计算总页数
  $pageCounts=ceil($pageCount[0]["comCounts"]/$pageSize);
 
  // 获取前台传递过来的页码数 如果没有传默认是1
  $page=isset($_GET["page"])?$_GET["page"]:1;
  // 计算每个页面查询数据是从哪里开始查
  $offset=($page-1)*$pageSize;
  // 2设置sql语句
  $sql="select comments.id,
               comments.created,
               comments.content,
               comments.status,
               comments.author,
               posts.title from comments
               left join posts on comments.post_id=posts.id
               order by comments.created desc
               limit $offset,$pageSize";
  // 3调用已经封装好的函数方法
  $data=dbSelect($sql);
  // 4判断数据是否查询成功---------按一定的格式返回到浏览器端
  if(is_array($data)){
    $arr=[
      "code"=>1,
      "msg"=>"数据查询成功",
      "pageCounts"=>"$pageCounts",
      "data"=>$data
    ];
  }else {
     $arr=[
      "code"=>0,
      "msg"=>"数据查询失败",
      "data"=>$data
    ];
  }
  // 5把结果响应回来浏览器端
  echo json_encode($arr);
?>