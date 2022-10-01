
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
                        $('#idBoards').val(data.boards.id);
                        $('#boards').val(data.boards.token);
                        $('idCompany').val(data.company.id);
                        $('#company').val(data.company.token);
                        $('#idMonday').val(data.monday.id);
                        $('#monday').val(data.monday.token);
                }, 1000);
                    
                }else {
                    console.log('Error');
                }
            });
    }


    // Edit board
    $(document).on('click', '.SettingFormBoards', function(e) {
        //$(".saveEdit").show();

        var id = $('#idBoards').val();
        var token = $('#boards').val();

        $.ajax({
            url: "/setting/edit/board",
            method: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id: id, token: token},
                }).done(function(data){
                //console.log(data);
                    
                if(data) {
                    console.log(data);
                    //$("#successEdit").show();
                    //$(".saveEdit").hide();

                    //carregarTabelaUser(0);
                }
            }).fail(function(error) {

                // Message errors
                console.log("error");
                console.log(error.responseJSON.errors);

                // $.each(error.responseJSON.errors, function( k, v ) {
                //     $('.msgErrorEdit').append("<div class='alert alert-danger errorMsgEdit' role='alert'>" + v + "</div>");
                //   });

                //   $( ".errorMsgEdit" ).fadeIn(300).delay(3000).fadeOut(300);

                //   setTimeout(function() { 
                //     $( ".errorMsgEdit" ).remove();
                // }, 4000);
              }); 
    });



  
   