$(document).ready(function () {
  $.getJSON("chart_data.php?rand=" + Math.random(), function (data) {
    const labels = data.pie.map((item) => item.category);
    const values = data.pie.map((item) => item.total);

    const ctx = document.getElementById("myPieChart");
    if (!ctx) return;

    new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [
          {
            data: values,
            backgroundColor: [
              "#4e73df",
              "#1cc88a",
              "#36b9cc",
              "#f6c23e",
              "#e74a3b",
            ],
            hoverBackgroundColor: [
              "#2e59d9",
              "#17a673",
              "#2c9faf",
              "#d4a017",
              "#be2617",
            ],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: "#dddfeb",
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: true,
          caretPadding: 10,
        },
        legend: {
          display: true,
        },
        cutoutPercentage: 70,
      },
    });
  });
});
