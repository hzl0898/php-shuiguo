<?php
header("Content-type: text/html; charset=utf-8");
require_once("connect.php");
require_once("functions.php");
$uname=$_POST["uname"];
if($uname==""){
   js_back("用户名不能为空！");
}
$check_sql="select uid from shop_user where username = '$uname'";
$check_result = mysqli_query($conn,$check_sql);
$check_row = mysqli_fetch_assoc($conn,$check_result);
if($check_row['uid']){
	js_back("用户名已被注册，请修改用户名！");
}
if(strlen($uname)<3||strlen($uname)>16){
   js_back("用户名长度必须为3~16!");
}
$upwd=$_POST["upwd"];
if($upwd==""){
   js_back("密码不能为空！");
}
if(strlen($upwd)<6){
   js_back("密码长度不能小于6位！");
}
if(strlen($upwd)>16){
   js_back("密码长度不能大于16位！");
}
$Rupwd=$_POST["Rupwd"];
if($upwd!=$Rupwd){
   js_back("密码不一致，请重新输入！");
}
if(!(preg_match("/[A-z]/",$upwd)&& preg_match("/\d/",$upwd))){
	  js_back("密码不是数字和字母组合！");
}
$insertsql="insert into shop_user(username,password)values('$uname',SHA1('$upwd'))";
$result=mysqli_query($conn,$insertsql);
if($result){
    $uid = mysqli_insert_id();
    $select_sql = "select username from shop_user where uid = $uid";
    $select_result = mysqli_query($conn,$select_sql);
    $select_row = mysqli_fetch_assoc($conn,$select_result);
    setcookie("ckuname",$select_row['uname']);
    setcookie("ckuid",$uid);
    js_go("注册成功！","index.php");
}
else{
	js_back("注册失败！");
}
?>