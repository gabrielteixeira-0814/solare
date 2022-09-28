
/*** Table Project ***/

$(document).ready(function(){
    carregarTabelaProject(0);

    $("#successDelete").hide(); // hide message success delete

});

// Pagination
$(document).on('click', '.paginationProject a', function(e) {
    e.preventDefault();
    var pagina = $(this).attr('href').split('page=')[1];
    carregarTabelaProject(pagina);
});

$("#search").keyup(function() {
    carregarTabelaProject(0);
  });

// Search user
function carregarTabelaProject(pagina) {

     // Gif
     $('.project_data').html('<div class="d-flex justify-content-center mt-3 loading">Loading&#8230;</div>');

    var search = $("#search").val();
    
    $.ajax({
    url: "/project/list" + "?page=" + pagina,
    method: 'GET',
    data: {search: search} 
        }).done(function(data){
        console.log(data);
        
        setTimeout(function() { 
            if(data) {
                $('.project_data').html(data);
            }else {
                $('.project_data').html('<div class="">Error</div>');
            }
        }, 1000);
    });
}