
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
  <title>Settings &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>网站设置</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" id="myForm">
        
      </form>
    </div>
  </div>
  <?php $current_page="settings";?>
  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script>NProgress.done()</script>
  <!-- 此模板是动态渲染页面 -->
  <script id="settingItems" type="text/template">
    <div class="form-group">
          <label for="site_logo" class="col-sm-2 control-label">网站图标</label>
          <div class="col-sm-6">
            <input id="site_logo" name="site_logo" type="hidden">
            <label class="form-image">
              <input id="logo" type="file">
              <img src="{{data[1].value}}" id="iconImg">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="site_name" class="col-sm-2 control-label">站点名称</label>
          <div class="col-sm-6">
            <input id="site_name" name="site_name" class="form-control" type="type" placeholder="站点名称" value="{{data[2].value}}">
          </div>
        </div>
        <div class="form-group">
          <label for="site_description" class="col-sm-2 control-label">站点描述</label>
          <div class="col-sm-6">
            <textarea id="site_description" name="site_description" class="form-control" placeholder="站点描述" cols="30" rows="6">{{data[3].value}}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="site_keywords" class="col-sm-2 control-label">站点关键词</label>
          <div class="col-sm-6">
            <input id="site_keywords" name="site_keywords" class="form-control" type="type" placeholder="站点关键词" value="{{data[4].value}}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">评论</label>
          <div class="col-sm-6">
            <div class="checkbox">
              <label><input id="comment_status" name="comment_status" type="checkbox" {{if data[6].value=="1"}}checked {{else if data[6].value=="0"}}  {{/if}}>开启评论功能</label>
            </div>
            <div class="checkbox">
              <label><input id="comment_reviewed" name="comment_reviewed" type="checkbox" {{if data[7].value=="1"}} checked {{else if data[7].value=="0"}}  {{/if}} >评论必须经人工批准</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-6">
            <button type="submit" class="btn btn-primary" id="btnSave">保存设置</button>
          </div>
        </div>
  
  </script>



  <script>
  // 1动态渲染页面 从服务器拿取数据
  render();
  function render() {
    // 1.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/setting/settingSelectInt.php",
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 1.2调用模板方法
          var str = template("settingItems",res);
          // 1.3动态渲染数据
          $("#myForm").html(str);
        }
        
      }
    });
    
  }
  // 2文件上传
  $("#myForm").on("change","#logo",function(){
    console.log('aa');
    
    // 2.1准备数据
    var data=new FormData();
    data.append("logo",this.files[0]);
    // 2.2发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/setting/settingLogoInt.php",
      data:data,
      contentType:false,
      processData:false,
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 把图片渲染到页面上
          $("#iconImg").attr("src",res.src);
          // 把图片路径存储到隐藏域中
          $("#site_logo").val(res.src);
          
        }
        
      }
    });

  })

  // 3保存
  $("#myForm").on("click","#btnSave",function () {
    // 3.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/setting/settingSaveInt.php",
      data:$("#myForm").serialize(),
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 重新渲染页面数据
          render();
        }
        
      }

    });
    
    return false;//阻止默认事件
    
  })
  
</script>

</body>
</html>
