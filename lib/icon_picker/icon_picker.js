/*
 * Bootstrap 3.0 IconPicker - jQuery plugin for Icon selection
 *
 * Copyright (c) 20013 A. K. M. Rezaul Karim<titosust@gmail.com>
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/titosust/Bootstrap-icon-picker
 *
 * Version:  1.0.0
 *
 */
(function($) {
	'use strict';

    $.fn.iconPicker = function( options ) {
        
        var mouseOver=false;
        var per_page=30;
        var $popup=null;
        var icons=new Array();

        var option={
        	per_page:30,
        	icons:icons,
        	onUpdate: null,
        	inline: false,
        };
        var settings = $.extend(option, options);
        var i18n = window.picker_i18nLocale;

        return this.each( function() {

        	var element=this,$parent=$(element).parents('.iconlist');

            if(!settings.buttonOnly && $(this).data("iconPicker")==undefined ){
            	var $this=$(this);
            	var $wraper=$("<div/>",{class:"input-group"});

            	$this.on("click", function(e){
            			e.preventDefault();
 			       		createUI($this);
			       		showList($this,settings.icons);
	            });

            	$(this).data("iconPicker",{attached:true});
            }
        
	        function createUI($element){
	        	$popup=$('<div/>',{class:'iconpopup'});
	        	$popup.html('<div class="ip-control"> \
						          <ul> \
						            <li><a href="javascript:;" class="btn " data-dir="-1"><span class="left-arrow"></span></a></li> \
						            <li><input type="text" class="ip-search" placeholder="'+i18n.search_icon+'" /></li> \
						            <li><a href="javascript:;"  class="btn " data-dir="1"><span class="right-arrow"></span></a></li> \
						          </ul> \
						      </div> \
						     <div class="iconlist"></div> \
					         ');
	        	if(settings.inline){
	        		$this.after($popup);

	        	}
	        	else{
	        		$popup.css({
		        		'top':$element.offset().top+$element.outerHeight()+6,
		        		'left':$element.offset().left
		        	});

	        		$popup.appendTo("body");
	        	}
	        	
	        	
	        	$popup.addClass('dropdown-menu').show();
				$popup.mouseenter(function() {  mouseOver=true;  }).mouseleave(function() { mouseOver=false;  });
	        	var lastVal="", start_index=0,per_page=settings.per_page,end_index=start_index+per_page;

	        	$(".ip-control .btn",$popup).on("click", function(e){
	                e.stopPropagation();
	                var dir=$(this).attr("data-dir");

	                start_index=start_index+per_page*dir;
	                start_index=start_index<0?0:start_index;

	                if(start_index<=settings.icons.length){
	                  $.each($(".iconlist>ul li"),function(i){
	                      if(i>=start_index && i<start_index+per_page){
	                         $(this).show();
	                      }else{
	                        $(this).hide();
	                      }
	                  });
	                }else{
	                	start_index=(Math.ceil(settings.icons.length / per_page) * per_page) - per_page;
	                }
	            });
	        	
	        	$('.ip-control .ip-search',$popup).on("keyup",function(e){
	                if(lastVal!=$(this).val()){
	                    lastVal=$(this).val();
	                    if(lastVal==""){
	                    	
	                    	showList($element,settings.icons);

	                    }else{
	                    	showList($element, $(settings.icons)
							        .map(function(i,v){ 
								            if(v.toLowerCase().indexOf(lastVal.toLowerCase())!=-1){return v} 
								        }).get());
						}
	                    
	                }
	            });  

	        	$(document).mouseup(function (e){
				    if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
				        removeInstance();
				    }
				});

	        }

	        function removeInstance(){
	        	$popup.remove();
	        	
	        }

	        function showList($element,arrLis){
	        	var $ul=$("<ul>");
	        	
	        	for (var i in arrLis) {
	        		$ul.append("<li><a href=\"#\" title="+arrLis[i]+"><span class=\""+arrLis[i]+"\"></span></a></li>");
	        	};

	        	$(".iconlist",$popup).html($ul);
	        	$(".iconlist li a",$popup).on("click", function(e){
	        		e.preventDefault();
	        		var title=$(this).attr("title");

	        		if (typeof (settings.onUpdate) === 'function') {
                        settings.onUpdate.call($element, title);
                    }
                    else{

						$parent.find('.iconlists_field').val(title);
						$parent.find('.input-group-addon').html('<i class="'+title+'"></i>');
	        		
	        		}

	        		removeInstance();
	        	});
	        }

        });
    }

}(jQuery));