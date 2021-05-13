// ajaxLoop.js
jQuery(function($){
    var page = 1;
	var posts =2;
    var loading = true;
    //var $window = $(window);


    var $content = $("body.home.blog #content");
    var load_posts = function(){
            $.ajax({
                type       : "GET",
                data       : {numPosts : posts, pageNumber: page},
                dataType   : "html",
                url        : "http://localhost:8080//blog/wp-content/themes/spots/loopHandler.php",
                beforeSend : function(){
                    if(page != 1){
                        $content.append('<div id="temp_load" class="load"></div>');
					
                    }
                },
                success    : function(data){
                    $data = $(data);
                    if($data.length){
                        $data.hide();
                        $content.append($data);
                        $data.fadeIn(500, function(){
                            $("#temp_load").remove();
                            loading = false;
                        });

                    } else {
                        $("#temp_load").remove();
                    }
                },
                error     : function(jqXHR, textStatus, errorThrown) {
                    $("#temp_load").remove();
                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
        });
    }

    $("#more").click(function() {
        
        if(!loading ) {
                loading = true;
                page++;
                load_posts();
        }
    });
    load_posts();
});