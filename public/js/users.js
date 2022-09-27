
// Headers start
document.addEventListener("DOMContentLoaded", function(event) {

    const showNavbar = (toggleId, navId, bodyId, headerId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodypd = document.getElementById(bodyId),
    headerpd = document.getElementById(headerId)

    // Validate that all variables exist
        if(toggle && nav && bodypd && headerpd){
            toggle.addEventListener('click', ()=>{
            // show navbar
            nav.classList.toggle('showHeader')
            // change icon
            toggle.classList.toggle('bx-x')
            // add padding to body
            bodypd.classList.toggle('body-pd')
            // add padding to header
            headerpd.classList.toggle('body-pd')
            })
        }
    }

    showNavbar('header-toggle','nav-bar','body-pd','header')

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')

    function colorLink(){
    if(linkColor){
    linkColor.forEach(l=> l.classList.remove('active'))
    this.classList.add('active')
    }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))

    // Your code to run since DOM is loaded and ready
    });

    // Headers start end

    /*** Table Users ***/

    $(document).ready(function(){
        carregarTabelaUser(0);

        $("#successDelete").hide(); // hide message success delete

    });

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

        console.log(id);
        $.ajax({
            url: "/user/"+ id + "",
            method: 'GET',
            data: "" 
                }).done(function(data){
                console.log(data);

                setTimeout(function() { 
                    if(data) {

                        // Gif
                        $("#gif").hide();

                        $(".modalGif").show();
                        
                        $('#id').val(data.id)
                        $('#name').val(data.name)
                        $('#email').val(data.email)
                        $('#function').val(data.name)
                    }else {
                        console.log('Error');
                    }
                }, 1000);
            });
    });

    // Edit user
    $(document).on('click', '.saveEdit', function(e) {
        $(".saveEdit").show();

        var id = $("#id").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var funct = $("#function").val();

        $.ajax({
            url: "/user/edit",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, name: name, email: email, funct: funct},
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
                        carregarTabelaUser(0);
                        
                        setTimeout(function() { 
                            $("#successDelete").hide();
                        }, 3000);

                    }else {
                        console.log('Error');
                    }
            });
    });
       
   