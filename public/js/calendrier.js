document.addEventListener('DOMContentLoaded', function () {

    // calendrier

    const monthYear = document.getElementById("monthYear");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const daysContainer = document.querySelector(".days");
    const maxSelectedDates = 2;

    let todayDate = new Date();
    let currentDate = new Date();
    let selectedDates = [];

    function updateCalendar(reservations) {
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        monthYear.textContent = new Intl.DateTimeFormat("fr", { year: 'numeric', month: 'long' }).format(currentDate);

        const firstDay = new Date(currentYear, currentMonth, 1);
        const firstDayIndex = firstDay.getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        daysContainer.innerHTML = "";

        for (let i = 0; i < firstDayIndex; i++) {
            const emptyDay = document.createElement("div");
            emptyDay.classList.add("day", "empty");
            daysContainer.appendChild(emptyDay);
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const dayElement = document.createElement("div");
            dayElement.classList.add("day");
            dayElement.textContent = i;

            if (i === todayDate.getDate() && currentMonth === todayDate.getMonth() && currentYear === todayDate.getFullYear()) {
                dayElement.classList.add("today");
            }

            dayElement.addEventListener("click", () => {
                const selectedDate = new Date(currentYear, currentMonth, i + 1);

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

                daysContainer.querySelectorAll(".day").forEach(day => day.classList.remove("reserved"));

                if (selectedDates.length === 2) {
                    const [start, end] = selectedDates.sort((a, b) => a - b);

                    for (let date = new Date(start); date < end; date.setDate(date.getDate() + 1)) {
                        const dayNumber = date.getDate();
                        const dayElement = daysContainer.querySelector(`.day:not(.empty):not(.selected):not(.today):nth-child(${dayNumber + firstDayIndex})`);

                        if (dayElement) {
                            dayElement.classList.add("reserved");
                        }
                    }

                    document.getElementById("debut").value = start.toISOString().substr(0, 10);
                    document.getElementById("fin").value = end.toISOString().substr(0, 10);
                }
            });

            const currentDate = new Date(currentYear, currentMonth, i);
            const isReserved = reservations.some(reservation => {
                return isSameDay(new Date(reservation.fin), currentDate);
            });

            if (isReserved) {
                dayElement.classList.add("reserved");
            }

            daysContainer.appendChild(dayElement);
        }

        // Réinitialiser la classe "selected" pour les jours sélectionnés
        daysContainer.querySelectorAll(".day.selected").forEach(day => day.classList.remove("selected"));

        // Rétablir les dates sélectionnées
        selectedDates.forEach(date => {
            if (date.getMonth() === currentMonth && date.getFullYear() === currentYear) {
                const dayNumber = date.getDate();
                const dayElement = daysContainer.querySelector(`.day:not(.empty):nth-child(${dayNumber + firstDayIndex})`);
                if (dayElement) {
                    dayElement.classList.add("selected");
                }
            }
        });
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
        selectedDates = [];
        updateCalendar([]);
    });

    nextBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        selectedDates = [];
        updateCalendar([]);
    });

    updateCalendar([]);

});
