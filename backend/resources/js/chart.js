import "chart.js";

(function () {
    "use strict";
    window.make_chart = function make_chart(id, lavels, data, title) {
        var type = "doughnut";

        var data = {
            // labels: ['住居費', '水道光熱費', '通信費', '食費', '娯楽費', '日用品費', '保険料', 'その他'],
            labels: lavels,
            datasets: [
                {
                    data: data,
                    backgroundColor: [
                        "coral",
                        "steelblue",
                        "gold",
                        "forestgreen",
                        "pink",
                        "orange",
                        "lightskyblue",
                        "lavender",
                    ],
                },
            ],
        };

        var options = {
            title: {
                display: true,
                text: title,
                fontSize: 20,
            },
            legend: {
                display: true,
            },
            cutoutPercentage: 40,
            plugins: {
                labels: {
                    render: "value",
                    position: "default",
                    fontSize: 10,
                    fontColor: "black",
                },
            },
        };

        var ctx = document.getElementById("my_chart").getContext("2d");

        var myChart = new Chart(ctx, {
            type: type,
            data: data,
            options: options,
        });
    };
})();
