// chart-area-demo.js
$.getJSON("chart_data.php?rand=" + Math.random(), function (data) {
  const labels = data.area.map((item) => item.date);
  const values = data.area.map((item) => item.total);

  const ctx = document.getElementById("myAreaChart").getContext("2d");

  new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Bookings",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "#4e73df",
          pointRadius: 3,
          pointBackgroundColor: "#4e73df",
          pointBorderColor: "#4e73df",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "#4e73df",
          pointHoverBorderColor: "#4e73df",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: values,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      scales: {
        x: { grid: { display: false } },
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
          },
        },
      },
      plugins: {
        legend: { display: false },
      },
    },
  });
});
