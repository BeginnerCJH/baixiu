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
  <title>Slides &laquo; Admin</title>
  <?php include "./inc/css.php" ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myForm">
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input type="hidden" name="image" id="hidden">
              <input id="image" class="form-control" name="image" type="file">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <input class="btn btn-primary" type="button" id="btnAdd" value="添加">
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
                <th class="text-center">图片</th>
                <th>文本</th>
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
  <?php $current_page = "slides"; ?>
  <?php include "./inc/aside.php" ?>

  <?php include "./inc/js.php" ?>
  <!-- <script>NProgress.done()</script> -->
  <!-- 此模板是用于页面上右侧数据的动态渲染 -->
  <script id="slidesItems" type="text/template">
    {{each data as val key}}
        <tr>
              <td class="text-center"><input type="checkbox" class="chk" data-id="{{key}}"></td>
              <td class="text-center"><img class="slide" src="{{val.image}}"></td>
              <td>{{val.text}}</td>
              <td>{{val.link}}</td>
              <td class="text-center">
                <!-- <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id="{{key}}">删除</a> -->
                <div class="btn btn-danger btn-xs btnDel" data-id="{{key}}">删除</div>
              </td>
         </tr>
    {{/each}}
  </script>


  <script>
  // 1动态渲染页面右侧数据
  render();
  function render() {
    // 1.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/slides/slidesSelectInt.php",
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1)
        // 1.2调用模板方法
        var str=template("slidesItems",res)
        // 1.3动态渲染数据
        $("tbody").html(str);
        
      }
    });
    //原生注册事件
    /* document.getElementById("image").onchange=function () {
      console.log('aaa');
      
       // 2.1准备数据
      var data =new FormData();
      data.append("image",this.files[0]);
      // 2.2发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/slides/slidesImageInt.php",
        data:data,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
          alert('上传图片完成')
            // 把图片显示在页面上
             $(".thumbnail").show().attr("src",res.src);
            //  把图片存储在隐藏域中
            $("#hidden").val(res.src);
            
            
          }
        }
      });
    } */
    // 2文件上传
    $("#image").off("change").on("change",function () {
      
          console.log('aaa');
      
       // 2.1准备数据
      var data =new FormData();
      data.append("image",this.files[0]);
      // 2.2发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/slides/slidesImageInt.php",
        data:data,
        contentType:false,
        processData:false,
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 把图片显示在页面上
             $(".thumbnail").show().attr("src",res.src);
            //  把图片存储在隐藏域中
            $("#hidden").val(res.src);
            
            
          }
        }
      });
    
      
      
    });
    //原生注册事件
    /* document.getElementById("btnAdd").onclick=function () {
      console.log('click');
      
      // 3.1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/slides/slidesInsertInt.php",
        data:$("#myForm").serialize(),
        dataType:"json",
        success:function (res) { 
          if(res&&res.code==1){
            // 调用函数重新渲染页面
            render();
            // 隐藏图片
            $(".thumbnail").attr("src","");
            // 清空用户输入的内容
            $("input[name]").val("");
            
          }
          
        }
      });
    } */
    // 3页面上的添加
    $("#btnAdd").off("click").on("click",function () {

       console.log('click');
      
      // 3.1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/slides/slidesInsertInt.php",
        data:$("#myForm").serialize(),
        dataType:"json",
        success:function (res) { 
          if(res&&res.code==1){
            // 调用函数重新渲染页面
            render();
            // 隐藏图片
            $(".thumbnail").attr("src","").hide();
            // 清空用户输入的内容
            $("input[name]").val("");
            
          }
          
        }
      });

    
    
    });

    
    // 4页面上的删除
    $("table").off("click").on("click",".btnDel",function () {
      console.log('000');
       // 3.1发送ajax请求
      $.ajax({
        type: "get",
        url: "./int/slides/slidesDeleteInt.php",
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
    })
  
      // $('table').on('click','.btnDel',function(){
      //   alert(1)
      // })
    // 5给全选按钮注册事件
     $("#chkToggle").off("click").on("click",function () {
      // 5.1获取当前全选按钮的状态
      var flag = $(this).prop("checked");
      // 5.2把获取的状态赋值给小按钮
      $(".chk").prop("checked",flag);
      // 5.3判断状态
      if(flag){
        $("#delAll").show();
      }else {
        $("#delAll").hide();
      }
      
    });

    // 6给每个小选框注册事件
    $("tbody").off("click").on("click",".chk",function () {
      // 6.1获取被选中按钮的个数
      var chkCount=$(".chk:checked").size();
      // 6.2判断 只要选中按钮的个数超过2 就算批量
      if(chkCount>=2){
        $("#delAll").show();
      }else {
        $("#delAll").hide();
      }
      // 6.3获取全部小选框的个数
      var inputCount=$(".chk").size();
      // 6.4判断 只要选中按钮的个数等于全部小选框
      if(chkCount==inputCount){
        $("#chkToggle").prop("checked",true);
      }else {
        $("#chkToggle").prop("checked",false);
      }
      
    });

    // 7给批量删除按钮注册事件
    $("#delAll").off("click").on("click",function () {
      // 7.1定义一个数组 存储索引
      var indexs=[];
      // 7.2获取被选中按钮的索引值
      $(".chk:checked").each(function (index,ele) {
        indexs.push($(ele).attr("data-id"));
        
      });
      // 7.3发送ajax请求
      $.ajax({
        type:"get",
        url:"./int/slides/slidesDelMore.php",
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
            // 取消全选按钮的状态
            $("#chkToggle").prop("checked",false);
          }
          
        }
      });
      
    });
    
  }
</script>
</body>
</html>
