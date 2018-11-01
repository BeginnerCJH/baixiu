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
  <title>Comments &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
   <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm" id="approvedAll">批量批准</button>
          <button class="btn btn-warning btn-sm" id="rejectAll">批量驳回</button>
          <button class="btn btn-danger btn-sm" id="delAll">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" id="chkToggle"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
         
         
        </tbody>
      </table>
    </div>
  </div>
  <?php $current_page="comments";?>
  <?php include "./inc/aside.php";?>

  <?php include "./inc/js.php";?>
  <!-- 引入分页插件 -->
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
  <script>NProgress.done()</script>
  <!-- 动态渲染页面数据的模板  状态（held/approved/rejected/trashed）-->
  <script id="commentItems" type="text/template">
    {{each data as val key}}
        {{if val.status=="approved"}}
          <tr>
        {{else}}
          <tr class="danger">
        {{/if}}
            <td class="text-center"><input type="checkbox" class="chk" data-id="{{val.id}}"></td>
            <td>{{val.author}}</td>
            <td>{{val.content}}个</td>
            <td>{{val.title}}</td>
            <td>{{val.created}}</td>
            {{if val.status=="approved"}}
            <td>已批准</td>
            {{else if val.status=="rejected"}}
            <td>已驳回</td>
            {{else if val.status=="held"}}
            <td>待审核</td>
            {{else }}
            <td>回收站</td>
            {{/if}}
            <td class="text-center">
            <!-- 判断 -->
            {{if val.status=="approved"}}
            <a href="javascript:;" class="btn btn-warning btn-xs btnReject" data-id="{{val.id}}">驳回</a>
            {{else}}
            <a href="javascript:;" class="btn btn-info btn-xs btnApproved" data-id="{{val.id}}">批准</a>
            {{/if}}
              <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id="{{val.id}}">删除</a>
            </td>
        </tr>
    {{/each}}
  
  </script>
  <script>
  // 1动态渲染数据 向服务器发送请求 从数据库请求数据回来
  render();
  function render() {
    // 1.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentSelectInt.php",
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 1.2调用引擎模板的方法
          var str=template("commentItems",res);
          // 1.3动态渲染数据
          $("tbody").html(str);
          pagingShow(res.pageCounts);
        }
        
      }
    });
  }

  // 2分页显示数据
  // 定义一个变量存储当前页面数
  var currentPage=1;
  function pagingShow(totalPages) {
    $('.pagination').twbsPagination({
        totalPages: totalPages,
        visiblePages: 5,
        first:"首页",
        prev:"上一页",
        next:"下一页",
        last:"尾页",
        initiateStartPageClick:false,
        onPageClick: function (event, page) {
          // 把当前的页码数存储到全局变量中
         currentPage=page;
         //  调用函数 动态渲染数据
         renderPaging(page);
        //  清除全选按钮的状态
         $("#chkToggle").prop("checked",false);
        //  隐藏批量数据处理
        $(".btn-batch").hide();
        }
    });
  }  
  // 2.1分页渲染数据
  function renderPaging(page) {
     //  2.1发送ajax请求 把当前的页数发送的后台
          $.ajax({
            type:"get",
            url:"./int/comment/commentSelectInt.php",
            data:{
              page:page
            },
            dataType:"json",
            success:function (res) {
              if(res&&res.code==1){
                // 1.2调用引擎模板的方法
                var str=template("commentItems",res);
                // 1.3动态渲染数据
                $("tbody").html(str);
              }
              
            }
          });
  }

  // 3页面上的数据删除
  $("tbody").on("click",".btnDel",function () {
    // 3.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentDeleteInt.php",
      data:{
        id:$(this).attr("data-id")
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 成功后重新渲染当前页数的数据
          renderPaging(currentPage);
        }
        
      }
    });
    
    
  });

  // 4批量处理数据之批量删除
  // 4.1给全选按钮注册事件
  $("#chkToggle").on("click",function () {
    
    // 4.2获取当前全选选中的状态
    var flag=$(this).prop("checked");
    // 4.3把获取的状态赋值给每个小选框
    $(".chk").prop("checked",flag);
    // 4.4判断是否选中
    if(flag){
      $(".btn-batch").show();
    }else{
      $(".btn-batch").hide();
    }
    
  });
  // 5给每个小选框注册事件
  $("tbody").on("click",".chk",function () {
    // 5.1获取被选中小选框的个数
    var chkCount=$(".chk:checked").size();
    // 5.2判断 如果是超过两个选中就视为批量
    if(chkCount>=2){
      $(".btn-batch").show();
    }else{
      $(".btn-batch").hide();
    }
    // 5.3获取全部小选框的按钮
    var inputCount=$(".chk").size();
    // 5.4判断 如果是选中的按钮的个数等于全部小选框的个数 视为全选
    if(chkCount==inputCount){
      $("#chkToggle").prop("checked",true);
    }else {
      $("#chkToggle").prop("checked",false);
    }
    
  });
  
  // 6给批量删除注册事件
  $("#delAll").on("click",function () {
    // 6.1定义一个数组存储id值
    var ids=[];
    // 6.2获取被选中按钮的id值
    $(".chk:checked").each(function (index,ele) {
      ids.push($(ele).attr("data-id"));
    });
    console.log(ids);
    
    // 6.3发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentDelMoreInt.php",
      data:{
        ids:ids
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 调用分页函数  动态渲染分页数据
          renderPaging(currentPage);
          // 隐藏批量按钮
          $(".btn-batch").hide();
          // 取消全选按钮的状态
          $("#chkToggle").prop("checked",false);
        }
        
      }
    });
    
  });

  // 7给驳回注册事件
  $("tbody").on("click",".btnReject",function () {
    // 7.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentRejectInt.php",
      data:{
        id:$(this).attr("data-id"),
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
           // 成功后重新渲染当前页数的数据
          renderPaging(currentPage);
        }
        
      }
    });
    
  });

  // 8给批准注册事件
  $("tbody").on("click",".btnApproved",function () {
    // 7.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentApprovedInt.php",
      data:{
        id:$(this).attr("data-id"),
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
           // 成功后重新渲染当前页数的数据
          renderPaging(currentPage);
        }
        
      }
    });
    
  });

  // 9给批量批准注册事件
  $("#approvedAll").on("click",function () {
    // 9.1定一个数组 存储被选中的id
    var ids=[];
    // 9.2获取被选中按钮的id值
    $(".chk:checked").each(function (index,ele) {
      // 存储被选中的id
      ids.push($(ele).attr("data-id"));
    });
    // 9.3发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentApprovedMoreInt.php",
      data:{
        ids:ids
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
           // 调用分页函数  动态渲染分页数据
          renderPaging(currentPage);
          // 隐藏批量按钮
          $(".btn-batch").hide();
          // 取消全选按钮的状态
          $("#chkToggle").prop("checked",false);
        }
        
      }
    });
    
    
  });

  // 10给批量拒绝注册事件
  $("#rejectAll").on("click",function () {
    // 9.1定一个数组 存储被选中的id
    var ids=[];
    // 9.2获取被选中按钮的id值
    $(".chk:checked").each(function (index,ele) {
      // 存储被选中的id
      ids.push($(ele).attr("data-id"));
    });
    // 9.3发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/comment/commentRejectMoreInt.php",
      data:{
        ids:ids
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
           // 调用分页函数  动态渲染分页数据
          renderPaging(currentPage);
          // 隐藏批量按钮
          $(".btn-batch").hide();
          // 取消全选按钮的状态
          $("#chkToggle").prop("checked",false);
        }
        
      }
    });
    
    
  });



</script>

</body>
</html>

