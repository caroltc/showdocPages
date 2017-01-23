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
<style type="text/css">
.single-cat{
  margin: 10px;

}
</style>
 <div id="edit-cat" class="modal hide fade">
  <div class="modal-header">
    <h4><?php echo (L("history_version")); ?></h4>
  </div>
  <table class="table table-hover">
    <TR>
      <td><?php echo (L("update_time")); ?></td>
      <td><?php echo (L("update_by_who")); ?></td>
      <td><?php echo (L("page_comments")); ?></td>
      <td><?php echo (L("operation")); ?></td>
    </TR>
    <?php if($PageHistory): if(is_array($PageHistory)): foreach($PageHistory as $key=>$value): ?><TR>
        <td><?php echo ($value["addtime"]); ?></td>
        <td><?php echo ($value["author_username"]); ?></td>
        <td><?php echo ($value["page_comments"]); ?></td>
        <td> <a href="?s=home/page/diff&page_id=<?php echo ($page_id); ?>&page_history_id=<?php echo ($value["page_history_id"]); ?>" target="_blank"><?php echo (L("overview")); ?></a> | <a href="?s=home/page/edit&page_id=<?php echo ($page_id); ?>&page_history_id=<?php echo ($value["page_history_id"]); ?>"><?php echo (L("recover_to_this_version")); ?></a></td>
      </TR><?php endforeach; endif; endif; ?>
  </table>

    <div class="modal-footer">
      <a href="?s=home/page/edit&page_id=<?php echo ($page_id); ?>" class="btn exist-cat"><?php echo (L("close")); ?></a>
      <a href="?s=home/page/edit&page_id=<?php echo ($page_id); ?>" class="btn btn-primary exist-cat"><?php echo (L("finish")); ?></a>
    </div>
 </div>
<input type="hidden" id="page_id" value="<?php echo ($page_id); ?>">
    
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
   $('#edit-cat').modal();
 })

 </script>