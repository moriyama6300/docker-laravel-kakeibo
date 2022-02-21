import "chart.js";

(function() {
    "use strict";
    window.make_chart = function make_chart(id, labels, data, title) {
        var type = "doughnut";

        let labelNames = [];
        let labelColors = [];
        for (let i = 0; i < labels.length; i++) {
            labelNames.push(labels[i]["name"]);
            labelColors.push(labels[i]["color"]);
        }

        var data = {
            labels: labelNames,
            datasets: [
                {
                    data: data,
                    backgroundColor: labelColors
                }
            ]
        };

        var options = {
            title: {
                display: true,
                text: title,
                fontSize: 20
            },
            legend: {
                display: true
            },
            cutoutPercentage: 40,
            plugins: {
                labels: {
                    render: "value",
                    position: "default",
                    fontSize: 10,
                    fontColor: "black"
                }
            }
        };

        var ctx = document.getElementById("my_chart").getContext("2d");

        var myChart = new Chart(ctx, {
            type: type,
            data: data,
            options: options
        });
    };
})();
