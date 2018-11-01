<?php 
 // 1引入外部文件
 require "../dbFunction.php";
 // 2检查用户登录状态
   checkLogin();
   //  3获取用户登录信息
   $current_user=$_SESSION["userInfo"];

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="myForm">
        <div id="form-hidden"></div>
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content"  name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btnSave">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php $current_page="post-add";?>
  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script src="../static/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="../static/assets/vendors/ueditor/ueditor.all.js"></script>
  <script>NProgress.done()</script>
  <!-- 此模板是用于动态渲染所属分类 -->
  <script id="categoryItmes" type="text/template">
    {{each data as val key}}
    <option value="{{val.id}}">{{val.name}}</option>
    {{/each}}
  </script>
  <!-- 此模板是用于设置隐藏域存储图片路径 -->
  <script id="hiddenItems" type="text/template">
    <input type="hidden" name="feature" value="{{src}}">
  </script>
  <script>
    var ue = UE.getEditor('content',{
      
    });
  // 1发送ajax请求 动态获取所属分类的数据
  $.ajax({
    type:"get",
    url:"./int/category/categorySelectInt.php",
    dataType:"json",
    success:function (res) {
      if(res&&res.code==1){
        // 1.2调用模板的方法
        var str=template("categoryItmes",res);
        // 1.3动态渲染数据
        $("#category").html(str);
      }
      
    }
  });

  // 2用jq的ajax上传图片
  $("#feature").on("change",function () {
    // 2.1准备上传文件
    var data=new FormData();
    data.append("feature",this.files[0]);//以二进制的形式发送到服务器
    // 2.2发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/post/postFeatureInt.php",
      data:data,
      dataType:"json",
      contentType:false,//默认是以啥啥请求头的  但是实例化FormData会自动匹配一个请求头
      processData:false,//默认是解析成字符串的格式  但是FormData是以二进制的形式发送的服务器 所以要阻止
      success:function (res) {
        if(res&&res.code==1){
          $("#feature").prev().show().attr("src",res.src);
          // 2.3调用模板方法创建隐藏域 把图片路径存储到隐藏域中
          var str=template("hiddenItems",res);
          $("#form-hidden").html(str);
        }
      }
    });
    
  });

  // 3保存
  $("#btnSave").on("click",function () {
    // console.log('aaa');
    // 3.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/post/postSaveInt.php",
      data:$("#myForm").serialize(),
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 添加成功后跳转到所有文章的页面
          // location.href="./posts.php";
        }
      }
    });
    
    return false;
    
  });


</script>









  
</body>
</html>
