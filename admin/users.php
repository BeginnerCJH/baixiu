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
  <title>Users &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
   <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong>发生XXX错误
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="myForm">
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" id="btnAdd">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none" id="delAll">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox" id="chkToggle"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $current_page="users";?>
  <?php include "./inc/aside.php";?>

  <?php include "./inc/js.php";?>
  <script>NProgress.done()</script>

   <!-- 创建模板----动态渲染页面数据 状态（unactivated/activated/forbidden/trashed）-->
  <script id="userItems" type="text/template">
    {{each data as val key}}
       <tr>
            <td class="text-center"><input type="checkbox" class="chk" data-id={{val.id}}></td>
            <td class="text-center"><img class="avatar" src="{{val.avatar}}"></td>
            <td>{{val.email}}</td>
            <td>{{val.slug}}</td>
            <td>{{val.nickname}}</td>
            {{if val.status=="unactivated"}}
            <td>未激活</td>
            {{else if val.status=="activated"}}
            <td>激活</td>
            {{else if val.status=="forbidden"}}
            <td>禁用</td>
            {{else}}
            <td>废弃</td>
            {{/if}}
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs btnEdit" data-id={{val.id}}>编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id={{val.id}}>删除</a>
            </td>
        </tr>
    {{/each}}
  </script>
  <!-- 创建模板----用户编辑页面 -->
  <script id="userEdit" type="text/template">

    <h2>编辑用户</h2>
    <!-- 设置隐藏域 把id传输给服务器 根据id来更新用户信息 -->
    <input type="hidden" name="id" value="{{id}}">
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱" value="{{email}}">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="{{slug}}">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="{{nickname}}">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" id="btnUpdate">更新</button>
            </div>
  </script>
  <!-- 此模板是用于更新后 恢复添加页面 -->
  <script id="userAdd" type="text/template">
    <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" id="btnAdd">添加</button>
            </div>
  </script>


  <script>
  // 1动态获取数据渲染页面的用户列表--------通过发送ajax请求局部刷新页面
  render();
  function render() {
    // 1.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/user/userSelectInt.php",
      dataType:"json",//解析的格式---------重点
      success:function (res) {
        if(res&&res.code==1){
          // 调用模板的方法
          var str=template("userItems",res);
          //渲染数据
          $("tbody").html(str);
        }
      }
    });
 }
  // 获取存储在类main里面自定义的属性值
  var currentFlag=$(".main").attr("data-flag");
  // 2添加新用户
  $("#myForm").on("click","#btnAdd",function () {  
    // 2.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/user/userInsertInt.php",
      data:$("#myForm").serialize(),//表单序列话 获取表单内所有包含name属性的值 并返回一个字符串
      dataType:"json",
      // 数据响应成功后调用
      success:function (res) {
        if(res&&res.code==1){
          // 调用函数  重新渲染用户列表的数据
          render();
          //清空用户输入的内容
          $("input[name]").val("");
        }else if(res&&res.code==-1){
          $(".alert").fadeIn(500).delay(2000).fadeOut(500).html("<strong>错误！</strong>"+res.msg+"");
        }
        
      }
    });
    
    return false;//阻止默认事件
  });
  // 3页面上用户的删除-------创建模板中的元素等于动态创建元素 不能直接注册事件 需要通过其父亲为其委派
  $("tbody").on("click",".btnDel",function () {
    // 3.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/user/userDeleteInt.php",
      data:{
        id:$(this).attr("data-id")//获取用户当前的id 
    
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 调用函数  重新渲染页面的数据
          render();
        }else if(res&&res.code==-1){
          $(".alert").fadeIn(500).delay(2000).fadeOut(500).html("<strong>错误！</strong>"+res.msg+"");
        }
        
      }
    });
    
  });

  // 4页面上用户的编辑
  $("tbody").on("click",".btnEdit",function () {
    // 4.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/user/userEditInt.php",
      data:{
        id:$(this).attr("data-id")
        
      },
      dataType:"json",
      // 数据响应成功后调用
      success:function (res) {
        // console.log(typeof res.data);
        
        if(res&&res.code==1){
          // 调用模板方法
          var str=template("userEdit",res.data[0]);
          // 渲染数据
          $("#myForm").html(str);
        }else if(res&&res.code==-1){
          $(".alert").fadeIn(500).delay(2000).fadeOut(500).html("<strong>错误！</strong>"+res.msg+"");
        }
        
      }
    });
    
  });

  //5页面上的用户更新
  $("#myForm").on("click","#btnUpdate",function () {
    // 5.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/user/userUpdate.php",
      data:$("#myForm").serialize(),//表单序列话  获取表单内所有包含name属性的值 并返回一个字符串
      dataType:"json",
      // 数据响应成功后调用
      success:function (res) {
        if(res&&res.code==1){
          // 调用函数 重新渲染页面数据
          render();
          // 更新成功后 页面恢复添加的页面
          var str=template("userAdd",{});
           // 渲染数据
          $("#myForm").html(str);

        }
      }
    });
    return false;//阻止默认事件
    
    
  });

  // 6页面上的批量删除
  // 6.1给全选框注册事件 控制下面选框的勾选与否
  $("#chkToggle").on("click",function () {
    
    // 6.2获取全选框的状态
    var flag=$(this).prop("checked");
    // 6.3把全选框的状态赋值给下面选框
    $(".chk").prop("checked",flag);
    // 6.4控制批量删除按钮的显示与否
    if(flag){
      $("#delAll").show();
    }else{
      $("#delAll").hide();
    }
    
  });

  // 7.1给每个选框注册按钮事件
  $("tbody").on("click",".chk",function () {
    // 7.2获取tbody下按钮input被选中的个数
    // var chkLength=$("tbody .chk:checked").length;
    // 7.2获取被选中按钮的个数
    var chkCount=$(".chk:checked").size();
    // console.log(chkLength);
    // 7.3判断 只要有两个或者两个以上就算批量删除
    if(chkCount>=2){
      $("#delAll").show();
    }else{
      $("#delAll").hide();
    }
    // 7.4获获取tbody下按钮input的个数
    // var inputLength=$("tbody .chk").length;
    // 7.4获取全部input选框的个数
    var inputCount=$(".chk").size();
    // 7.5判断只要是选框全部选择  全选按钮就选中否则就算不选中
    if(chkCount==inputCount){
      $("#chkToggle").prop("checked",true);
    }else {
      $("#chkToggle").prop("checked",false);
    }
  });

  // 8给批量删除按钮注册事件
  $("#delAll").on("click",function () {
  //  8.1获取选中按钮的id
    var ids=[];
    $(".chk:checked").each(function (index,ele) {
      // 把id值存储到数组中
      ids.push($(ele).attr("data-id"));
    });
    // 8.2发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/user/userDelMoreInt.php",
      data:{
        ids:ids
      
      },
      dataType:"json",//数据回来之后要解析成的格式
      success:function (res) {
        if(res&&res.code==1){
          render();
          $("#delAll").hide();
        }else if(res&&res.code==-1){
          $(".alert").fadeIn(500).delay(2000).fadeOut(500).html("<strong>错误！</strong>"+res.msg+"");
        }  
      }
    });
    
  });







  </script>


</body>
</html>
