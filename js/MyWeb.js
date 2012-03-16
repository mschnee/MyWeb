(function(){
    var History = window.History;
    
    if(!History.enabled) {
        console.log(":(");
        return;
    }
    
    bindLinkHandler($('a'));
    

    History.Adapter.bind(window,"statechange",function(event){
        var state = History.getState();
        
        if(state.data.adding===true) {
            //History.replaceState({adding:false,href:state.data.href,change:false});
            state.data.adding=false;
            handleAjaxLink(state.data.href);
        } else if(state.data.adding===false) {
            retreatLink(state.data.href);
        }
        
    });

    function bindLinkHandler(selector) {
        selector.click(function(){
            var href = $(this).attr("href");
            console.log(href);
            if(href.match(/^\//)) {
                History.pushState({adding:true,href:href},null,href);
                return false;
            } else {
                return false;
            }
        }
            
        );
    }
    
    /**
      * 
      */
    function handleAjaxLink(href) {
        $.ajax({
            url: "/Ajax"+href,
            data: {},
            success: handleAjaxReturn,
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
    function handleAjaxReturn(data,textStatus,jqXHR) {
        if(data.success) {
            var currentC = $("div#content>div");
            var newC = $("<div></div>").width("900px");
            newC.append(data.html);
            
            changeAjaxContent(currentC,newC);
        }
        bindLinkHandler($("div#content>div a"));
        /* eventually I'll want special handling for different types of panels
        if(data.ui) {
            if(data.ui=="PagedPanel") {
                bindLinkHandler($("div#content>div a"))
            } else {
                bindLinkHandler($("div#content>div a"))
            }
        }
        */
    }
    
    function changeAjaxContent(oldElement,newContent) {
        
        newContent.css({opacity:0,left:500});
        oldElement.after(newContent);
        
        
        oldElement.animate({
            opacity: 0,
            left: "-=100"
        },500, function(){
            oldElement.remove();
            
            }
        );
        newContent.animate({
            opacity: 1,
            left: "-=500"
            },500
        );
    }    

})();
