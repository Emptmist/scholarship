// Fetch data from PHP script
fetch('data.php')
  .then(response => response.json())
  .then(data => {
    // Filter the data to include only Approved, Rejected, and Pending
    const filteredData = data.filter(item => 
      item.c_status === 'Approved' || 
      item.c_status === 'Rejected' || 
      item.c_status === 'Pending'
    );

    const chartData = {
      labels: filteredData.map(item => item.c_status),
      data: filteredData.map(item => item.count),
    };

    const myChart = document.querySelector(".my-chart");
    const ul = document.querySelector(".programming-stats .details ul");

    new Chart(myChart, {
      type: "doughnut",
      data: {
        labels: chartData.labels,
        datasets: [
          {
            data: chartData.data,
            backgroundColor: [
              '#FF6384', // color for Approved
              '#36A2EB', // color for Rejected
              '#FFCE56', // color for Pending
            ],
            borderColor: '#fff', // optional: border color
            borderWidth: 2 // optional: border width
          },
        ],
      },
      options: {
        borderWidth: 10,
        borderRadius: 2,
        hoverBorderWidth: 0,
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    });

    const populateUl = () => {
      chartData.labels.forEach((l, i) => {
        let li = document.createElement("li");
        li.innerHTML = `${l}: <span class='percentage'>${chartData.data[i]}</span>`;
        ul.appendChild(li);
      });
    };

    populateUl();
  })
  .catch(error => console.error('Error fetching data:', error));
