// **------ mixed_chart 1**
var options = {
    series: [
        {
            name: "Website Blog",
            type: "column",
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
        },
        {
            name: "Social Media",
            type: "line",
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
        },
    ],
    chart: {
        height: 350,
        type: "line",
    },
    stroke: {
        width: [0, 4],
    },
    title: {
        text: "",
    },
    dataLabels: {
        enabled: true,
        enabledOnSeries: [1],
    },
    labels: [
        "01 Jan 2001",
        "02 Jan 2001",
        "03 Jan 2001",
        "04 Jan 2001",
        "05 Jan 2001",
        "06 Jan 2001",
        "07 Jan 2001",
        "08 Jan 2001",
        "09 Jan 2001",
        "10 Jan 2001",
        "11 Jan 2001",
        "12 Jan 2001",
    ],
    xaxis: {
        type: "datetime",
    },

    colors: [
        getLocalStorageItem("color-primary", "#056464"),
        getLocalStorageItem("color-secondary", "#74788D"),
        "#0FB450",
        "#EA5659",
        "#FAC10F",
    ],
    yaxis: [
        {
            title: {
                text: "",
            },
        },
        {
            opposite: true,
            title: {
                text: "",
            },
        },
    ],
};

var chart = new ApexCharts(document.querySelector("#mixed1"), options);
chart.render();

//  **------ mixed_chart 2 **

var options = {
    series: [
        {
            name: "Income",
            type: "column",
            data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6],
        },
        {
            name: "Cashflow",
            type: "column",
            data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5],
        },
        {
            name: "Revenue",
            type: "line",
            data: [20, 29, 37, 36, 44, 45, 50, 58],
        },
    ],
    chart: {
        height: 350,
        type: "line",
        stacked: false,
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        width: [1, 1, 4],
    },
    title: {
        text: "",
        align: "left",
        offsetX: 110,
    },
    xaxis: {
        categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
    },

    colors: ["#0FB450", "#EA5659", "#fbc152", "#EA5659", "#FAC10F"],
    yaxis: [
        {
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: true,
                color: "#008FFB",
            },
            labels: {
                style: {
                    colors: "#008FFB",
                },
            },
            title: {
                text: "",
                style: {
                    color: "#008FFB",
                },
            },
            tooltip: {
                enabled: true,
            },
        },
        {
            seriesName: "Income",
            opposite: true,
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: true,
                color: "#00E396",
            },
            labels: {
                style: {
                    colors: "#00E396",
                },
            },
            title: {
                text: "",
                style: {
                    color: "#00E396",
                },
            },
        },
        {
            seriesName: "Revenue",
            opposite: true,
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: true,
                color: "#FEB019",
            },
            labels: {
                style: {
                    colors: "#FEB019",
                },
            },
            title: {
                text: "",
                style: {
                    color: "#FEB019",
                },
            },
        },
    ],
    tooltip: {
        fixed: {
            enabled: true,
            position: "topLeft", // topRight, topLeft, bottomRight, bottomLeft
            offsetY: 30,
            offsetX: 60,
        },
    },
    legend: {
        horizontalAlign: "left",
        offsetX: 40,
    },
};

var chart = new ApexCharts(document.querySelector("#mixed2"), options);
chart.render();

//  **------ mixed_chart 3**
var options = {
    series: [
        {
            name: "TEAM A",
            type: "area",
            data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33],
        },
        {
            name: "TEAM B",
            type: "line",
            data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43],
        },
    ],
    chart: {
        height: 350,
        type: "line",
    },
    stroke: {
        curve: "smooth",
    },
    fill: {
        type: "solid",
        opacity: [0.35, 1],
    },

    colors: ["#3C91F3", "#231928"],
    labels: [
        "Dec 01",
        "Dec 02",
        "Dec 03",
        "Dec 04",
        "Dec 05",
        "Dec 06",
        "Dec 07",
        "Dec 08",
        "Dec 09 ",
        "Dec 10",
        "Dec 11",
    ],
    markers: {
        size: 0,
    },
    yaxis: [
        {
            title: {
                text: "",
            },
        },
        {
            opposite: true,
            title: {
                text: "",
            },
        },
    ],
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return y.toFixed(0) + " points";
                }
                return y;
            },
        },
    },
};

var chart = new ApexCharts(document.querySelector("#mixed3"), options);
chart.render();

//  **------mixed_chart 4**
var options = {
    series: [
        {
            name: "Hadir",
            type: "column",
            data: dataHadir,
        },
        {
            name: "Terlambat",
            type: "area",
            data: dataTerlambat,
        },
        {
            name: "Alpha",
            type: "line",
            data: dataAlpha,
        },
    ],
    chart: {
        height: 350,
        type: "line",
        stacked: false,
    },
    stroke: {
        width: [0, 2, 5],
        curve: "smooth",
    },
    plotOptions: {
        bar: {
            columnWidth: "50%",
        },
    },
    fill: {
        opacity: [0.85, 0.25, 1],
        gradient: {
            inverseColors: false,
            shade: "light",
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100],
        },
    },
    labels: labels, // format: ["2025-05-25", ...]
    markers: {
        size: 0,
    },
    xaxis: {
        type: "category",
    },
    colors: [
        getLocalStorageItem("color-primary", "#056464"),
        getLocalStorageItem("color-secondary", "#f0ad4e"),
        "#dc3545",
    ],
    yaxis: {
        title: {
            text: "Jumlah Absensi",
        },
        min: 0,
    },
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return y.toFixed(0) + " orang";
                }
                return y;
            },
        },
    },
};

var chart = new ApexCharts(document.querySelector("#mixed4"), options);
chart.render();
