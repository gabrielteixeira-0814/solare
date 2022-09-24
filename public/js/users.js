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


    /*** Table Users ***/
    
    $(document).ready(function(){
        carregarTabelaUser(0);
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

        $("#success").hide(); //hide message
        $(".modalGif").hide();
        $("#gif").show();

        var id = $(this).val();
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
    $(document).on('click', '.save', function(e) {
        $(".save").show();

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
                    $("#success").show();
                    $(".save").hide();
                }
            });
    });

    // close modal
    $(document).on('click', '.close', function(e) {
        $(".save").show();
    });

