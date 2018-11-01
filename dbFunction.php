<?php
  /**
   * 此页面用于封装数据库的所有操作语句
   */
  // 引入外部文件 通过魔术常量__DIR__获取文件所在的目录 然后拼接文件名
  require __DIR__."/config.php";
  // 1封装数据库连接
  function conn(){
    // 1.1建立数据库连接
    $conn=mysqli_connect(DB_HOST,DB_ACCOUNT,DB_PASSWORD,DB_NAME);
    // 1.2判断数据库是否连接成功
    if(!$conn){
        die("数据库连接失败...");
    }
    // 1.3把连接对象通过return返回
    return $conn;
  }
  // 2封装数据库查询数据方法
  function dbSelect($sql){
    // 2.1获取连接对象
    $conn=conn();
    // 2.2调用数据库操作方法
    $res=mysqli_query($conn,$sql);
    // 2.3判断数据查询是否成功
    if(!$res){
      $str="数据查询失败...";
    }else if (mysqli_num_rows($res)==0){
      $str="数据库中还未有数据...";
    }else {
      while ($row=mysqli_fetch_assoc($res)) {
        $arr[]=$row;
      }
      // 关闭数据库
      mysqli_close($conn);
      // 返回结果
      return $arr;
    }
     // 关闭数据库
      mysqli_close($conn);
      // 返回结果
      return $str;
  }
  // 3封装数据库数据添加方法
  function dbInsert($table,$arr){
    // 3.1获取连接对象
    $conn=conn();

    // print_r($arr);
    // exit;
    // 获取数组中的键
    $keys=Array_keys($arr);//返回的结果是一个数组
    $keysStr=implode(",",$keys);//把数组中的元素按照,拆分成字符串
    // 获取数组中的值
    $values=Array_values($arr);//返回的结果是一个数组
    // 遍历值数组
    // $valuesStr='';
    // foreach ($values as $key => $val) {
    //   if(is_numeric($val)){
    //    $valuesStr.=$val.",";
    //   }else {
    //    $valuesStr.="'".$val."',";
    //   }
      
    // }
    // $valuesStr=substr($valuesStr,0,-1);
    // echo $valuesStr;
    // exit;
    $valuesStr=implode("','",$values);//把数组中的元素按照','拆分成字符串
    // 设置sql语句
    $sql="insert into $table ($keysStr) values('$valuesStr')";
    // $sql="insert into $table ($keysStr) values($valuesStr)";
    // echo $sql;
    // exit;
    
    // 3.2调用数据库操作方法
    $res=mysqli_query($conn,$sql);
    // 关闭数据库
    mysqli_close($conn);
    return $res;
  }

  //4 封装数据库数据删除方法
  function dbDelete($table,$id){
    // 4.1获取连接对象
    $conn=conn();
    // 设置sql语句
    $sql="delete from $table where id=$id";
    // 4.2调用数据库操作方法
    $res=mysqli_query($conn,$sql);
    // 4.3关闭数据库
    mysqli_close($conn);
    // 4.4把结果返回
    return $res;
  }
  
  // 5封装数据库数据修改方法
  function dbUpdate($table,$arr){
    // 5.1获取连接对象
    $conn=conn();
    // 获取id值
    $id=$arr["id"];
    // 删除id值
    unset($arr["id"]);
    // 遍历数组 得到键=值
    $str="";
    foreach($arr as $key => $val) {
      $str.=$key.'='."'$val'".', ';
    }
    // 去除最后一个,
    $str=substr($str,0,-2);
    // echo $str;
    // exit;
    // 设置sql语句 "update $table set 段1 = 值1,字段 = 值2 where id="
    $sql="update $table set ";
    // 拼接sql语句
    $sql=$sql.$str." where id=$id";
    // echo $sql;
    // exit;
    // 5.2调用数据库操作的方法
    $res=mysqli_query($conn,$sql);
    // 5.3关闭数据库
    mysqli_close($conn);
    // 5.4把结果返回
    return $res;
  }


  // 6封装删除多个数据的方法
  function dbDelMore($table,$arr){
    // 6.1获取连接对象
    $conn=conn();
    // 6.2把数组连接成字符串
    $ids=implode(",",$arr);
    // 6.3设置sql语句
    $sql="delete from $table where id in ($ids)";
    // 6.4调用数据库操作方法
    $res=mysqli_query($conn,$sql);
    // 6.5关闭数据库
    mysqli_close($conn);
    // 6.6返回结果
    return $res;
  }

  // 8封装多个数据修改
  function dbUpdateMore($sql){
    // 8.1获取连接对象
    $conn=conn();
    // 8.2调用数据库操作方法
    $res = mysqli_query($conn, $sql);
    // 8.3关闭数据库
    mysqli_close($conn);
    // 8.4返回结果
    return $res;

  }



  // 7验证用户是否登录
  function checkLogin() {
    // 7.1开始session
    session_start();
    // 7.2验证session
    if(!$_SESSION["userInfo"]){
      // 跳转到登录页面
      header("location:./login.php");
    }
  }
  
  



?>