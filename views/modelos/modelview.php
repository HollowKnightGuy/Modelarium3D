<?php 
$estilos = [ 'modelview','models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
?>
    
    <main class="modelview-main">

        <div class="model-view-container">
            <div class="model-view-card">

                <div class="model-view-model">
                    <img src="../img/models/arcade.png" alt="">
                </div>

            </div>

            <div class="model-view-info">

                <div class="model-info-1">
                    <h1 id="model-view-title">Arcade Machine</h1>
                    <h2 id="model-view-author">Author: <a href="<?= $_ENV['BASE_URL'] ?>model/author" class="linkpurple">Pablo Cid</a></h2>
                    <div class="modelview-interactions " >
                        <img src="../img/icons/heart.svg" alt=""><span>24 Likes</span> <img src="<?= $_ENV['BASE_URL'] ?>img/icons/star.svg" alt=""><span>32 Favorites</span>
                    </div>
                </div>
                

                <div class="model-info-2">
                    <div class="model-info-2-price">
                        <h1 id="modelview-price-title">Price</h1>
                        <div class="model--price textshadowlight">
                            <span class="price--bnumber">19</span><span class="price-snumber">,95€</span>
                        </div>
                    </div>
                    <div class="model-info-2-btn">
                        <button class="defaultbtn buynow-btn boxshadow">BUY NOW</button>
                    </div>
                </div>
                

                <div class="model-info-3">

                    <h3>Description</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit quo explicabo suscipit similique praesentium magnam dolore cumque distinctio modi. Et, corrupti. Inventore culpa cupiditate praesentium qui, aperiam debitis adipisci nam! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit quo explicabo suscipit similique praesentium magnam dolore cumque distinctio modi. Et, corrupti. Inventore culpa cupiditate praesentium qui, aperiam debitis adipisci nam! </p>    

                </div>
            </div>

        </div>

        <div class="comment-container">

            <div class="cont-comment-1">
                <div class="comment-user-info">
                    <img class="profileimg-comment" src="<?= $_ENV['BASE_URL'] ?>img/banner/profile.jpg" alt="">
                    <h1 class="username-modelview">You</h1>
                </div>

                <div class="comment-1">
                    <input type="text" name="comment" id="comment-1" placeholder="Comment..."> <button class="defaultbtn boxshadow" type="submit">Comment</button>
                </div>
            </div>

            <div class="cont-comment-2">
                <div class="comment-user-info">
                    <img class="profileimg-comment" src="<?= $_ENV['BASE_URL'] ?>img/banner/profile.jpg" alt="">
                    <h1 class="username-modelview">User 1</h1>
                </div>

                <div class="comment-2-container">
                    <div class="comment-2">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptas reprehenderit, amet, at accusamus voluptate aliquam atque illo pariatur dolores facilis ratione accusantium sint totam voluptatum, error autem officiis ab. </p>
                    </div>
                    <img class="report-flag" src="<?= $_ENV['BASE_URL'] ?>img/icons/red-flag.svg" alt="report flag">
                </div>
                
            </div>

            <div class="cont-comment-2">
                <div class="comment-user-info">
                    <img class="profileimg-comment" src="<?= $_ENV['BASE_URL'] ?>img/banner/profile.jpg" alt="">
                    <h1 class="username-modelview">User 2</h1>
                </div>

                <div class="comment-2-container">
                    <div class="comment-2">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptas reprehenderit, amet, at accusamus voluptate aliquam atque illo pariatur dolores facilis ratione accusantium sint totam voluptatum, error autem officiis ab. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptas reprehenderit, amet, at accusamus voluptate aliquam atque illo pariatur dolores facilis ratione accusantium sint totam voluptatum, error autem officiis ab.</p>
                    </div>
                    <img class="report-flag" src="<?= $_ENV['BASE_URL'] ?>img/icons/flag.svg" alt="report flag">
                </div>
                
            </div>

            <div class="cont-comment-2">
                <div class="comment-user-info">
                    <img class="profileimg-comment" src="<?= $_ENV['BASE_URL'] ?>img/banner/profile.jpg" alt="">
                    <h1 class="username-modelview">User 3</h1>
                </div>

                <div class="comment-2-container">
                    <div class="comment-2">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem voluptas reprehenderit, amet, at accusamus voluptate aliquam atque illo pariatur dolores facilis ratione accusantium sint totam voluptatum, error autem officiis ab. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim nisi saepe beatae nostrum animi minus pariatur ab voluptatem. Enim quis soluta exercitationem nostrum aliquid ea laborum laudantium! Illo, a aspernatur? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt laborum modi ullam at fugiat reiciendis cumque accusamus magnam! Molestiae dolor debitis eaque est magni amet sapiente vel reprehenderit assumenda quidem?</p>
                    </div>
                    <img class="report-flag" src="<?= $_ENV['BASE_URL'] ?>img/icons/red-flag.svg" alt="report flag">
                </div>
            </div>
        </div>
    </main>
