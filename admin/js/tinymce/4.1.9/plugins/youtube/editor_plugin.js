(function(){tinymce.PluginManager.requireLangPack("youtube");tinymce.create("tinymce.plugins.YouTubePlugin",{init:function(a,b){var c=this;c.editor=a;var d=a.dom;a.addCommand("mceYouTube",function(){a.windowManager.open({file:b+"/youtube.htm",width:400+parseInt(a.getLang("youtube.delta_width",0)),height:240+parseInt(a.getLang("youtube.delta_height",0)),inline:1},{plugin_url:b,some_custom_arg:"custom arg"})});a.addButton("youtube",{title:"youtube.desc",cmd:"mceYouTube",image:b+"/img/youtube.gif"});a.onNodeChange.add(function(f,e,g){e.setActive("youtube",g.nodeName=="IMG")});a.onVisualAid.add(c._visualAid,c)},_visualAid:function(a,c,b){var d=a.dom;tinymce.each(d.select("div.youtube",c),function(f){d.setStyles(f,{"background-color":"#dcdcdc",padding:"2px"})})},createControl:function(b,a){return null},getInfo:function(){return{longname:"YouTube plugin",author:"Gerits Aurelien",authorurl:"http://www.magix-cms.com",infourl:"http://www.magix-dev.be",version:"1.4"}}});tinymce.PluginManager.add("youtube",tinymce.plugins.YouTubePlugin)})();