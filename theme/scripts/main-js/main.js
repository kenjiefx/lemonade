strawberry.create('app',function(){
    setTimeout(function(){
        $("#Loader").fadeOut();
        $("#Loader").html("");
        $("#main").show();
    },2000);
});
