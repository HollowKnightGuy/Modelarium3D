document.addEventListener("DOMContentLoaded", function() {




    const profileLinks = document.getElementsByClassName("profile_link");


    // MENU VARIABLES
    const menuBtn = document.getElementsByClassName("menu")[0]


    // ICONS FROM HEADER
    const headerHeart = document.getElementsByClassName("heart-icon")[0];
    const headerHeart1src = document.getElementsByClassName("heart-icon")[0].src;
    const headerHeart2src = document.getElementsByClassName("heart-icon")[1].src;

    const headerStar = document.getElementsByClassName("star-icon")[0];
    const headerStar1src = document.getElementsByClassName("star-icon")[0].src;
    const headerStar2src = document.getElementsByClassName("star-icon")[1].src;

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

    headerHeart.addEventListener("mouseover", function(){
        headerHeart.src = headerHeart2src
        
    });
    headerHeart.addEventListener("mouseout", function(){
        headerHeart.src = headerHeart1src
    });

    headerStar.addEventListener("mouseover", function(){
        headerStar.src = headerStar2src
    });
    headerStar.addEventListener("mouseout", function(){
        headerStar.src = headerStar1src
    });

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

