$(document).ready(function () {
  $.getJSON("chart_data.php?rand=" + Math.random(), function (data) {
    const labels = data.area.map((item) => item.date);
    const values = data.area.map((item) => item.total);

    const ctx = document.getElementById("myAreaChart");
    if (!ctx) return;

    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Bookings",
            data: values,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "#4e73df",
            pointBackgroundColor: "#4e73df",
            pointBorderColor: "#4e73df",
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { grid: { display: false } },
          y: { beginAtZero: true },
        },
        plugins: {
          legend: { display: false },
        },
      },
    });
  });
});
