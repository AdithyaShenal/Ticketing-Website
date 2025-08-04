$.getJSON("chart_data.php?rand=" + Math.random(), function (data) {
  const labels = data.pie.map((item) => item.category);
  const values = data.pie.map((item) => item.total);

  const ctx = document.getElementById("myPieChart").getContext("2d");

  new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels,
      datasets: [
        {
          data: values,
          backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc"],
          hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf"],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "rgb(255,255,255)",
          bodyColor: "#858796",
          borderColor: "#dddfeb",
          borderWidth: 1,
          padding: 15,
          displayColors: false,
          caretPadding: 10,
        },
      },
      cutout: "80%",
    },
  });
});
