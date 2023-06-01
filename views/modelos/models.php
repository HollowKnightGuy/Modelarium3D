<?php 
$estilos = ['models'];
foreach ($estilos as $estilo) :  ?>
    <link rel="stylesheet" href="<?= $_ENV['BASE_URL'] ?>css/<?= $estilo ?>.css">
<?php
endforeach;
require_once '../views/layout/header.php';
?>

    <main>
        <div class="models-header">
            <h1>All Models</h1>
            <div class="models-header-select">
                <div class="select transition">
                    
                    <ul id="select" onclick="displaySelect()">
                        <li class="select-option transition default" onclick="changeModelsState(0, this)">All Models</li>
                        <li class="select-option transition" onclick="changeModelsState(1, this)">Level 1</li>
                        <li class="select-option transition" onclick="changeModelsState(2, this)">Level 2</li>
                        <li class="select-option transition" onclick="changeModelsState(3, this)">Level 3</li>
                    </ul>
                    <img src="<?= $_ENV['BASE_URL'] ?>img/icons/down-arrow.svg" alt="">
                </div>
                <!-- <form action="<?= $_ENV['BASE_URL'] ?>models" id="models-form" hidden> -->
                    <select name="" id="form-select" onchange="console.log(2)" hidden>
                        <option value="0" selected>All Levels</option>
                        <option value="1">D1</option>
                        <option value="2">D2</option>
                        <option value="3">D3</option>
                    </select>
                <!-- </form> -->

            </div>
        </div>


        <div class="models">


            <div class="model">
                <div class="model--model">
                    <img src="<?= $_ENV['BASE_URL'] ?>img/models/arcade.png" alt="model">
                </div>
        
                <div class="model--modelinfo">
                    <div class="infomodel">
                        <div class="model--title">Arcade Machine</div>
                        <div class="model--author ">Author: <a href="<?= $_ENV['BASE_URL'] ?>model/author" class="linkpurple">Pablo Cid</a></div>
                    </div>
                    <div class="model--likesfavs textshadowlight">
                        <div class="model--likes">
                            <img class="likes-img" src="<?= $_ENV['BASE_URL'] ?>img/icons/heart.svg" alt="heart">
                            <span>40</span>
                        </div>
                        <div class="model--favs">
                            <img class="favs-img" src="<?= $_ENV['BASE_URL'] ?>img/icons/star.svg" alt="heart">
                            <span>40</span>
                        </div>
                    </div>
                </div>
        
                <div class="buy">
                    <div class="model--seebtn">
                        <button class="boxshadow defaultbtn transition" onclick="location.href = '<?= $_ENV['BASE_URL'] ?>models/view'">SEE MORE</button>
                    </div>
                    <div class="model--price textshadowlight">
                        <span class="price--bnumber">19</span><span class="price-snumber">,95€</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        let displayed = false;
        const ulSelect = document.getElementById("select");
        const ulOptions = document.getElementsByClassName("select-option");
        const formSel = document.getElementById("form-select");
        const modelsForm = document.getElementById("models-form");
        const options = []
        formSel.childNodes.forEach(element => {
            if (element.nodeType === Node.ELEMENT_NODE) options.push(element)  
        });
        
        console.log(options);
        
        function changeModelsState(option, element){
            for(let i = 0; i < 3; i++){
                ulOptions[i].classList.remove("default");
            }
        
            element.classList.toggle("default");
            formSel.value = option;
            modelsForm.submit()
        }


        function displaySelect(){
            if(displayed){
                for(let i = 0; i < 4; i++){
                    if(ulOptions[i].classList.contains( 'default' )){
                        ulOptions[i].style.display = "block";

                    }else{
                        ulOptions[i].style.display = "none";
                    }
                }
                displayed = false;
            }else{
                for(let i = 0; i < 4; i++){
                    ulOptions[i].style.display = "block";
                    displayed = true;
                }
            }
        }
    </script>