
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> 用户名或密码错误
      </div>
      <div class="form-group">
      <!-- 保持表单状态 用户提交表单后除了显示错误信息之外 应该保持一下非隐私的内容 账号不清空 可以让用户更清晰知道 -->
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" id="btnLogin">登 录</a> -->
      <button class="btn btn-primary btn-block" type="submit" id="btnLogin">登 录 </button>
    </form>
  </div>
</body>
<script src="../static/assets/vendors/jquery/jquery.min.js"></script>
<script>
  $("#btnLogin").on("click",function () {
    console.log('hhh');

     // 获取用户输入的邮箱和密码
    var email=$("#email").val();
    var password=$("#password").val()
    // 1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/login/loginInt.php",
      // 请求发送前调用
      beforeSend:function () {
        if($.trim(email)=='' || $.trim(password)==''){
          $(".alert").show().html("<strong>错误！</strong> 请填写完整表单！");
          return false;
        }
      },
      data:$(".login-wrap").serialize(),
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 跳转主页
          location.href="./index.php";
        }else if(res&&res.code==0){
          $(".alert").show().html("<strong>错误！</strong> "+res.msg+"");
        }
        else if(res&&res.code==2){
          $(".alert").show().html("<strong>错误！</strong> "+res.msg+"");
        }
        else if(res&&res.code==3){
          $(".alert").show().html("<strong>错误！</strong> "+res.msg+"");
        }
        else if(res&&res.code==4){
          $(".alert").show().html("<strong>错误！</strong> "+res.msg+"");
        }
        else if(res&&res.code==5){
          $(".alert").show().html("<strong>错误！</strong> "+res.msg+"");
        }
      }
    });
     
   












    return false;
    
  });

</script>
</html>

