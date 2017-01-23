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
        <h3 class="form-signin-heading"><?php echo (L("register_new_account")); ?></h3>
        <input type="text" class="input-block-level" name="username" placeholder="<?php echo (L("username_description")); ?>">
        <input type="password" class="input-block-level" name="password"  placeholder="<?php echo (L("password")); ?>">
        <input type="password" class="input-block-level" name="confirm_password"  placeholder="<?php echo (L("password_again")); ?>">
        <?php if($CloseVerify != 1): ?><input type="text" class="input-block-level" name="v_code"  placeholder="<?php echo (L("verification_code")); ?>">
        <div class="control-group">
          <div class="controls">
            <img src="#" id="v_code_img">
          </div>
        </div><?php endif; ?>
        <button class="btn btn-large btn-primary" type="submit"><?php echo (L("register")); ?></button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?s=/home/user/login"><?php echo (L("had_a_account")); ?></a>
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
 $(function(){
    $("#v_code_img").attr("src" , DocConfig.pubile+'/verifyCode.php');
    $("#v_code_img").click(function(){
      var v_code_img = $("#v_code_img").attr("src");
      $("#v_code_img").attr('src' ,v_code_img+'?'+Date.parse(new Date()) );
    }); 
 });

</script>