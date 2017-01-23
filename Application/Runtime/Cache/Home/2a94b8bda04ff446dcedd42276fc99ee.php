<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<title>ShowDoc</title>
 <link rel="stylesheet" href="/showdoc/Public/bootstrap/css/bootstrap.min.css">

 <link rel="stylesheet" href="/showdoc/Public/css/jquery.fullPage.css">
 <style>
.section { text-align: center; font: 30px "Microsoft Yahei"; color: #fff;}
.header{
 padding-right: 100px;
 padding-top: 30px;
 font-size: 18px; 
 position: fixed;
    right: 0;
    left: 0;
    z-index: 1030;
    margin-bottom: 0;
}
.header a {
    color: white;
    font-size: 12px;
    font-weight: bold;
}
</style>
</head>

<body>
<div class="row header  ">
  <div class="right pull-right">
    <ul class="inline pull-right">
	  <?php if($login_user): ?><li ><a href="<?php echo U('Home/Item/index');?>"><?php echo (L("my_item")); ?></a></li>
	    <?php else: ?>
	    <li ><a href="<?php echo U('Home/User/login');?>"><?php echo (L("index_login_or_register")); ?></a></li><?php endif; ?>
    </ul>
    </div>  
  </div>

<div id="dowebok">
    <div class="section">
        <h1><?php echo (L("section_title1")); ?></h1>
        <br>
        <p><?php echo (L("section_description1")); ?></p>
        <br>
        <p>
            <a class="btn   btn-large " href="<?php echo ($demo_url); ?>" target="_blank"><?php echo (L("demo")); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-large" href="<?php echo ($help_url); ?>" target="_blank" ><?php echo (L("help")); ?>&nbsp;</i></a>
        </p>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title2")); ?></h1>
        <br>
        <p> <?php echo (L("section_description2")); ?></p>
        <br>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title3")); ?></h1>
        <br>
        <p><?php echo (L("section_description3")); ?></p>
        <br>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title4")); ?></h1>
        <br>
        <p><?php echo (L("section_description4")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title5")); ?></h1>
        <br>
        <p><?php echo (L("section_description5")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title6")); ?></h1>
        <br>
        <p><?php echo (L("section_description6")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title7")); ?></h1>
        <br>
        <p><?php echo (L("section_description7")); ?></p>
        <br>
    </div>
    <div class="section">
        <h1></h1>
        <br>
        <p><?php echo (L("section_description8")); ?></p>
        <br>
        <p>
            <a class="btn   btn-large " href="<?php echo U('Home/User/register');?>"><?php echo (L("section_title8")); ?></a>
        </p>
    </div>
</div>
    
	<script src="/showdoc/Public/js/common/jquery.min.js"></script>
    <script src="/showdoc/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/showdoc/Public/js/common/showdoc.js?v=1.1"></script>
    <div style="display:none">
    	<?php echo C("STATS_CODE");?>
    </div>
  </body>
</html> 

<script src="/showdoc/Public/js/jquery.fullPage.min.js"></script>
<script>
$(function(){
    $('#dowebok').fullpage({
        sectionsColor : ['#1bbc9b', '#4BBFC3', '#2C606A', '#f90','#7CBD9D','#A77DC2','#85CE92','#1bbc9b'],
        navigation:true,
    });

    $(window).resize(function(){
        autoScrolling();
    });

    function autoScrolling(){
        var $ww = $(window).width();
        if($ww < 1024){
            $.fn.fullpage.setAutoScrolling(false);
        } else {
            $.fn.fullpage.setAutoScrolling(true);
        }
    }

    autoScrolling();
});
</script>
</body>
</html>