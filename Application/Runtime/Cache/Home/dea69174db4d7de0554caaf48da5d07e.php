<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo ($item["item_name"]); ?> ShowDoc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/showdoc/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/showdoc/Public/css/showdoc.css" rel="stylesheet">
      <script type="text/javascript">
      var DocConfig = {
          host: window.location.origin,
          app: "<?php echo U('/');?>",
          pubile:"/showdoc/Public",
      }

      DocConfig.hostUrl = DocConfig.host + "/" + DocConfig.app;
      </script>
      <script src="/showdoc/Public/js/lang.<?php echo LANG_SET;?>.js?v=21"></script>
  </head>
  <body>
<link rel="stylesheet" href="/showdoc/Public/css/login.css" />

    <div class="container">

      <form class="form-signin" method="post">
        <input type="hidden" id="item_id" name="item_id" value="<?php echo ($item["item_id"]); ?>">
        <!-- <h3 class="form-signin-heading">新建项目</h3> -->
        <input type="text" class="input-block-level"  name="item_name" placeholder="<?php echo (L("item_name")); ?>" autocomplete="off" value="<?php echo ($item["item_name"]); ?>" >
        <input type="text" class="input-block-level"  name="item_description" placeholder="<?php echo (L("item_description")); ?>" autocomplete="off" value="<?php echo ($item["item_description"]); ?>">
<!--         <input type="text" class="input-block-level"  name="item_domain" placeholder="<?php echo (L("item_domain")); ?>" autocomplete="off" value="<?php echo ($item["item_domain"]); ?>" >
 -->        <input style="display:none"><!-- for disable autocomplete on chrome -->
        <input style="display:none"><!-- for disable autocomplete on chrome -->
        <input type="text" onfocus="this.type='password'" id="password" class="input-block-level" name="password" placeholder="<?php echo (L("visit_password_placeholder")); ?>" title="<?php echo (L("visit_password_placeholder")); ?>" autocomplete="off" value="<?php echo ($item["password"]); ?>">
        <button class="btn  btn-primary" type="submit"><?php echo (L("submit")); ?></button>
        <a href="javascript:history.go(-1)" class="btn"><?php echo (L("goback")); ?></a>
      </form>

    </div> <!-- /container -->


    
	<script src="/showdoc/Public/js/common/jquery.min.js"></script>
    <script src="/showdoc/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/showdoc/Public/js/common/showdoc.js?v=1.1"></script>
    <div style="display:none">
    	<?php echo C("STATS_CODE");?>
    </div>
  </body>
</html> 

 <script type="text/javascript">
 var password = $("#password").val();
 if (password) {
    $("#password").val('');
    $("#password").attr('type','password');
    $("#password").val('password');  
 };


 </script>