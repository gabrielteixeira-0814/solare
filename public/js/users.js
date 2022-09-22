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


    /*** Table project ***/
    
    $(document).ready(function(){
        carregarTabelaSale(0);
    });

    $(document).on('click', '.paginationSale a', function(e) {
        e.preventDefault();
        var pagina = $(this).attr('href').split('page=')[1];
        carregarTabelaSale(pagina);
    });

    // Filtro
    $(document).on('submit', '.form_sale', function(e) {
        e.preventDefault();

        // Limpando o input de limpar filtro
        $('#clearFilter').val('');
        carregarTabelaSale(0);
    });

    // Limpar filtro
    $(document).on('click', '.clear', function(e) {
        e.preventDefault();

        var clearFilterNoActiver = "clear";
        $('#clearFilter').val(clearFilterNoActiver);
        carregarTabelaSale(0);
        
    });

    
    function carregarTabelaSale(pagina) {
        var dados = $('#form_sale').serialize();

        //console.log(dados);

        $.ajax({
        url: "/user/list" + "?page=" + pagina,
        method: 'GET',
        data: dados
        }).done(function(data){
        // console.log(data);
        $('.user_data').html(data);
        });
    }
  
    
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

    function carregarTabelaUser(pagina) {
        var search = $("#search").val();

        $.ajax({
        url: "/user/list" + "?page=" + pagina,
        method: 'GET',
        data: {search: search} 
            }).done(function(data){
            console.log(data);
            $('.users_data').html(data);
        });
    }

    // Show user

    // $(document).on('click', '.save', function(e) {
    //     var dados = $("div").text($("form").serialize());
    //     console.log(dados);
    // });

