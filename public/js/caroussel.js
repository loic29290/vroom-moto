document.addEventListener('DOMContentLoaded', function () {

   
    //Carousel

    let images = document.querySelectorAll('.carousel>img');
    let imageIndex = 0;
    let timer;
    let slider = document.querySelector('.carousel');

    function goToNext() {
        //console.log(images[imageIndex]);
        images[imageIndex].style.opacity = 0;

        if (imageIndex < images.length - 1)//  <5
        {
            imageIndex++;
        }
        else {
            imageIndex = 0;
        }
        images[imageIndex].style.opacity = 1;

    }
    if (slider) {
        timer = setInterval(goToNext, 3000)
    }

})