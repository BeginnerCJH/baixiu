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
  <title>Password reset &laquo; Admin</title>
 <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>修改密码</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong>发生XXX错误
      </div>
      <form class="form-horizontal">
      <input type="hidden" id="currentPwd" name="currentPwd" value=" <?php echo $current_user["password"]?>">
      <input type="hidden" id="currentId" name="currentId" value=" <?php echo $current_user["id"]?>">
        <div class="form-group">
          <label for="old" class="col-sm-3 control-label">旧密码</label>
          <div class="col-sm-7">
            <input id="old" class="form-control" type="password" placeholder="旧密码">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">新密码</label>
          <div class="col-sm-7">
            <input id="password" class="form-control" type="password" placeholder="新密码">
          </div>
        </div>
        <div class="form-group">
          <label for="confirm" class="col-sm-3 control-label">确认新密码</label>
          <div class="col-sm-7">
            <input id="confirm" class="form-control" type="password" placeholder="确认新密码">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-7">
            <button type="submit" class="btn btn-primary" id="btnReset">修改密码</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script>NProgress.done()</script>

  <script>
    $("#btnReset").on("click",function () {
      // 获取用户输入的内容
      var old=parseInt($("#old").val());
      var password=parseInt($("#password").val());
      var confirm=parseInt($("#confirm").val());
      // 获取当前登录用户的密码
      var currentPwd=parseInt($("#currentPwd").val());
       // 获取当前登录用户的id
      var currentId=parseInt($("#currentId").val());
      
      // console.log(old);
      // console.log(currentPwd);
      // console.log(typeof old);
      // console.log(typeof currentPwd);
      
      // console.log(old==currentPwd);
      
      
      // 1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/login/passwordResetInt.php",
        // 发送请求之前 是否输入内容 检查旧密码是否正确 旧密码不能与新密码一样 新密码与确认密码是否一致
        beforeSend:function () {
          if(old!=currentPwd){
            $(".alert").show().html("<strong>错误！</strong>请输入正确的密码");
            return false;
          }else if(old==password){
             $(".alert").show().html("<strong>错误！</strong>新密码不能与原来密码一样");
            return false;
          }else if(password!=confirm){
            $(".alert").show().html("<strong>错误！</strong>新密码与确认密码不一致");
            return false;
          }
        },
        data:{
          password:confirm,
          id:currentId
        },
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 成功之后跳转到个人中心
            location.href="./login.php";
          }
        }

    });
      
      return false;
      
    })
  
  
  </script>



</body>
</html>

