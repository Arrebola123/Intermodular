let nextButton = document.getElementById('next');
let prevButton = document.getElementById('prev');
let carousel = document.querySelector('.carousel');
let listHTML = document.querySelector('.carousel .list');
let seeMoreButtons = document.querySelectorAll('.seeMore');
let backButton = document.getElementById('back');

nextButton.onclick = function(){
    showSlider('next');
}
prevButton.onclick = function(){
    showSlider('prev');
}
let unAcceppClick;
const showSlider = (type) => {
    nextButton.style.pointerEvents = 'none';
    prevButton.style.pointerEvents = 'none';

    carousel.classList.remove('next', 'prev');
    let items = document.querySelectorAll('.carousel .list .item');
    if(type === 'next'){
        listHTML.appendChild(items[0]);
        carousel.classList.add('next');
    }else{
        listHTML.prepend(items[items.length - 1]);
        carousel.classList.add('prev');
    }
    clearTimeout(unAcceppClick);
    unAcceppClick = setTimeout(()=>{
        nextButton.style.pointerEvents = 'auto';
        prevButton.style.pointerEvents = 'auto';
    }, 2000)
}
seeMoreButtons.forEach((button) => {
    button.onclick = function(){
        carousel.classList.remove('next', 'prev');
        carousel.classList.add('showDetail');
    }
});
backButton.onclick = function(){
    carousel.classList.remove('showDetail');
}

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const resultsBox = document.getElementById("search-results");

    searchInput.addEventListener("keyup", function () {
        let query = searchInput.value;

        if (query.length > 2) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "busqueda_ajax.php?search=" + query, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText.trim() !== "") {
                        resultsBox.innerHTML = xhr.responseText;
                        resultsBox.classList.add("show");
                    } else {
                        resultsBox.classList.remove("show");
                    }
                }
            };
            xhr.send();
        } else {
            resultsBox.classList.remove("show");
            resultsBox.innerHTML = "";
        }
    });

    // Ocultar resultados al hacer clic fuera
    document.addEventListener("click", function (event) {
        if (!searchInput.contains(event.target) && !resultsBox.contains(event.target)) {
            resultsBox.classList.remove("show");
        }
    });
});
