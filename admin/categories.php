<?php 
 // 1引入外部文件
 require "../dbFunction.php";
 // 2检查用户登录状态
  checkLogin();
 // 3获取用户登录信息
  $current_user=$_SESSION["userInfo"];

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <?php include "./inc/css.php"?>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
   <?php include "./inc/navBar.php"?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="myForm">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
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
                <th>名称</th>
                <th>Slug</th>
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
  <?php $current_page="categories";?>
  <?php include "./inc/aside.php"?>

  <?php include "./inc/js.php"?>
  <script>NProgress.done()</script>

  <!-- 此模板是用于右侧分类目录的动态渲染 -->
  <script id="categoryItems" type="text/template">
    {{each data as val key}}
      <tr>
          <td class="text-center"><input type="checkbox" class="chk" data-id="{{val.id}}"></td>
          <td>{{val.name}}</td>
          <td>{{val.slug}}</td>
          <td class="text-center">
            <a href="javascript:;" class="btn btn-info btn-xs btnEdit" data-id="{{val.id}}">编辑</a>
            <a href="javascript:;" class="btn btn-danger btn-xs btnDel" data-id="{{val.id}}">删除</a>
          </td>
      </tr>
    {{/each}}
  </script>
  <!-- 此模板用于左侧分类目录的编辑的模板 -->
  <script id="categoryEdit" type="text/template">
    <h2>编辑分类目录</h2>
    <!-- 设置隐藏域 存储id  后台根据id进行更新 -->
    <input type="hidden" name="id" value={{id}}>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称" value={{name}}>
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value={{slug}}>
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" id="btnUpdate">更新</button>
            </div>
  
  
  </script>
  <!-- 此模板用于页面更新后恢复添加的页面 -->
  <script id="categoryAdd" type="text/template">
    <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit" id="btnAdd">添加</button>
            </div>
  </script>
  <script>
  // 1页面右侧分类目录的动态渲染 向服务器发送请求 请求分类目录的数据
  render();
  function render() {
    // 1.1发送ajax请求
    $.ajax({
      type:"get",//请求的方式
      url:"./int/category/categorySelectInt.php",//请求的地址
      dataType:"json",//数据响应回来要解析成的类型
      success:function (res) {//数据响应成功后调用的函数
        if(res&&res.code==1){
          // 1.2调用模板的方法
          var str = template("categoryItems",res);
          // 1.3动态渲染数据
          $("tbody").html(str);
        }
      }
    });
    
  }
  // 2页面上分类目录的添加-------用事件委派注册事件
  $("#myForm").on("click","#btnAdd",function () {
    // 2.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/category/categoryInsertInt.php",
      data:$("#myForm").serialize(),//表单序列话 用于获取表单内所有包含name属性的值 返回的是字符串
      dataType:"json",//数据回来要解析成的格式
      success:function (res) {//数据响应成功后调用
        if(res&&res.code==1){
          // 调用函数 重新渲染右侧分类目录的数据
          render();
          // 清空用户输入的内容
          $("input[name]").val("");
        }
      }
    });
    return false;//阻止默认事件
    
    
  });

  //3页面上分类目录的删除
  // 模板的上的代码等同于动态创建元素 不能直接为其注册事件 只能通过其父亲的事件委派为其注册事件
  $("tbody").on("click",".btnDel",function () {
    // 3.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/category/categoryDeleteInt.php",
      data:{
        id:$(this).attr("data-id")//把id值发送给服务器  根据id删除数据
      },
      dataType:"json",//数据回来要解析成的格式
      success:function (res) {//数据响应成功后调用
        if(res&&res.code==1){
          // 调用函数  重新动态渲染右侧分类目录的数据
          render();
        }
        
      }
    });
    
    
  });
  // 4页面上分类目录的编辑
  $("tbody").on("click",".btnEdit",function () {
    // 4.1发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/category/categoryEditInt.php",
      data:{
        id:$(this).attr("data-id")//把id传入服务器  跟id编辑
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 4.2调用模板方法
          var str=template("categoryEdit",res.data[0]);
          // 4.3动态渲染数据
          $("#myForm").html(str);
        }
        
      }
    });
    
    
  });
  // 5页面上分类目录的更新
  $("#myForm").on("click","#btnUpdate",function () {
    // 5.1发送ajax请求
    $.ajax({
      type:"post",
      url:"./int/category/categoryUpdateInt.php",
      data:$("#myForm").serialize(),//表单序列化 用于获取表单内容所有包含name属性的值 返回的是一个字符串
      dataType:"json",//数据回来要解析成的格式
      success:function (res) {//数据响应成功后调用
        if(res&&res.code==1){
          // 调用函数  重新渲染右侧分类目录的数据
          render();
          // 更新完成之后 恢复添加的页面
          var str=template("categoryAdd",{})
           // 4.3动态渲染数据
          $("#myForm").html(str);
        }
        
      }
    });
    return false;//阻止默认事件
    
  });

  // 6页面上的批量删除
  // 6.1给全选按钮注册事件
  $("#chkToggle").on("click",function () {
    // 6.2获取全选按钮的状态
    var flag=$(this).prop("checked");
    // 6.3把全选按钮的状态赋值给下面的每个选框
    $(".chk").prop("checked",flag);
    // 6.4判断如果是全选选中 显示批量删除
    if(flag){
      $("#delAll").show();
    }else {
      $("#delAll").hide();
    }
  });
  // 7给每个小选框注册事件
  $("tbody").on("click",".chk",function () {
    // 7.2获取选中按钮的个数
    var chkCount=$(".chk:checked").size();
    // 7.3判断  如果是选中的按钮大于2 就算批量删除
    if(chkCount>=2){
       $("#delAll").show();
    }else {
      $("#delAll").hide();
    }
    // 7.4获取所有input
    var inputCount=$(".chk").size();
    // 7.5判断 如果是有一个未选中 全选就不勾选
    if(chkCount==inputCount){
      $("#chkToggle").prop("checked",true);
    }else {
      $("#chkToggle").prop("checked",false);
    }
  });
  // 8.1给批量删除按钮注册事件
  $("#delAll").on("click",function () {
    // 8.2设置一个数组 存储选中按钮的id
    var ids=[];
    // 8.3获取选择按钮id值 并存储到数组中----先遍历!!!!!!!!!!!选中按钮的ID！！！
    $(".chk:checked").each(function (index,ele) {
      ids.push($(ele).attr("data-id"));
    })
    // 8.4发送ajax请求
    $.ajax({
      type:"get",
      url:"./int/category/categoryDelMoreInt.php",
      data:{
        ids:ids
      },
      dataType:"json",
      success:function (res) {
        if(res&&res.code==1){
          // 调用函数  重新渲染数据
          render();
          $("#delAll").hide();
        } 
      }
    });
  });

</script>
</body>
</html>


