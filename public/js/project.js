
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
        //console.log(data);
        
        setTimeout(function() { 
            if(data) {
                $('.project_data').html(data);
            }else {
                $('.project_data').html('<div class="">Error</div>');
            }
        }, 1000);
    });
}

// Format date
const formatar = (data) => {

    var tempDate = new Date(data);
    var date = tempDate.getDate() + 1;

    const ano = data.getFullYear();
    const mes = (`00${data.getMonth() + 1}`).slice(-2);
    const dia = (`00${date}`).slice(-2);
  
    return `${dia}/${mes}/${ano}`;
  };
  
// Show user
$(document).on('click', '.viewProject', function(e) {

    $(".modalGif").hide();
    $("#gif").show();

    var id = $(this).val();
  
    $.ajax({
        url: "/project/"+ id + "",
        method: 'GET',
        data: "" 
            }).done(function(data){
            // console.log(data);

            setTimeout(function() { 
                if(data) {

                    // Gif
                    $("#gif").hide();

                    $(".modalGif").show();

                    $('#identifier').val(data.identifier);
                    $('.project').html(data.project);
                    $('#name').val(data.FunnelsProjectnames);
                    $('#description').val(data.description);
                    $('#responsible').val(data.responsibleProject);
                    $('#client').val(data.nameClient);
                    $('#projectStage').val(data.nameStepsProject);
                    $('#date').val(formatar(new Date(data.created_at)));
                }else {
                    console.log('Error');
                }
            }, 1000);
        });
});
