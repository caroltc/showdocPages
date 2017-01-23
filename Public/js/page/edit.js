var editormd;
var template_list ;
var json_table_data='|'+lang["params"]+'|'+lang["type"]+'|'+lang["description"]+'|\n'+
		'|:-------|:-------|:-------|\n';

$(function() {

  //给按钮文字加上颜色，点击后则去掉颜色
  if (is_showdoc_online()) {
    set_text_color( "runapi" , "red");
  };
  
  /*加载目录*/
  secondCatList();

  function secondCatList() {
    var default_second_cat_id = $("#default_second_cat_id").val();
    var item_id = $("#item_id").val();
    $.post(
      "?s=home/catalog/secondCatList",
      {
        "item_id": item_id,
      },
      function(data) {
        $("#cat_id").html('<OPTION value="0">'+lang["none"]+'</OPTION>');
        if (data.error_code == 0) {
          json = data.data;
          console.log(json);
          for (var i = 0; i < json.length; i++) {
            cat_html = '<OPTION value="' + json[i].cat_id + '" ';
            if (default_second_cat_id == json[i].cat_id) {
              cat_html += ' selected ';
            }

            cat_html += ' ">' + json[i].cat_name + '</OPTION>';
            $("#cat_id").append(cat_html);
          };
          getChildCatList();
        };

      },
      "json"

    );
  }

  function getChildCatList() {
    var cat_id = $("#cat_id").val();
    var default_child_cat_id = $("#default_child_cat_id").val();
    $.post(
      "?s=home/catalog/childCatList", {
        "cat_id": cat_id
      },
      function(data) {
        $("#parent_cat_id").html('<OPTION value="0">'+lang["none"]+'</OPTION>');
        if (data.error_code == 0) {
          json = data.data;
          console.log(json);
          for (var i = 0; i < json.length; i++) {
            cat_html = '<OPTION value="' + json[i].cat_id + '" ';
            if (default_child_cat_id == json[i].cat_id) {
              cat_html += ' selected ';
            }

            cat_html += ' ">' + json[i].cat_name + '</OPTION>';
            $("#parent_cat_id").append(cat_html);
          };
        }else{
        }

      },
      "json"

    );
  }
  //监听是否选择了目录。如果选择了，则跟后台判断是否还子目录
  $("#cat_id").change(function(){
    getChildCatList();
  });

  var keyMap = {
    // 保存
    "Ctrl-S": function() {
      $("#save").click();
    }
  };
  initEditorOutsideKeys();

  function initEditorOutsideKeys() {
    if (!editormd) return;
    var $doc = $(document);
    $.each(keyMap, function(key, fn) {
      $doc.on('keydown', null, key.replace('-', '+'), function(e) {
        e.preventDefault();
        fn();
      });
    });
  }
  // 如果是新增页面，则光标为标题文本框
  if (location.href.indexOf('type=new') !== -1) {
    setTimeout(function() {
      $('#page_title').focus();
    }, 1000);
  }

  /*初始化编辑器*/
  editormd = editormd("editormd", {
    width: "90%",
    height: 1000,
    syncScrolling: "single",
    path: DocConfig.pubile + "/editor.md/lib/",
    placeholder: lang["editormd_placeholder"] ,
    imageUpload: true,
    imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp", "JPG", "JPEG", "GIF", "PNG", "BMP", "WEBP"],
    imageUploadURL: "?s=home/page/uploadImg",
    onload: function() {
      this.addKeyMap(keyMap);
    }
  });

  /*插入API接口模板*/
  $("#api-doc").click(function() {
    var tmpl = $("#api-doc-templ").html();
    editormd.insertValue(tmpl);
  });
  /*插入数据字典模板*/
  $("#database-doc").click(function() {
    var tmpl = $("#database-doc-templ").html();
    editormd.insertValue(tmpl);
  });
  
   /*JSON转参数表格*/
  $("#jsons").click(function() {
	  
   $("#json-templ").show();
	
  });

   /*JSON格式美化*/
  $("#beautify-json").click(function() {
    
   $("#beautify-json-dialog").show();
  
  });
  
  

		
	$("#json-templ .editormd-enter-btn").click(function(){
		
		
		var datas=$("#json-templ .jsons").val();
		
		try{
			Change($.parseJSON(datas));   
		}
		catch(e){
			alert(lang["json_fail"]  + e);
		}
		
		//datas=processJSONImport(datas);
		//alert(datas);
		/*var datas='|键|值|类型|空|注释|\n'+
		'|:-------|:-------|:-------|:-------|:-------|\n'+
		'|uid|int(10)|否|||\n'+
		'|username|varchar(20)|否||用户名|';*/
		
		//alert(json_table_data);return;
		
		
		
		editormd.insertValue(json_table_data);
		
		json_table_data='|'+lang["filed"]+'|'+lang["type"]+'|'+lang["description"]+'|\n'+
		'|:-------|:-------|:-------|\n';
		
		
		$("#json-templ .jsons").val("");
		$("#json-templ").hide();
		
	});
	

$("#beautify-json-dialog .editormd-enter-btn").click(function(){
  var data = $("#beautify-json-dialog .jsons").val();
      try{
          var text="\n ``` \n \{ \n"+dump(JSON.parse(data))+" \} \n\n ```\n\n";//整体加个大括号
          //$("#beautify-json-dialog .jsons").val(text);
          $("#beautify-json-dialog .jsons").val("");
          editormd.insertValue(text);
      }catch(e){
          //非json数据直接显示
          //$("#beautify-json-dialog .jsons").val(data);
          $("#beautify-json-dialog .jsons").val("");
          editormd.insertValue(data);
      }
    $("#beautify-json-dialog").hide();

});
//{"dgfgdfg":"gdfgdfg"}
  
//格式化json数据
function dump(arr,level) { 
     var dumped_text = ""; 
     if(!level) level = 0; 
     
     //The padding given at the beginning of the line. 
     var level_padding = ""; 
     for(var j=0;j<level+1;j++) level_padding += "     "; 
     if(typeof(arr) == 'object') { //Array/Hashes/Objects 
         var i=0;
         for(var item in arr) { 
             var value = arr[item]; 
             if(typeof(value) == 'object') { //If it is an array, 
                 dumped_text += level_padding + "\"" + item + "\" : \{ \n"; 
                 dumped_text += dump(value,level+1); 
                 dumped_text +=level_padding +"\}";
             } else { 
                dumped_text += level_padding + "\"" + item + "\" : \"" + value + "\""; 
             } 
             if(i<Object.getOwnPropertyNames(arr).length-1){
                dumped_text+=", \n";
             }else{
                dumped_text+=" \n";
             }
             i++;
         } 
     } else { //Stings/Chars/Numbers etc. 
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")"; 
     } 
     return dumped_text; 
}

  /*保存*/
  var saving = false;
  $("#save").click(function() {
    if (saving) return false;
    var page_id = $("#page_id").val();
    var item_id = $("#item_id").val();
    var page_title = $("#page_title").val();
    var page_comments = $("#page_comments").val();
    var page_content = $("#page_content").val();
    var item_id = $("#item_id").val();
    var s_number = $("#s_number").val();
    var cat_id = $("#cat_id").val();
    var parent_cat_id = $("#parent_cat_id").val();
    if (parent_cat_id > 0 ) {
      cat_id = parent_cat_id ;
    };
    saving = true;
    $.post(
      "?s=home/page/save", {
        "page_id": page_id,
        "cat_id": cat_id,
        "s_number": s_number,
        "page_content": page_content,
        "page_title": page_title,
        "page_comments": page_comments,
        "item_id": item_id
      },
      function(data) {
        if (data.error_code == 0) {
          $.bootstrapGrowl(lang["save_success"]);
          window.location.href = "?s=home/item/show&page_id=" + data.data.page_id + "&item_id=" + item_id;
        } else {
          $.bootstrapGrowl(lang["save_fail"]);

        }
        saving = false;
      },
      'json'
    )
  });



	$(".editormd-preview-container").bind('DOMNodeInserted', function(e){
		
		$(".editormd-preview-container table thead tr").css({"background-color":"#08c","color":"#fff"});
    $(".editormd-preview-container table tr").eq(0).css({"background-color":"#08c","color":"#fff"});
		$(".editormd-preview-container table tr").each(function(){
			if($(this).find("td").eq(1).html()=="object")
			{
				$(this).css({"background-color":"#99CC99","color":"#000"});
			}
			
			});
	});

});


function closeDiv(target)
{
	$(target).hide();
}

function Change(data)
{
	var level_str="- ";
	if(arguments.length>1)
	{
		var level;
		arguments[1]>0?level=arguments[1]:level=1;
		for(var i=0;i<level;i++)
		{
			level_str+="- ";
		}
	}
	
	for(var key in data)
	{
		var value = data[key];
		var type = typeof(value);
		if(type == "object")
		{
			json_table_data+='| '+level_str+key+' |'+type+'  | '+lang["none"]+' |\n';
			if(value instanceof Array)
			{
				var j=level+1;
				Change(value[0],j);
				continue;
			}
			//else
			//{
				Change(value,level);
			//}
			
		}
		else
		{
			json_table_data+='| '+key+' | '+type+'| '+lang["none"]+' |\n';
		}
	}
}

//{"Result":[{"name":"test1","list":{"pros":"prosfsf","ppps":{"images":[{"22":"22"}]}}}]}

$("#save-to-templ").click(function(){
  var template_title =prompt(lang["save_templ_title"],"");
  if (template_title!=null && template_title!="")
    {
        var template_content = $("#page_content").val();
        $.post(
            "?s=home/template/save",
            {"template_title":template_title,"template_content":template_content},
            function(data){
                if (data.error_code == 0) {
                  alert(lang["saved_templ_msg1"]+template_title+lang["saved_templ_msg2"]);
                } else {
                  $.bootstrapGrowl(lang["save_fail"]);

                }
           },
            "json"
            );
    }
    $("#save-btn-group").removeClass("open");
    return false;
  });


$("#more-templ").click(function(){
        $.post(
            "?s=home/template/getList",
            {},
            function(data){
                if (data.error_code == 0) {
                    var html = '<TR><td>'+lang["save_time"]+'</td><td>'+lang["templ_title"]+'</td><td>'+lang["operation"]+'</td></TR>';
                    template_list = data.data;
                    json = data.data;
                    for (var i = 0; i < json.length; i++) {
                        html += '<TR><td>'+json[i]['addtime']+'</td>';
                        html += '<td>'+json[i]['template_title']+'</td>';
                        html += '<td><a href="javascript:use_template('+json[i]['id']+')">'+lang["use_this_template"]+'</a> | <a href="javascript:delete_template('+json[i]['id']+')">'+lang["delete_this_template"]+'</a></td>';
                        html +='</TR>';
                    };
                    $("#templ-table").html(html);
                } else {
                  //$.bootstrapGrowl("获取模板列表失败");
                  $("#templ-table").html(lang["no_templ_msg"]);

                }
                $("#more-templ-modal").modal();
           },
            "json"
            );
    
});

//使用模板
function use_template(id){
    for (var i = 0; i < template_list.length; i++) {
        if (id > 0 && id == template_list[i]['id']) {
            editormd.insertValue(template_list[i]['template_content']);
            $("#more-templ-modal").modal("hide");
        };
        
    };
}

//删除模板
function delete_template(id){
    $.post(
        "?s=home/template/delete",
        {"id":id},
        function(data){
            if (data.error_code == 0) {
                $("#more-templ").click();
            } else {
              $.bootstrapGrowl(lang["save_fail"]);
            }
       },
        "json"
        );
}

$("#add-page-comments").click(function(){
  var page_comments =prompt(lang["add_page_comments_msg"],"");
  if (page_comments!=null && page_comments!="")
    {
        $("#page_comments").val(page_comments);
        $("#save").click();
    }
    $("#save-btn-group").removeClass("open");
    return false;
});