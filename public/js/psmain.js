// PROFILE SETTINGS VARIABLES
document.addEventListener("DOMContentLoaded", function () {
  if (document.getElementById("iteration") === null) {
    let a = document.createElement("a");
    a.setAttribute("id", "iteration");
    document.body.appendChild(a);
    const pslinks = document.getElementsByClassName("profsetlink");
    const pssections = document.getElementsByClassName("profsetsection");

    const psProfImg = document.getElementsByClassName("ps-prof-img")[0];
    const psProfImgPencil = document.getElementById("pencil1");
    const inputPSImg = document.getElementById("input-ps-img");

    const psProfBanner = document.getElementsByClassName("ps-prof-banner")[0];
    const psProfBannerPencil = document.getElementById("pencil2");
    const inputPSBanner = document.getElementById("input-ps-banner");

    const faqQuestions = document.querySelectorAll(".faq-question");

    // PROFILE SETTINGS IMG HOVER EFFECT
    psProfImg.addEventListener("mouseover", function () {
      psProfImgPencil.style.display = "block";
    });
    psProfImg.addEventListener("mouseout", function () {
      psProfImgPencil.style.display = "none";
    });
    psProfImg.addEventListener("click", function () {
      inputPSImg.click();
    });

    // PROFILE SETTINGS BANNER HOVER EFFECT
    psProfBanner.addEventListener("mouseover", function () {
      psProfBannerPencil.style.display = "block";
    });
    psProfBanner.addEventListener("mouseout", function () {
      psProfBannerPencil.style.display = "none";
    });
    psProfBanner.addEventListener("click", function () {
      inputPSBanner.click();
    });

    faqQuestions.forEach((element) => {
      element.addEventListener("click", function () {
        if (
          window
            .getComputedStyle(element.nextElementSibling)
            .getPropertyValue("display") === "none"
        ) {
          element.lastElementChild.src = element.lastElementChild.src
            .split("down-arrow")
            .join("up-arrow");
          element.nextElementSibling.style.display = "block";
        } else {
          element.lastElementChild.src = element.lastElementChild.src
            .split("up-arrow")
            .join("down-arrow");
          element.nextElementSibling.style.display = "none";
        }
      });
    });

    // FUNCIONALITY OF THE PROFILE SETTINGS
    pslinks[4].addEventListener("click", function () {
      changePSState("none", "none", "none", "flex");
    });

    pslinks[3].addEventListener("click", function () {
      changePSState("none", "none", "none", "flex");
    });
    pslinks[2].addEventListener("click", function () {
      changePSState("none", "none", "flex", "none");
    });
    pslinks[1].addEventListener("click", function () {
      changePSState("none", "flex", "none", "none");
    });
    pslinks[0].addEventListener("click", function () {
      changePSState("flex", "none", "none", "none");
    });

    let lastclicked;

    function changePSState(s1, s2, s3, s4) {
      pssections[0].style.display = s1;
      pssections[1].style.display = s2;
      pssections[2].style.display = s3;
      pssections[3].style.display = s4;

      if (s1 !== "none") {
        changePSLinkStates(lastclicked, 0);
      } else if (s2 !== "none") {
        changePSLinkStates(lastclicked, 1);
      } else if (s3 !== "none") {
        changePSLinkStates(lastclicked, 2);
      } else if (s4 !== "none") {
        changePSLinkStates(lastclicked, 3);
      }
    }

    function changePSLinkStates(link, newlink) {
      if (typeof link != "undefined") link.className = "profsetlink transition";
      pslinks[newlink].classList.add("psclicked");
      lastclicked = pslinks[newlink];
    }
  }
});
