(function(){
    var History = window.History;
    
    if(!History.enabled) {
        console.log(":(");
        return;
    }
    
    $("a").click(function(){
        var href = $(this).attr("href");
        if(href.match(/^\//)) {
            History.pushState({adding:true,href:href},null,href);
            return false;
        } else {
            return true;
        }
    });
    

    History.Adapter.bind(window,"statechange",function(event){
        var state = History.getState();
        
        if(state.data.adding===true) {
            //History.replaceState({adding:false,href:state.data.href,change:false});
            state.data.adding=false;
            advanceLink(state.data.href);
        } else if(state.data.adding===false) {
            retreatLink(state.data.href);
        }
        
    });

    
    
    /**
      * 
      */
    function advanceLink(href) {
        console.log(href);
        $.ajax({
            url: "/Ajax"+href,
            data: {},
            success: advanceAjaxLink,
            dataType: "json"
        });
    }
    
    function retreatLink(href) {
        $.ajax({
            url: "/Ajax"+href,
            data: {},
            success: retreatAjaxLink,
            dataType: "json"
        });
    }
    
    /**
     * Advance the "page".
     */
    function advanceAjaxLink(data,textStatus,jqXHR) {
        if(data.success) {
            var currentC = $("div#content>div");
            var newC = $("<div></div>");
            $("div#content").append(newC);newC.append(data.html).css({opacity:0,left:100});
            currentC.animate({
                opacity: 0,
                left: "-=100"
                },500, function(){
                    currentC.remove();
                    
                }
            );
            newC.animate({
                opacity: 1,
                left: "-=100"
                },500
            );
        }
    }
    
    function retreatAjaxLink(data,textStatus,jqXHR) {
        if(data.success) {
            var currentC = $("div#content>div");
            var newC = $("<div></div>");
            $("div#content").append(newC);newC.append(data.html).css({opacity:0,left:-100});
            currentC.animate({
                opacity: 0,
                left: "+=100"
                },500, function(){
                    currentC.remove();
                    
                }
            );
            newC.animate({
                opacity: 1,
                left: "+=100"
                },500
            );
        }
    }
    

})();
