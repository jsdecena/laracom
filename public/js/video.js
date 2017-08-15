if($(".bg-container-youtube").is(':visible')){
    if($(window).width() >= 1200){
        $('.player').mb_YTPlayer();
    }
    else{
        $(".bg-container-youtube").backstretch([
            "img/slideshow/sample.jpg",		//-- CHANGE WITH YOUR IMAGE URL
            "img/slideshow/sample2.jpg"
            ],{
            duration:6000,
            fade:'normal'
        });
    }
}