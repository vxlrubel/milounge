// Get the modal
var modal = document.getElementById("myModalLarge");
var modalAll = document.getElementById("modalAllContentLarge");

var mainBody = document.querySelector("body");

console.log(modal);

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("modal-img");

// Grab Image
let isDown = false;
let startX;
let startY;
let scrollLeft;
let scrollTop;

function largezoom(id) {
    mainBody.style.overflow = "hidden";

    var img = document.getElementById(id);
    modal.style.display = "block";
    modalImg.src = img.src;
    var w = window.innerWidth;
    if (w >= 375) {
        modalAll.scrollLeft = 0;
    } else {
        modalAll.scrollLeft += 25;
    }
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    mainBody.style.overflow = "visible";
    modal.style.display = "none";
    var pic = document.getElementById("modal-img");
    pic.classList.remove("img-zoomInLarge");
    pic.style.width = "auto";
    pic.style.height = "100%";
    var w = window.innerWidth;
    modalAll.scrollLeft = 1;
};
function zoomInLarge() {
    var pic = document.getElementById("modal-img");
    pic.classList.add("img-zoomInLarge");
    var w = window.innerWidth;
    if (w >= 768) {
        pic.style.width = "100%";
        pic.style.height = "auto";
    } else {
        modalAll.scrollLeft = 80;
        pic.style.width = "150%";
        pic.style.height = "auto";
    }
}
function zoomOutLarge() {
    var pic = document.getElementById("modal-img");
    pic.classList.remove("img-zoomInLarge");
    var w = window.innerWidth;
    if (w >= 768) {
        pic.style.width = "auto";
        pic.style.height = "100%";
    } else {
        pic.style.width = "auto";
        pic.style.height = "100%";
    }
}
modalAll.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX - modalAll.offsetLeft;
    startY = e.pageY - modalAll.offsetTop;
    scrollLeft = modalAll.scrollLeft;
    scrollTop = modalAll.scrollTop;
    modalAll.style.cursor = "grabbing";
});
modalAll.addEventListener("mouseleave", () => {
    isDown = false;
    modalAll.style.cursor = "grab";
});
modalAll.addEventListener("mouseup", () => {
    isDown = false;
    modalAll.style.cursor = "grab";
});
document.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - modalAll.offsetLeft;
    const y = e.pageY - modalAll.offsetTop;
    const walkX = (x - startX) * 2;
    const walkY = (y - startY) * 2;
    modalAll.scrollLeft = scrollLeft - walkX;
    modalAll.scrollTop = scrollTop - walkY;
});
