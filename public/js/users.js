
    /*** Table Users ***/

    $(document).ready(function(){
        carregarTabelaUser(0);

        $("#successDelete").hide(); // hide message success delete

    });

    // Pagination
    $(document).on('click', '.paginationUser a', function(e) {
        e.preventDefault();
        var pagina = $(this).attr('href').split('page=')[1];
        carregarTabelaUser(pagina);
    });

    $("#search").keyup(function() {
        carregarTabelaUser(0);
      });

    // Search user
    function carregarTabelaUser(pagina) {

         // Gif
         $('.users_data').html('<div class="d-flex justify-content-center mt-3 loading">Loading&#8230;</div>');

        var search = $("#search").val();
        
        $.ajax({
        url: "/user/list" + "?page=" + pagina,
        method: 'GET',
        data: {search: search} 
            }).done(function(data){
            // console.log(data);
            
            setTimeout(function() { 
                if(data) {
                    $('.users_data').html(data);
                }else {
                    $('.users_data').html('<div class="">Error</div>');
                }
            }, 1000);
        });
    }

    // Show user
    $(document).on('click', '.edit', function(e) {

        $("#successEdit").hide(); //hide message
        $(".modalGif").hide();
        $("#gif").show();

        var id = $(this).val();

        carregarRole(id);

        //console.log(id);
        $.ajax({
            url: "/user/"+ id + "",
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
                        $('.email').val(data.email)
                        $('.function').val(data.name)
                    }else {
                        console.log('Error');
                    }
                }, 1000);
            });
    });

    // Edit user
    $(document).on('click', '.saveEdit', function(e) {
        $(".saveEdit").show();

        value = $(".form_user_edit").serialize();

        $.ajax({
            url: "/user/edit",
            method: 'POST',
            //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: value,
                }).done(function(data){
                //console.log(data);
                    
                if(data) {
                    $("#successEdit").show();
                    $(".saveEdit").hide();

                    carregarTabelaUser(0);
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

        // Remove list
        $( ".listRole" ).remove();

        $('.divlistRole').html("<div class='listRole'></div>");

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

        value = $(".form_user").serialize();

        $.ajax({
            url: "/user",
            method: 'POST',
            //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: value,
                }).done(function(data){
                console.log(data);
                    
                if(data) {
                    $("#successCreate").show();
                    $(".saveForm").hide();

                    carregarTabelaUser(0);
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
       

    // Delete user
    $(document).on('click', '.delete', function(e) {

        var id = $(this).val();
        $.ajax({
            url: "/user/delete/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){

                    if(data) {
                        $("#successDelete").show();
                        carregarTabelaUser(0);
                        
                        setTimeout(function() { 
                            $("#successDelete").hide();
                        }, 3000);

                    }else {
                        console.log('Error');
                    }
            });
    });
       
   
    function carregarRole(id) {

        $.ajax({
            url: "/userRole/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){

                 if(data) {
                    listRole = data;

                    //console.log(listRole);
                 }
            });

       $.ajax({
       url: "/user/role/list",
       method: 'GET',
       data: "" 
           }).done(function(data){

            if(data) {
                //console.log(data);
                $.each(data, function( k, v ) {

                    ckeck = '';

                    if(listRole){
                        // Verifica se a permissão já existe, se existir colocar como ativo
                        if($.inArray(v.id, listRole) !== -1) {
                            ckeck = 'checked';
                        }
                    }

                    $('.listRole').append("<div class='form-check'><input class='form-check-input' type='checkbox' "+ckeck+" name='"+ v.name +"'  value='"+ v.id +"' id='"+ v.name +"'><label class='' for='"+ v.name +"'>"+ v.name +"</label></div>");
                });
            }
       });
    }