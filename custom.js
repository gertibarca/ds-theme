jQuery(document).ready(function($){

    // Smooth hover animation
    $('.movie-card').hover(function(){
        $(this).css('transform','scale(1.08)');
    }, function(){
        $(this).css('transform','scale(1)');
    });

    // Trailer popup (basic)
    $('.btn-danger').click(function(e){
        e.preventDefault();
        alert('Trailer coming soon 🎬');
    });

});