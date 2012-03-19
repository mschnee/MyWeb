(function(){
    var History = window.History;
    bindLinkHandler($('a'));
    
    var currentPanelData={}
    
    /****
     * Handlers for different panel types
     */
    var _pagedPanelHandler = function(ret) {
        // if loading a new page
        if(! currentPanelData.type || currentPanelData.type!="PagedPanel") {
            currentPanelData = { type: "PagedPanel", page: 0 }
            
            var currentC = $("div#content>div");
            var newC = $("<div></div>").width("900px");
            newC.append(ret.pager + ret.html);
            segmentTransitions.defaultSlide(currentC,newC);
        } else {
            $("div.PagedPanelPager").replaceWith(ret.pager);
            segmentTransitions.fade($("div.PagedPanelPage"),$(ret.html));
        }
        
        $("div.PagedPanelPager a").unbind('click').click(function(e){
            History.pushState({href:$(this).attr('href')},null, $(this).attr('href'));
            return false;           
            
        }); 
        
    }
    
    var segmentHandlers = {
        default:  function(ret) {currentPanelData={};bindLinkHandler($("div#content>div a"));},
        PagedPanel: _pagedPanelHandler,
    };
    var segmentTransitions = {
        defaultSlide: function(oldElement,newElement) {
            newElement.css({opacity:0,left:500});
            oldElement.after(newElement);
            
            
            oldElement.animate({
                opacity: 0,
                left: "-=100"
            },500, function(){
                oldElement.remove();
                
            }
            );
            newElement.animate({
                opacity: 1,
                left: "-=500"
                },500
            );
        },
        reverseSlide: function(oldElement,newElement) {
            newElement.css({opacity:0,left:-100});
            oldElement.after(newElement);
            
            
            oldElement.animate({
                opacity: 0,
                left: "+=500"
            },500, function(){
                oldElement.remove();
                
            }
            );
            newElement.animate({
                opacity: 1,
                left: "+=100"
            },500
            );
        },
        fade: function(oldElement,newElement) {
            newElement.css({opacity:0});
            oldElement.after(newElement);
            oldElement.animate(
                {opacity: 0},200, function(){
                oldElement.remove();
                newElement.animate({opacity:1},200);
                
            });
            
        }
    }
    
    $(window).bind("statechange",function(event){
        var state = History.getState();
        
        if(!state.data.href)
            state.data.href = window.location.pathname;
        // not working yet
        // var anim = (state === History.getStateByIndex(History.savedStates.length-1))?"defaultSlide":"reverseSlide";
        var anim="defaultSlide";
        
        $.ajax({
            url: "/Ajax"+state.data.href,
            data: {},
            success: function(ret){
                /* handle ajax response here instead */
                if(ret.success) {
                    if(ret.segmentType && segmentHandlers[ret.segmentType]) {
                        if( typeof(segmentHandlers[ret.segmentType])==='function')
                            segmentHandlers[ret.segmentType].call(this,ret,state.data.href.match()[1]);
                    } else {
                        currentPanelData={};
                        bindLinkHandler($("div#content>div a"));
                        var currentC = $("div#content>div");
                        var newC = $("<div></div>").width("900px");
                        newC.append(ret.html);
                        if(segmentTransitions[anim])
                            segmentTransitions[anim].call(null,currentC,newC);
                    }
                    
                    
                    
                } else {
                    console.log("error");
                }
            },
            dataType: "json"
        });
        return false;
        
    });

    function bindLinkHandler(selector) {
        selector.click(function(){
            var href = $(this).attr("href");
            if(href.match(/^\//)) {
                History.pushState({href:href},null,href);
                return false;
            } else {
                return t;
            }
        }
            
        );
    }
    
    // invoke the state change to get the correct ajax panel.
    $(window).trigger("statechange");

})();
