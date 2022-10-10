
    /*** Table role ***/

    $(document).ready(function(){
        carregarTabelaRole(0);

        $("#successDelete").hide(); // hide message success delete

    });

    // Pagination
    $(document).on('click', '.paginationRole a', function(e) {
        e.preventDefault();
        var pagina = $(this).attr('href').split('page=')[1];
        carregarTabelaRole(pagina);
    });

    $("#search").keyup(function() {
        carregarTabelaRole(0);
      });

    // Search role
    function carregarTabelaRole(pagina) {

         // Gif
         $('.roles_data').html('<div class="d-flex justify-content-center mt-3 loading">Loading&#8230;</div>');

        var search = $("#search").val();
        
        $.ajax({
        url: "/role/list" + "?page=" + pagina,
        method: 'GET',
        data: {search: search} 
            }).done(function(data){
            //console.log(data);
            
            setTimeout(function() { 
                if(data) {
                    $('.roles_data').html(data);
                }else {
                    $('.roles_data').html('<div class="">Error</div>');
                }
            }, 1000);
        });
    }

    // Show role
    $(document).on('click', '.edit', function(e) {

        $("#successEdit").hide(); //hide message
        $(".modalGif").hide();
        $("#gif").show();

        var id = $(this).val();

        $.ajax({
            url: "/role/"+ id + "",
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

    // Edit role
    $(document).on('click', '.saveEdit', function(e) {
        $(".saveEdit").show();

        var id = $("#id").val();
        var name = $("#name").val();

        console.log(id);
        console.log(name);

        $.ajax({
            url: "/role/edit",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, name: name},
                }).done(function(data){
                console.log(data);
                    
                if(data) {
                    $("#successEdit").show();
                    $(".saveEdit").hide();

                    carregarTabelaRole(0);
                }
            }).fail(function(error) {

                // Message errors
                console.log("error");
                console.log(error.responseJSON.errors);

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


    // Return Form user
    $(document).on('click', '.createUser', function(e) {

        $("#successCreate").hide(); //hide message
        $(".modalFormGif").hide();
        $("#gifForm").show();

        $.ajax({
            url: "/users/form",
            method: 'GET',
            data: '' 
                }).done(function(data){
                //console.log(data);
                setTimeout(function() { 
                    if(data) {

                         // Gif
                         $("#gifForm").hide();
                        
                         $(".modalFormGif").show();

                        $('.form-user').html(data);
                    }else {
                        $('.form-user').html('<div class="">Error</div>');
                    }
                }, 500);
            });
    });

    // Create user
    $(document).on('click', '.saveForm', function(e) {
        $(".saveForm").show();

        var name = $("#name").val();
        var email = $("#email").val();
        var funct = $("#function").val();
        var password = $("#password").val();
        var password_confirmation = $("#password_confirmation").val();

        $.ajax({
            url: "/user",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {name: name, email: email, password: password, password_confirmation: password_confirmation, funct: funct},
                }).done(function(data){
                //console.log(data);
                    
                if(data) {
                    $("#successCreate").show();
                    $(".saveForm").hide();

                    carregarTabelaRole(0);
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
       

    // Show user
    $(document).on('click', '.delete', function(e) {

        var id = $(this).val();
        $.ajax({
            url: "/user/delete/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){

                    if(data) {
                        $("#successDelete").show();
                        carregarTabelaRole(0);
                        
                        setTimeout(function() { 
                            $("#successDelete").hide();
                        }, 3000);

                    }else {
                        console.log('Error');
                    }
            });
    });
       
   