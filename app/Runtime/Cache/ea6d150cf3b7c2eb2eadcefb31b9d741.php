<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>添加广告图片</title>
</head>
<body>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="LineRightBlue1">
      <table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-left:20px;">
      <tr>
        <td width="88%" height="24">添加广告 【<a href="/Banner/edit">返回广告列表</a>】</td>
        <td width="12%" align="right" class="bt_add"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>

<form action="/Banner/upload" method="post" name="myform" id="myform" enctype="multipart/form-data" onSubmit="return CheckJob()">
<DIV class="PageContent">
<table width="98%" border="0" style="margin:20px;" class="ListCategory">
  <tr>
    <td width="9%">广告标题：</td>
    <td width="91%" height="35"><input name="title" type="text" class="FormSmall" style="width: 320px;"> 
    </td>
  </tr>

  <tr>
    <td>排序ID：</td>
    <td height="35"><input name="sort" type="text" class="FormSmall" style="width: 50px;"> <span style="color:#F00; font-size:12px;">*必填</span></td>
  </tr>
  
  <tr>
    <td>广告链接：</td>
    <td height="35"><input name="link" type="text" class="FormSmall" style="width: 320px;"></td>
  </tr>
  
  <tr>
    <td>广告图片：</td>
    <td height="35"><input type='file'  name='photo'></td>
  </tr>
  
  <tr>
    <td height="55" align="center">
    </td>
    <td height="55" align="left">
    <input type="submit" value="添加" class="bginput">&nbsp;&nbsp;
    <input name="reset" type="reset"  class="bginput" value="重置" />
    </td>
    </tr>
</table>
</DIV>
</form>


</body>
</html>