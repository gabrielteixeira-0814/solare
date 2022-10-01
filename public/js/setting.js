
    /*** Table Users ***/

    $(document).ready(function(){
        carregarFormSetting();
        carregarValueForm();

        //$("#successDelete").hide(); // hide message success delete

    });
   
    // Search user
    function carregarFormSetting() {

         // Gif
         $('.setting_data').html('<div class="d-flex justify-content-center mt-3 loading">Loading&#8230;</div>');

        $.ajax({
        url: "/settingForm",
        method: 'GET',
        data: '' 
            }).done(function(data){
            //console.log(data);
            
            setTimeout(function() { 
                if(data) {
                    $('.setting_data').html(data);
                }else {
                    $('.setting_data').html('<div class="">Error</div>');
                }
            }, 500);
        });
    }

    // Show Setting

    function carregarValueForm() {
        $.ajax({
            url: "/setting/list",
            method: 'GET',
            data: '' 
                }).done(function(data){
                //console.log(data);
                if(data) {
                    setTimeout(function() { 
                        $('#boards').val(data.boards)
                        $('#company').val(data.company)
                        $('#monday').val(data.monday)
                }, 1000);
                    
                }else {
                    console.log('Error');
                }
            });
    }

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



  
   