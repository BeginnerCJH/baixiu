 <?php 
  // 定义变量$current_page的默认值
  $current_page= isset($current_page)?$current_page:''

 ?>
 <div class="aside">
    <div class="profile">

    </div>
    <ul class="nav">
      <li <?php echo $current_page=='index'? 'class="active"' :''?>>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <?php $menu_posts=array("posts","post-add","categories");?>
      <li <?php echo in_array($current_page,$menu_posts)?'class="active"':''?>>
        <a href="#menu-posts"  <?php echo in_array($current_page,$menu_posts)?'':' class="collapsed"'?>  data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($current_page,$menu_posts)?' in':''?>">
          <li <?php echo $current_page=='posts'? 'class="active"' :''?>><a href="posts.php">所有文章</a></li>
          <li <?php echo $current_page=='post-add'? 'class="active"' :''?>><a href="post-add.php">写文章</a></li>
          <li <?php echo $current_page=='categories'? 'class="active"' :''?>><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li <?php echo $current_page=='comments'?'class="active"':''?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li <?php echo $current_page=='users'?'class="active"':''?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <?php $menu_settings=array("nav-menus","slides","settings");?>
      <li <?php echo in_array($current_page,$menu_settings)?'class="active"':''?>> 
        <a href="#menu-settings" <?php echo in_array($current_page,$menu_settings)?'':' class="collapsed"'?> data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo in_array($current_page,$menu_settings)?' in':''?>"">
          <li <?php echo $current_page=='nav-menus'? 'class="active"' :''?>><a href="nav-menus.php">导航菜单</a></li>
          <li <?php echo $current_page=='slides'? 'class="active"' :''?>><a href="slides.php">图片轮播</a></li>
          <li <?php echo $current_page=='settings'? 'class="active"' :''?>><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- 此模板是动态渲染左侧头像和用户名 -->
  <script id="asideItems" type="text/template">
      <img class="avatar" src="{{avatar}}">
      <h3 class="name">{{nickname}}</h3>
  </script>

  <script>
    window.onload=function () {
      render();
      // console.log('aaa');
      function render() {
        $.ajax({
        type:"get",
        url:"./int/profile/profileSelectInt.php",
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            var str =template("asideItems",res.data[0]);
            $(".profile").html(str);
           } 
         }
      }); 
    }
  }

  
  </script>
 