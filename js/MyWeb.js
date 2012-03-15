(function(){
    var History = window.History;
    if(!History.enabled) {
        console.log(":(");
        return;
    }
    $("a").click(function(){
        var href = $(this).attr("href");
        History.pushState(null,null,href);
        if(href.match(/^\//)) {
            handleLink(href);
            return false;
        } else {
            return true;
        }
    });
    
    /**
      * 
      */
    function handleLink(href) {
        $.ajax({
            url: "/Ajax"+href,
            data: {},
            success: handleAjaxLink,
            dataType: "json"
        });
    }
    
    /**
     * Advance the "page".
     */
    function handleAjaxLink(data,textStatus,jqXHR) {
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
})();
