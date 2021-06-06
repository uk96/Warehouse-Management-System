$(document).ready(function(){
    $("#minimize-search").click(function(){
        $("#minimize-search-icon").toggleClass("fa-minus fa-plus");
        $("#filter-area").slideToggle();
    });
    $("#reset-button").click(function(){
        $('.filter-input-area').find('.filter-input').val('')
    });
    $("#clear-filter").click(function(){
        $('.filter-input-area').find('.filter-input').val('')
    });
});
