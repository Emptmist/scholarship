const daysContainer = document.querySelector(".days");
const nextBtn = document.querySelector(".next-btn");
const prevBtn = document.querySelector(".prev-btn");
const month = document.querySelector(".month");
const todayBtn = document.querySelector(".today-btn");

const months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

let currentDate = new Date(); // Current date object
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

let highlightedDates = []; // Array to hold highlighted start dates
let highlightedEndDates = []; // Array to hold highlighted end dates
let selectedDates = []; // Array to hold user-selected dates

function fetchHighlightedDates(filter) {
  fetch(`fetch_scholarships_date.php?filter=${filter}`)
    .then(response => response.json())
    .then(data => {
      highlightedDates = data.dates.map(dateString => new Date(dateString));
      highlightedEndDates = data.end_dates.map(dateString => new Date(dateString));
      renderCalendar();
    })
    .catch(error => console.error('Error fetching dates:', error));
}

function renderCalendar() {
  // Update month and year display
  month.textContent = `${months[currentMonth]} ${currentYear}`;

  const firstDay = new Date(currentYear, currentMonth, 1).getDay();
  const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();
  const prevLastDay = new Date(currentYear, currentMonth, 0).getDate();
  const nextDays = 7 - new Date(currentYear, currentMonth + 1, 0).getDay() - 1;

  let daysHTML = "";

  // Add days from the previous month
  for (let x = firstDay; x > 0; x--) {
    daysHTML += `<div class="day prev">${prevLastDay - x + 1}</div>`;
  }

  // Add days for the current month
  for (let i = 1; i <= lastDay; i++) {
    const currentDateToCheck = new Date(currentYear, currentMonth, i);
    const isStartHighlighted = highlightedDates.some(date => 
      date.getDate() === currentDateToCheck.getDate() &&
      date.getMonth() === currentDateToCheck.getMonth() &&
      date.getFullYear() === currentDateToCheck.getFullYear()
    );
    const isEndHighlighted = highlightedEndDates.some(date => 
      date.getDate() === currentDateToCheck.getDate() &&
      date.getMonth() === currentDateToCheck.getMonth() &&
      date.getFullYear() === currentDateToCheck.getFullYear()
    );
    const isSelected = selectedDates.includes(i);

    if (i === currentDate.getDate() && currentMonth === currentDate.getMonth() && currentYear === currentDate.getFullYear()) {
      daysHTML += `<div class="day today" data-day="${i}">${i}</div>`;
    } else if (isEndHighlighted) {
      daysHTML += `<div class="day end-highlight" data-day="${i}">${i}</div>`;
    } else if (isStartHighlighted) {
      daysHTML += `<div class="day start-highlight" data-day="${i}">${i}</div>`;
    } else if (isSelected) {
      daysHTML += `<div class="day highlight" data-day="${i}">${i}</div>`;
    } else {
      daysHTML += `<div class="day" data-day="${i}">${i}</div>`;
    }
  }

  // Add days from the next month
  for (let j = 1; j <= nextDays; j++) {
    daysHTML += `<div class="day next">${j}</div>`;
  }

  daysContainer.innerHTML = daysHTML;
  hideTodayBtn();
}

function hideTodayBtn() {
  if (currentMonth === currentDate.getMonth() && currentYear === currentDate.getFullYear()) {
    todayBtn.style.display = "none";
  } else {
    todayBtn.style.display = "flex";
  }
}

nextBtn.addEventListener("click", () => {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  fetchHighlightedDates('month');
});

prevBtn.addEventListener("click", () => {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  fetchHighlightedDates('month');
});

todayBtn.addEventListener("click", () => {
  currentMonth = currentDate.getMonth();
  currentYear = currentDate.getFullYear();
  fetchHighlightedDates('month');
});

daysContainer.addEventListener("click", function(event) {
  const clickedDay = event.target.closest(".day");

  if (clickedDay && !clickedDay.classList.contains("prev") && !clickedDay.classList.contains("next")) {
    const dayNumber = parseInt(clickedDay.dataset.day);

    const index = selectedDates.indexOf(dayNumber);
    if (index === -1) {
      selectedDates.push(dayNumber);
      clickedDay.classList.add("highlight");
    } else {
      selectedDates.splice(index, 1);
      clickedDay.classList.remove("highlight");
    }

    console.log("Selected Dates:", selectedDates);
  }
});

document.addEventListener("DOMContentLoaded", () => {
  fetchHighlightedDates('month');
  renderCalendar();

  const formattedDate = `${months[currentDate.getMonth()]} ${currentDate.getDate()}, ${currentDate.getFullYear()}`;
  document.getElementById('currentDate').textContent = formattedDate;
});





// code for current datesue
//document.addEventListener("DOMContentLoaded", function() {
//  // Get the current date
//  const currentDate = new Date();
//
//  // Array of month names
//  const monthNames = [
//      "January", "February", "March", "April", "May", "June", "July",
//      "August", "September", "October", "November", "December"
//  ];
//
//  // Format the date as "Month, Date, Year"
//  const formattedDate = `${monthNames[currentDate.getMonth()]} ${currentDate.getDate()}, ${currentDate.getFullYear()}`;
//
//  // Display the formatted date on the webpage
//  document.getElementById('currentDate').textContent = formattedDate;
//});


//code for notifier reminder under calendar
document.addEventListener("DOMContentLoaded", function() {
  function formatDate(date) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return date.toLocaleDateString(undefined, options);
  }

  function formatTime(date) {
      const options = { hour: 'numeric', minute: 'numeric', hour12: true };
      return date.toLocaleTimeString(undefined, options);
  }

  function updateTodayContent() {
      const now = new Date();
      document.getElementById('today-date').innerText = now.getDate();
      document.getElementById('today-day').innerText = now.toLocaleDateString(undefined, { weekday: 'long' });
      document.getElementById('today-time').innerText = formatTime(now);

      fetchScholarships('today', function(data) {
          document.getElementById('today-scholarships').innerHTML = formatScholarshipData(data);
      });
  }

  function updateWeekContent() {
    fetchScholarships('week', function(data) {
        const weekScholarshipsElement = document.getElementById('week-scholarships');
        
        if (data.data === 'No scholarships found for this week.') {
            weekScholarshipsElement.innerHTML = `<div class="notif-con p-2 border rounded">${data.data}</div>`;
        } else {
            weekScholarshipsElement.innerHTML = formatScholarshipData(data);
        }
    });
  }

  function updateMonthContent() {
      fetch('fetch_scholarships_date.php?filter=month')
          .then(response => response.json())
          .then(data => {
              if (data.start && data.end) {
                  document.getElementById('month-scholarships').innerHTML = formatScholarshipData(data);
              }
          })
          .catch(error => console.error('Error fetching month data:', error));
  }

  function formatScholarshipData(data) {
      let content = '';
      if (Array.isArray(data.data)) {
          data.data.forEach(item => {
              content += `<div class="notif-con p-2 border rounded">
                              <div class="row">
                                  <div class="col-md-12 font-weight-bold">${item.scholarship_name}</div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">${item.start_date} - ${item.end_date}</div>
                              </div>
                              <br>
                          </div>`;
          });
      } else {
          content = `<div class="notif-con p-2 border rounded">${data.data}</div>`;
      }
      return content;
  }

  function fetchScholarships(filter, callback) {
      fetch(`fetch_scholarships_date.php?filter=${filter}`)
          .then(response => response.json())
          .then(data => {
              callback(data);
          })
          .catch(error => console.error('Error fetching scholarships:', error));
  }

  document.querySelectorAll('.filter-btn').forEach(button => {
      button.addEventListener('click', function() {
          document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');

          document.querySelectorAll('.content-item').forEach(content => content.classList.add('d-none'));
          const filter = this.getAttribute('data-filter');
          document.querySelector(`.${filter}-content`).classList.remove('d-none');

          if (filter === 'today') {
              updateTodayContent();
          } else if (filter === 'week') {
              updateWeekContent();
          } else if (filter === 'month') {
              updateMonthContent();
          }
      });
  });

  // Initial load
  updateTodayContent();
});
