document.addEventListener("DOMContentLoaded", function() {




    const profileLinks = document.getElementsByClassName("profile_link");


    // MENU VARIABLES
    const menuBtn = document.getElementsByClassName("menu")[0]


    // ICONS FROM HEADER

    const headerProfile = document.getElementsByClassName("profile-icon")[0];
    const headerProfile1src = document.getElementsByClassName("profile-icon")[0].src;
    const headerProfile2src = document.getElementsByClassName("profile-icon")[1].src;





    // RESPONSIVE MENU OF HEADER

    $('.menu').click (function(){
        $(this).toggleClass('open');
        $('.responsivemenu').toggleClass('isactive')
        if(menuBtn.className.includes('open')){
            $('body').css("overflow", "hidden")
        }else{
            $('body').css("overflow", "")
        }
    });





    $(".magn-glass").click (function(){
        $(".responsivesearcher").toggleClass("isactivesearcher");
        $(".responsivesearcher > input" ).focus();
    })
    $("main").click(function(){
        if($(".responsivesearcher").attr('class').split(" ").length > 2){
            $(".responsivesearcher").toggleClass("isactivesearcher");
        }
    })







    // HOVER EFFECTS FOR THE HEADER ICONS   
    headerProfile.addEventListener("mouseover", function(){
        headerProfile.src = headerProfile2src
    });
    headerProfile.addEventListener("mouseout", function(){
        headerProfile.src = headerProfile1src
    });








   







    // HELPER THAT TELLS THE WIDTH OF THE WINDOW
    // this.document.getElementById("width").innerHTML = this.window.innerWidth;

    // window.addEventListener("resize", function(){
    //     this.document.getElementById("width").innerHTML = this.window.innerWidth;
    // });



});

