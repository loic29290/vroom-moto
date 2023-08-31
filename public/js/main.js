document.addEventListener('DOMContentLoaded', function () {

    const burgerButton = document.querySelector('.burger-menu');
    const menu = document.querySelector('.menu');

    burgerButton.addEventListener('click', function () {
        menu.classList.toggle('active');
    });
    const deroulantItem = document.querySelector('.deroulant');

deroulantItem.addEventListener('click', function () {
    deroulantItem.classList.toggle('ouvert');
});

    

    //Carousel

    let images = document.querySelectorAll('#carousel>img');
    let imageIndex = 0;
    let timer;
    let slider = document.querySelector('#carousel');

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

    // calendrier

    const monthYear = document.getElementById("monthYear");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const daysContainer = document.querySelector(".days");
    const maxSelectedDates = 2;

    let todayDate = new Date();
    let currentDate = new Date();
    let selectedDates = [];

    function updateCalendar() {
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        monthYear.textContent = new Intl.DateTimeFormat("fr", { year: 'numeric', month: 'long' }).format(currentDate);

        const firstDay = new Date(currentYear, currentMonth, 1);
        const firstDayIndex = firstDay.getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        daysContainer.innerHTML = "";

        // Ajoute les cases vides avant le jour de début de mois
        for (let i = 0; i < firstDayIndex; i++) {
            const emptyDay = document.createElement("div");
            emptyDay.classList.add("day", "empty");
            daysContainer.appendChild(emptyDay);
        }

        // Pour chacun des jours du mois
        for (let i = 1; i <= daysInMonth; i++) {
            const dayElement = document.createElement("div");
            dayElement.classList.add("day");
            dayElement.textContent = i;

            // Surbrillance du jour courant
            if (i === todayDate.getDate() && currentMonth === todayDate.getMonth() && currentYear === todayDate.getFullYear()) {
                dayElement.classList.add("today");
            }

            //Debut event click
            dayElement.addEventListener("click", () => {
                const selectedDate = new Date(currentYear, currentMonth, i + 1);

                // Vérifier que la date choisie soit dans le futur
                if (selectedDate >= todayDate) {
                    if (!dayElement.classList.contains("selected")) {
                        if (selectedDates.length < maxSelectedDates) {
                            dayElement.classList.add("selected");
                            selectedDates.push(selectedDate);
                        } else {
                            alert("Vous ne pouvez sélectionner que deux dates.");
                        }
                    } else {
                        dayElement.classList.remove("selected");
                        selectedDates = selectedDates.filter(date => !isSameDay(date, selectedDate));
                    }
                } else {
                    alert("Vous ne pouvez pas sélectionner de date antérieure à aujourd'hui.");
                }

                // Efface la classe 'reserved' de tous les jours
                daysContainer.querySelectorAll(".day").forEach(day => day.classList.remove("reserved"));

                // Deux dates sélectionnées
                if (selectedDates.length === 2) {
                    const [start, end] = selectedDates.sort((a, b) => a - b);

                    // Ajoute la classe 'reserved' aux jours entre les deux dates
                    for (let date = new Date(start); date < end; date.setDate(date.getDate() + 1)) {
                        const dayNumber = date.getDate();
                        const dayElement = daysContainer.querySelector(`.day:not(.empty):not(.selected):not(.today):nth-child(${dayNumber + firstDayIndex})`);

                        if (dayElement) {
                            dayElement.classList.add("reserved");
                        }
                    }

                    // Mettre les valeurs dans les inputs
                    document.getElementById("debut").value = start.toISOString().substr(0, 10);
                    document.getElementById("fin").value = end.toISOString().substr(0, 10);
                }
            });
            // Fin event click

            daysContainer.appendChild(dayElement);
        }
    }

    function isSameDay(date1, date2) {
        return (
            date1.getDate() === date2.getDate() &&
            date1.getMonth() === date2.getMonth() &&
            date1.getFullYear() === date2.getFullYear()
        );
    }

    prevBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        //empty selected dates
        selectedDates = [];
        updateCalendar();
    });

    nextBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        //empty selected dates
        selectedDates = [];
        updateCalendar();
    });

    updateCalendar();

});