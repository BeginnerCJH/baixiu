<?php 
 // 1引入外部文件
 require "../dbFunction.php";
 // 2检查用户登录状态
   checkLogin();
 //  3获取用户登录信息
   $current_user=$_SESSION["userInfo"];
  //  print_r($current_user);
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
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong>发生XXX错误
      </div>
      <form id="myForm" class="form-horizontal">
        
      </form>
    </div>
  </div>

  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script>NProgress.done()</script>
  <!-- 此模板是用于 页面的个人中心信息的渲染 -->
  <script id="profileItems" type="text/template">
    <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file" name="avatar">
              <img id="img" src="{{avatar}}">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="{{email}}" placeholder="邮箱" readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" class="form-control" name="slug" type="type" value="{{slug}}" placeholder="slug">
            <p class="help-block">https://zce.me/author/<strong>zce</strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="{{nickname}}" placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" class="form-control" name="bio" placeholder="Bio" cols="30" rows="6">{{bio}}</textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary" id="btnUpdate">更新</button>
            <a class="btn btn-link" href="password-reset.php">修改密码</a>
          </div>
        </div>
  
  </script>
  <script>
  // 1发送ajax请求 动态渲染数据
  $.ajax({
    type:"get",
    url:"./int/profile/profileSelectInt.php",
    dataType:"json",
    success:function (res) {
      if(res&&res.code==1){
        // 1.2调用模板方法
        var str=template("profileItems",res.data[0]);
        $("#myForm").html(str);
      }
      
    }
  });
  // 2上传头像
  $("#myForm").on("change","#avatar",function () {
      console.log('aaa');
      // 2.1创建异步对象
      var xhr=new XMLHttpRequest();
      // 2.2设置请求行
      xhr.open("post","./int/profile/avatarInt.php");
      // 2.3设置请求头---------实例化FormData会自动匹配请求头
      var data=new FormData();
      data.append("avatar",this.files[0]);
      // 2.4设置请求体
      xhr.send(data);
      // 2.5监听异步对象
      xhr.onreadystatechange=function () {
        if(xhr.readyState==4 && xhr.status==200){
          // 接收服务端响应回来的数据
          var data=xhr.responseText;
          // 把字符串转成我们想要的对象
          var res=JSON.parse(data);
          // 判断
          if(res&&res.code==1){
            console.log('1');
            $("#img").attr("src",res.path);

          }
        }
      }
  });

  // 3更新个人中心页面
  $("#myForm").on("click","#btnUpdate",function () {
      console.log('aa');
     // 3.1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/profile/profileUpdateInt.php",
        data:$("#myForm").serialize(),
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            $(".alert").fadeIn(500).delay(2000).fadeOut(500).html("<strong>正确！</strong>"+res.msg+"");
            // 重新跳转页面
            location.href="./profile.php";
             
          }
          
        }
      });
      return false;
    });
   



   
    
  
  
  
  
  
  
  
  
  
   // // 2上传头像预览
  // $("#myForm").on("change","#avatar",function () {
  //     preview(this);
  // });

  // function preview(obj){ 
  //     var img = document.getElementById("img");
  //     img.src = window.URL.createObjectURL(obj.files[0]);
  //     console.log(img.src);            
  // }

  </script>
</body>
</html>
