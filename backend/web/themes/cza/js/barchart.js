/*
* 柱状图统计
* */
//柱状图实例
$(function(){
    /*
     * BAR CHART
     * ---------
     */
    var bar_data = {
        data: [["2017-06-10", 10], ["2017-06-09", 8], ["2017-06-08", 4], ["2017-06-07", 13], ["2017-06-06", 17], ["2017-06-05", 9]],
        color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
        grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3"
        },
        series: {
            bars: {
                show: true,
                show: true,
                barWidth: 0.3,
                align: "center"
            }
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        }
    });
    /* END BAR CHART */
});

