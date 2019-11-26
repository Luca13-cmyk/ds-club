$(function(){

    $("#cap").on("change", function(){

        $("#sendcap").click();
        
        });
        
        
        $("#submit_cap_toggle").on("click", function(e){
        
        e.preventDefault();
        
        $("#cap").click();
        
        });
        
        
        
        $("#avatar").on("change", function(){
        
        $("#sendavatar").click();
        
        });
        
        
        $("#submit_avatar_toggle").on("click", function(e){
        
        e.preventDefault();
        
        $("#avatar").click();
        
        });

});