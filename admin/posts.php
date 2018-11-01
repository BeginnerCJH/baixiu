<?php 
 // 1引入外部文件
require "../dbFunction.php";
 // 2检查用户登录状态
checkLogin();
   //  3获取用户登录信息
$current_user = $_SESSION["userInfo"];

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <?php include "./inc/css.php" ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong>发生XXX错误
      </div>
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none" id="delAll">批量删除</a>
        <form class="form-inline" id="myForm">
          <select id="category" name="category_id" class="form-control input-sm">
            
          </select>
          <select id="status" name="status" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">回收站</option>
          </select>
          <button class="btn btn-default btn-sm" id="btnFiltrate">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">

        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" id="chkToggle"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
         
        </tbody>
      </table>
    </div>
  </div>
   <?php $current_page = "posts"; ?>
  <?php include "./inc/aside.php" ?>

  <?php include "./inc/js.php" ?>
  <!-- 引入分页显示的插件 -->
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
  <script>NProgress.done()</script>
  <!-- 此模板用于所有文章的动态数据渲染  状态（drafted/published/trashed）-->
  <script id="postItems" type="text/template">
    {{each data as val key}}
       <tr>
            <td class="text-center"><input type="checkbox" class="chk" data-id="{{val.id}}"></td>
            <td>{{val.title}}</td>
            <td>{{val.nickname}}</td>
            <td>{{val.name}}</td>
            <td class="text-center">{{val.created}}</td>
            {{if val.status=="published"}}
            <td class="text-center">已发布</td>
            {{else if val.status=="drafted"}}
            <td class="text-center">草稿</td>
            {{else}}
            <td class="text-center">回收站</td>
            {{/if}}
            <td class="text-center">
              <a href="./post-edit.php?id={{val.id}}" class="btn btn-default btn-xs btnEdit">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id="{{val.id}}">删除</a>
            </td>
        </tr>
    {{/each}}
  </script>
  <!-- 此模板是用于所有分类的的动态数据渲染 -->
  <script id="categoryItems" type="text/template">
      <option value="">所有分类</option>
  {{each data as val key}}
      <option value="{{val.id}}">{{val.name}}</option>
  {{/each}}
  </script>
  <script>
  // 定义一个变量存储页码值
  var currentPage=1;
  // 1动态渲染页面的所有文章的数据 向服务器请求数据
 // 调用筛选后的函数  重新渲染页面
 renderFiltrate(currentPage);
 function renderFiltrate(page) {
    // 3.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/post/postFiltrateInt.php",
      data:{
        page:page,
        category_id:$("#category").val(),
        status:$("#status").val()
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 3.2调用创建模板的方法
          var str=template("postItems",res);
          // 3.3动态渲染数据
          $("tbody").html(str);
          pagingShow(res.pageNum); 
           console.log(res.pageNum);
          
          //  3.4隐藏错误提示
          $(".alert").hide();
        }else if(res&&res.code==0){
          // 3.4查询失败 清空页面数据
          $("tbody").html('');
          // 3.5提示用户
          $(".alert").show().html("<strong>温馨提示！</strong>数据库中查无此分类或者此状态");
          // 3.6清除全选框的选中按钮
          $("#chkToggle").prop("checked",false);
        }
        
      }
    });
  }
  // 2分页显示数据
  function pagingShow(totalPages) {

    console.log(totalPages);
    
     $('.pagination').twbsPagination({

        totalPages:totalPages,//总页数
        visiblePages: 5,//页面上可见的页数
        first:"首页", 
        prev:"上一页",
        next:"下一页",
        last:"尾页",
        initiateStartPageClick:false,//清除默认选中的第1页
        onPageClick: function (event, page) {
          // 把页码值存储到变量中
            currentPage=page;
            // 调用筛选后的函数  重新渲染页面
            renderFiltrate(page);
             // 清除全选框的选中按钮
            $("#chkToggle").prop("checked",false);
            // 隐藏批量删除按钮
            $("#delAll").hide();              
             
            
        }
    });
  }
 
  
  // 2动态渲染所有分类的数据 发送ajax从服务器请求数据
  $.ajax({
    type:"get",
    url:"./int/category/categorySelectInt.php",
    dataType:"json",
    success:function (res) {
      if(res&&res.code==1){
        // 2.1调用模板方法
        var str=template("categoryItems",res);
        // 2.2动态渲染数据
        $("#category").html(str);
      }
      
    }
  });

  // 3给筛选按钮注册事件
  $("#btnFiltrate").on("click",function () {
    // console.log('aas');
    
    // 调用函数
    renderFiltrate(currentPage);
    // 清除全选框的选中按钮
    $("#chkToggle").prop("checked",false);
    // 隐藏批量删除按钮
    $("#delAll").hide();
    
    return false;//阻止默认事件
  });

       
  // 4页面上删除-----给删除按钮注册事件
  $("tbody").on("click",".btnDel",function () {
    // 4.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/post/postDeleteInt.php",
      data:{
        id:$(this).attr("data-id")
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){

          // 调用函数  重新动态渲染页面
          renderFiltrate(currentPage);
        }
        
      }
    });
    
  });

  // 5页面上的批量删除后
  // 5.1给全选按钮注册事件
  $("#chkToggle").on("click",function () {
    // 5.2获取全选按钮的状态
    var flag=$(this).prop("checked");
    // 5.3把状态赋值给每个小选框
    $(".chk").prop("checked",flag);
    // 5.4判断全选框的状态
    if(flag){
      $("#delAll").show();
    }else{
      $("#delAll").hide();
    }
    
  });
  // 6给小选框注册事件
  $("tbody").on("click",".chk",function () {
    //  6.1获取被选中按钮的个数
    var chkCount=$(".chk:checked").size();
    // 6.2判断 如果选中按钮个数大于2  就视为批量
    if(chkCount>=2){
        $("#delAll").show();
      }else{
        $("#delAll").hide();
      }
    // 6.3获取小选框的个数
    var inputCount=$(".chk").size();
    // 6.4判断 如果选中的个数等于小选框的个数就视为全选
    if(chkCount==inputCount){
      $("#chkToggle").prop("checked",true);
    }else{
      $("#chkToggle").prop("checked",false);
    }
  });
  // 7给批量删除按钮注册事件
  $("#delAll").on("click",function () {
    // 7.1设置一个数组存储id值
    var ids=[];
    // 7.2遍历对象  获取被选中按钮的id值
    $(".chk:checked").each(function (index,ele) {
      // 7.3把值追加到数组中
      ids.push($(ele).attr("data-id"));
 
    })
    // 7.4发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/post/postDelMoreInt.php",
      data:{
        ids:ids
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 调用函数 重新渲染页面
           renderFiltrate(currentPage);
          //  隐藏批量删除按钮
          $("#delAll").hide();
          //取消全选按钮的选中状态
          $("#chkToggle").prop("checked",false);
        }
        
      }
    });
    
    
  });

  

</script>












</body>
</html>

