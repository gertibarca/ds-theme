jQuery(document).ready(function($) {
    console.log('custom.js loaded'); // Check browser console
    $('h2').on('click', function() {
        alert('You clicked the heading!');
    });
});
