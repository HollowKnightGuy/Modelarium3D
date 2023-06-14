this.document.getElementById("width").innerHTML = this.window.innerWidth;

window.addEventListener("resize", function(){
    this.document.getElementById("width").innerHTML = this.window.innerWidth;
});