
    /*** Table permission ***/

    $(document).ready(function(){
        carregarTabelaPermission(0);

        $("#successDelete").hide(); // hide message success delete

    });

    // Pagination
    $(document).on('click', '.paginationPermission a', function(e) {
        e.preventDefault();
        var pagina = $(this).attr('href').split('page=')[1];
        carregarTabelaPermission(pagina);
    });

    $("#search").keyup(function() {
        carregarTabelaPermission(0);
      });

    // Search permission
    function carregarTabelaPermission(pagina) {

         // Gif
         $('.permission_data').html('<div class="d-flex justify-content-center mt-3 loading">Loading&#8230;</div>');

        var search = $("#search").val();
        
        $.ajax({
        url: "/permission/list" + "?page=" + pagina,
        method: 'GET',
        data: {search: search} 
            }).done(function(data){
            //console.log(data);
            
            setTimeout(function() { 
                if(data) {
                    $('.permission_data').html(data);
                }else {
                    $('.permission_data').html('<div class="">Error</div>');
                }
            }, 1000);
        });
    }

    // Show Permission
    $(document).on('click', '.edit', function(e) {

        $("#successEdit").hide(); //hide message
        $(".modalGif").hide();
        $("#gif").show();

        var id = $(this).val();
        //console.log(id);
        $.ajax({
            url: "/permission/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){
                //console.log(data);

                setTimeout(function() { 
                    if(data) {

                        // Gif
                        $("#gif").hide();
                        $(".modalGif").show();
                        
                        $('.id').val(data.id)
                        $('.name').val(data.name)
                    }else {
                        console.log('Error');
                    }
                }, 1000);
            });
    });

    // Edit permission
    $(document).on('click', '.saveEdit', function(e) {
        $(".saveEdit").show();
        var id = $("#id").val();
        var name = $("#name").val();

        $.ajax({
            url: "/permission/edit",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, name: name},
                }).done(function(data){
                console.log(data);
                    
                if(data) {
                    $("#successEdit").show();
                    $(".saveEdit").hide();

                    carregarTabelaPermission(0);
                }
            }).fail(function(error) {

                // Message errors
                //console.log("error");
                //console.log(error.responseJSON.errors);

                $.each(error.responseJSON.errors, function( k, v ) {
                    $('.msgErrorEdit').append("<div class='alert alert-danger errorMsgEdit' role='alert'>" + v + "</div>");
                  });

                  $( ".errorMsgEdit" ).fadeIn(300).delay(3000).fadeOut(300);

                  setTimeout(function() { 
                    $( ".errorMsgEdit" ).remove();
                }, 4000);
              }); 
    });

    // close modal edit
    $(document).on('click', '.closeEdit', function(e) {
        $(".saveEdit").show();
    });


    // Return Form permission
    $(document).on('click', '.createPermission', function(e) {
        $("#successCreate").hide(); //hide message
        $(".modalFormGif").hide();
        $("#gifForm").show();

        $.ajax({
            url: "/permission/form",
            method: 'GET',
            data: '' 
                }).done(function(data){
                //console.log(data);
                setTimeout(function() { 
                    if(data) {

                         // Gif
                         $("#gifForm").hide();
                        
                         $(".modalFormGif").show();

                        $('.form-permission').html(data);
                    }else {
                        $('.form-permission').html('<div class="">Error</div>');
                    }
                }, 500);
            });
    });

    // Create permission
    $(document).on('click', '.saveForm', function(e) {
        $(".saveForm").show();

        var name = $("#name").val();

        $.ajax({
            url: "/permission/create",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {name: name},
                }).done(function(data){
                console.log(data);
                    
                if(data) {
                    $("#successCreate").show();
                    $(".saveForm").hide();

                    carregarTabelaPermission(0);
                }
            })
            .fail(function(error) {

                $.each(error.responseJSON.errors, function( k, v ) {
                    $('.msgError').append("<div class='alert alert-danger errorMsg' role='alert'>" + v + "</div>");
                  });

                  $( ".errorMsg" ).fadeIn(300).delay(3000).fadeOut(300);

                  setTimeout(function() { 
                    $( ".errorMsg" ).remove();
                }, 4000);
              });
    });

     // close modal create
     $(document).on('click', '.closeCreate', function(e) {
        $(".saveForm").show();
    });
       

    // Delete permission
    $(document).on('click', '.delete', function(e) {

        var id = $(this).val();0
        $.ajax({
            url: "/permission/delete/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){

                    console.log(data);

                    if(data) {
                        $("#successDelete").show();
                        carregarTabelaPermission(0);
                        
                        setTimeout(function() { 
                            $("#successDelete").hide();
                        }, 3000);

                    }else {
                        console.log('Error');
                    }
            });
    });
       
   