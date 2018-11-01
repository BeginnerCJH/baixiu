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
  <title>Add new post &laquo; Admin</title>
  <?php include "./inc/css.php" ?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>编辑文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" id="myForm">
        
      </form>
    </div>
  </div>
  <?php $current_page = "post-add"; ?>
  <?php include "./inc/aside.php" ?>

  <?php include "./inc/js.php" ?>
  <script src="../static/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="../static/assets/vendors/ueditor/ueditor.all.js"></script>
  <script>
    $("#menu-posts .active a").html("编辑文章");
  </script>
  <script>NProgress.done()</script>
  <script src="../utils/utils.js"></script>
  <!-- 此模板是用于动态渲染要编辑的数据 -->
  <script id="postEditItems" type="text/template">
  <!-- 设置隐藏域 存储要编辑的user_id -->
  <input type="hidden" name="id" value="{{postData[0].id}}">
  
      <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" value="{{postData[0].title}}">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" name="content" cols="30" rows="10" placeholder="内容">{{postData[0].content}}</textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="{{postData[0].slug}}">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <!-- 判断图片是否为空 -->
            {{if postData[0].feature==""}}
            <img class="help-block thumbnail" style="display: none">
            {{else}}
            <img class="help-block thumbnail" src="{{postData[0].feature}}">
            {{/if}}
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              {{each ctgData as val key}}
                <option value="{{val.id}}" {{if val.id==postData[0].category_id}} selected {{else}} ''{{/if}}>{{val.name}}</option>
              {{/each}}
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" value="{{postData[0].created.replace(' ','T')}}">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted" {{if postData[0].status=="drafted"}} selected {{else}} '' {{/if}}>草稿</option>
              <option value="published" {{if postData[0].status=="published"}} selected {{else}} '' {{/if}}>已发布</option>
              <option value="published" {{if postData[0].status=="trashed"}} selected {{else}} '' {{/if}}>回收站</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btnUpdate">更新</button>
          </div>
        </div>
  
  </script>
  <script>
    // 1动态渲染数据
    // 1.1获取地址栏参数中id
    var id=URLHandle.parameter(location.search).id;
    // console.log(id);
    // 1.2发送ajax请求 向后台请求数据
    $.ajax({
      type:"get",
      url:"./int/post/postEditInt.php",
      data:{
        id:id
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 1.3调用模板方法
          var str=template("postEditItems",res);
          // 1.4动态渲染页面
          $("#myForm").html(str);
          // 插入富文本编辑器
          var ue = UE.getEditor('content',{
      
          });
        }
        
      }
    });

    // 2上传图片
    $("#myForm").on("change","#feature",function () {
      // 2.1准备要上传的文件
      var data=new FormData();
      data.append("feature",this.files[0]);
      // 2.2发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/post/postFeatureEditInt.php",
        data:data,
        dataType:"json",
        contentType:false,//不用默认设置请求头 实例化fromdata会自动匹配请求头
        processData:false,//默认是把数据转成字符串 由于是二进制上传 所以取消默认转换
        success:function (res) {
          if(res&&res.code==1){
            // 改变图片的路径
            $("#feature").prev().attr("src",res.src);
            // 把图片路径存储到隐藏域中
            $("#feature").parent().append("<input type='hidden' name='feature' value='"+res.src+"'>");
          }
        }
      });
      
      
    });
    // 3实现更新数据
    $("#myForm").on("click","#btnUpdate",function () {
      // 3.1发送ajax请求
      $.ajax({
        type:"post",
        url:"./int/post/postUpdateInt.php",
        data:$("#myForm").serialize(),
        dataType:"json",
        success:function (res) {
          if(res&&res.code==1){
            // 跳转到所有文章页面
            location.href="./posts.php";
          }
          
        }
      });
      return false;//阻止默认事件
      
    })


</script>




</body>
</html>

