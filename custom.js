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
    jQuery(document).ready(function($){

    $('.watch-trailer').click(function(e){
        e.preventDefault();

        let url = $(this).data('trailer');

        if(!url){
            alert('No trailer added');
            return;
        }

        let embed = url.replace("watch?v=", "embed/");

        let popup = `
        <div class="trailer-popup">
            <div class="trailer-content">
                <span class="close-popup">✖</span>
                <iframe src="${embed}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        `;

        $('body').append(popup);
    });

    // close
    $(document).on('click', '.close-popup', function(){
        $('.trailer-popup').remove();
    });
    jQuery(document).ready(function($){

    $('.add-to-list').click(function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let title = $(this).data('title');

        let list = JSON.parse(localStorage.getItem('favorites')) || [];

        let exists = list.find(item => item.id == id);

        if(exists){
            alert('Already in your list');
            return;
        }

        list.push({id:id, title:title});
        localStorage.setItem('favorites', JSON.stringify(list));

        alert('Added to your list ❤️');
    });

});

});

});