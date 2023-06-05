
<?php 
$estilos = [ 'profile','models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL_PUBLIC'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
?>
    <main>
    
        <div class="banner">
            <img class="banner-img" src="../img/default/banner.jpg" alt="banner">

            <img class="profile-img" src="../img/default/profile.jpg" alt="profile">
            
            <div class="profile-info">
                <h1>ByCarlitos</h1>
                <p>Joined 12/12/2006</p>
                <p>Creator</p>
            </div>
        </div>


        
        <div class="models">


            <div class="model">
                <div class="model--model">
                    <img src="../img/logo/logo.png" alt="model">
                </div>
        
                <div class="model--modelinfo">
                    <div class="infomodel">
                        <div class="model--title">Logo Modelarium</div>
                        <div class="model--author ">Author: <a href="author.html" class="linkpurple">ByCarlitos</a></div>
                    </div>
                    <div class="model--likesfavs textshadowlight">
                        <div class="model--likes">
                            <img class="likes-img" src="../img/icons/heart.svg" alt="heart">
                            <span>40</span>
                        </div>
                        <div class="model--favs">
                            <img class="favs-img" src="../img/icons/star.svg" alt="heart">
                            <span>40</span>
                        </div>
                    </div>
                </div>
        
                <div class="buy">
                    <div class="model--seebtn">
                        <button class="boxshadow defaultbtn transition">See more</button>
                    </div>
                    <div class="model--price textshadowlight">
                        <span class="price--bnumber">4</span><span class="price-snumber">,99€</span>
                    </div>
                </div>
            </div>





            <div class="model">
                <div class="model--model">
                    <img src="../img/logo/logo.png" alt="model">
                </div>
        
                <div class="model--modelinfo">
                    <div class="infomodel">
                        <div class="model--title">Logo Modelarium</div>
                        <div class="model--author ">Author: <a href="author.html" class="linkpurple">ByCarlitos</a></div>
                    </div>
                    <div class="model--likesfavs textshadowlight">
                        <div class="model--likes">
                            <img class="likes-img" src="../img/icons/heart.svg" alt="heart">
                            <span>40</span>
                        </div>
                        <div class="model--favs">
                            <img class="favs-img" src="../img/icons/star.svg" alt="heart">
                            <span>40</span>
                        </div>
                    </div>
                </div>
        
                <div class="buy">
                    <div class="model--seebtn">
                        <button class="boxshadow defaultbtn transition">See more</button>
                    </div>
                    <div class="model--price textshadowlight">
                        <span>4</span><span class="price-snumber">,99€</span>
                    </div>
                </div>
            </div>

        </div>
    </main>
