<?php
  /**
   * 此页面用于退出登录
   */
  // 开始session
  session_start();
  // 2清除session信息
  unset($_SESSION['userInfo']);
  // 3跳转登录页面
  header("location:../../login.php");
?>