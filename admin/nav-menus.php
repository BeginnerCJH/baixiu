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
  <title>Navigation menus &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myForm">
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <label for="icon">图标 (请按格式添加 fa fa-xxx)</label>
              <input id="icon" class="form-control" name="icon" type="text" placeholder="图标">
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
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
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

  <?php $current_page="nav-menus";?>
  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script>NProgress.done()</script>
  <!-- 此模板是用于页面右侧菜单栏的渲染 -->
  <script id="navmenusItems" type="text/template">
    {{each data as val key}}
       <tr>
            <td class="text-center"><input type="checkbox" class="chk" data-id="{{key}}"></td>
            <td><i class="{{val.icon}}"></i>{{val.text}}</td>
            <td>{{val.title}}</td>
            <td>{{val.link}}</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id="{{key}}">删除</a>
            </td>
       </tr>
    {{/each}}
  </script>
  <script>
    // 1动态渲染页面右侧的菜单数据
    render();
    function render() {
      // 1.1发送ajax请求 从服务器请求数据
      $.ajax({
        type:"get",
        url:"./int/menus/navMenusSelectInt.php",
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 1.2调用模板方法
            var str=template("navmenusItems",res);
            // 1.3动态渲染数据
            $("tbody").html(str);
          }
          
        }
      });
      
    }
    
    // 2页面上的添加数据
    $("#btnAdd").on("click",function () {
      // 2.1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/menus/navMenusInsertInt.php",
        data:$("#myForm").serialize(),
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 调用函数 重新渲染数据
            render();
            // 清空用户输入的内容
            $("input[name]").val("");
          }
          
        }
      });
      
      return false;//阻止默认事件
      
    });

    // 3页面上的删除
    $("tbody").on("click",".btnDel",function () {
      // 3.1发送ajax请求
      $.ajax({
        type: "get",
        url: "./int/menus/navMenusDeleteInt.php",
        data: {
          index:$(this).attr("data-id")
        },
        dataType:"json",
        success: function (res) {
          if(res&&res.code==1){
          // 调用函数 重新渲染页面
          render();
        }
        }
      });
      
      
    });

    // 4给全选按钮注册事件
    $("#chkToggle").on("click",function () {
      // 4.1获取当前全选按钮的状态
      var flag = $(this).prop("checked");
      // 4.2把获取的状态赋值给小按钮
      $(".chk").prop("checked",flag);
      // 4.3判断状态
      if(flag){
        $("#delAll").show();
      }else {
        $("#delAll").hide();
      }
      
    });

    // 5给每个小选框注册事件
    $("tbody").on("click",".chk",function () {
      // 5.1获取被选中按钮的个数
      var chkCount=$(".chk:checked").size();
      // 5.2判断 只要选中按钮的个数超过2 就算批量
      if(chkCount>=2){
        $("#delAll").show();
      }else {
        $("#delAll").hide();
      }
      // 5.3获取全部小选框的个数
      var inputCount=$(".chk").size();
      // 5.4判断 只要选中按钮的个数等于全部小选框
      if(chkCount==inputCount){
        $("#chkToggle").prop("checked",true);
      }else {
        $("#chkToggle").prop("checked",false);
      }
      
    });

    // 6给批量删除按钮注册事件
    $("#delAll").on("click",function () {
      // 6.1定义一个数组 存储索引
      var indexs=[];
      // 6.2获取被选中按钮的索引值
      $(".chk:checked").each(function (index,ele) {
        indexs.push($(ele).attr("data-id"));
        
      });
      // 6.3发送ajax请求
      $.ajax({
        type:"get",
        url:"./int/menus/navMenusDelMoreInt.php",
        data:{
          indexs:indexs
        },
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 调用函数重新渲染页面
            render();
            // 隐藏批量删除按钮
            $("#delAll").hide();
          }
          
        }
      });
      
    });



  </script>



</body>
</html>

