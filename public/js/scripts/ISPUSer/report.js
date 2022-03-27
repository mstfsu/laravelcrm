/// <reference path="../../assets/global/plugins/jquery-1.11.0-vsdoc.js" />

var Reports = function () {

    //dom fields


    var reportContainer = $('#reportcontainer');
    var reportTag = $('#reporttag');
    var   rangePickr = $('.flatpickr-range');
    var reportTable = $('#reporttable');
    var dateranger = $('#dashboard-report-range');
    var reportType=$('#report_type');
    var pageType = $('#pageType');
    var startdate;
    var finishdate;

    //global vars
    var l =1;//lang.reports.index;

    var dateRanges = { last_hour: "Last hour", today: "Today", yesterday: "Yesterday", this_week: "This week", last_week: "Last week", this_month: "This month", last_month: "Last month", this_year: "This year" };

    var currentLang;

    var selectedReportName = "";
    var datepickerVal = dateRanges.today;
    var timeInterval = "";
    var topLenght = 30;
    var appName = [];
    var ReportsNames = [];
    var drillSelect = "";
    var isDDReport = false;
    var repData = "";

    var lastSelectedDrillUser = "";
    var lastSelectedDrillOptions = "";
    var lastValueDrillUser = "";


    Number.prototype.formatNumber = function (places, symbol, thousand, decimal) {
        places = !isNaN(places = Math.abs(places)) ? places : 0;
        symbol = symbol !== undefined ? symbol : "";
        thousand = thousand || ".";
        decimal = decimal || ",";
        var number = this,
            negative = number < 0 ? "-" : "",
            i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
    };
    Number.prototype.formatSize = function (type) {

        var size = this;
        var opts = 0;
        var i;
        i = Math.floor(Math.log(size) / Math.log(1024));
        if ((size === 0) || (parseInt(size) === 0)) {
            return "0 kB";
        } else if (isNaN(i) || (!isFinite(size)) || (size === Number.POSITIVE_INFINITY) || (size === Number.NEGATIVE_INFINITY) || (size == null) || (size < 0)) {
            console.info("Throwing error");
            throw Error("" + size + " did not compute to a valid number to be humanized.");
        } else {
            if (type == "a") {
                return ["B", "kB", "MB", "GB", "TB", "PB"][i];
            }
            if (type == "b") {
                return (size / Math.pow(1024, i)).toFixed(2) * 1;
            }
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + " " + ["B", "kB", "MB", "GB", "TB", "PB"][i];
        }

    }
    Number.prototype.formatBandSize = function (type) {

        var size = this;
        var opts = 0;
        var i;
        i = Math.floor(Math.log(size) / Math.log(1000));
        if ((size === 0) || (parseInt(size) === 0)) {
            return "--";
        } else if (isNaN(i) || (!isFinite(size)) || (size === Number.POSITIVE_INFINITY) || (size === Number.NEGATIVE_INFINITY) || (size == null) || (size < 0)) {
            console.info("Throwing error");
            return 0;
        } else {

            if (type == "a") {
                return ["bps", "Kbit/s", "Mbit/s", "Gbit/s", "Tbit/s", "Pbit/s"][i];
            }
            if (type == "b") {
                if (i <= 1) {
                    return Math.round(size / Math.pow(1000, i));
                }
                return (size / Math.pow(1000, i)).toFixed(2) * 1;
            }
            if (i <= 1) {
                return Math.round(size / Math.pow(1000, i)) + " " + ["bps", "Kbit/s", "Mbit/s", "Gbit/s", "Tbit/s", "Pbit/s"][i];
            }
            return (size / Math.pow(1000, i)).toFixed(2) * 1 + " " + ["bps", "Kbit/s", "Mbit/s", "Gbit/s", "Tbit/s", "Pbit/s"][i];

        }

    }
    Number.prototype.formatSizeStatic = function (type) {
        var size = this;
        switch (type) {
            case "B":
                return size;
            case "kB":
                return (size * (1 / Math.pow(1024, 1))).toFixed(2);
            case "MB":
                return (size * (1 / Math.pow(1024, 2))).toFixed(2);
            case "GB":
                return (size * (1 / Math.pow(1024, 3))).toFixed(2);
            case "TB":
                return (size * (1 / Math.pow(1024, 4))).toFixed(2);
            case "PB":
                return (size * (1 / Math.pow(1024, 5))).toFixed(2);
            default:
                return 0;
        }
    }
    $('body').on('change', '#report_type', function () {
        getReportData()


    });
 var habdletabs =   function () {
        //activate tab if tab id provided in the URL
        if (location.hash) {
            var tabid = encodeURI(location.hash.substr(1));
            $('a[href="#' + tabid + '"]').parents('.tab-pane:hidden').each(function () {
                var tabid = $(this).attr("id");
                $('a[href="#' + tabid + '"]').click();
            });
            $('a[href="#' + tabid + '"]').click();
        }

        if ($().tabdrop) {
            $('.tabbable-tabdrop .nav-pills, .tabbable-tabdrop .nav-tabs').tabdrop({
                text: '<i class="fa fa-ellipsis-v"></i>&nbsp;<i class="fa fa-angle-down"></i>'
            });
        }
    }
    function toDateRange(dRange) {

        dateRange = dateRanges.last_hour;

        switch (dRange) {
            case "This hour":
            case "Son saat":
                dateRange = dateRanges.last_hour;
                break;
            case "Today":
            case "Bugün":
                dateRange = dateRanges.today;
                break;
            case "Yesterday":
            case "Dün":
                dateRange = dateRanges.yesterday;
                break;
            case "This week":
            case "Bu hafta":
                dateRange = dateRanges.this_week;
                break;
            case "Last week":
            case "Geçen hafta":
                dateRange = dateRanges.last_week;
                break;
            case "This month":
            case "Bu ay":
                dateRange = dateRanges.this_month;
                break;
            case "Last month":
            case "Geçen ay":
                dateRange = dateRanges.last_month;
                break;
            case "This year":
            case "Bu yıl":
                dateRange = dateRanges.this_year;
                break;
            default:
                dateRange = dateRanges.last_hour;
        }

        return dateRange;
    }


    function getCookie(cname) {
        var name = cname + "=";
        var ca = 1
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function getReportData() {

        isDDReport = false;

        var username=$('#username').val();
        var report=reportType.val()
        Metronic.blockUI({
            target: reportContainer,
            animate: false,
            boxed: true,
            message: "Loading..."
        });

        if (topLenght == "") {
            topLenght = 10;
        }
        $.ajax({
            async: true,
            type: 'GET',
            url: '/ISP/getReports',
            data: { startdate:startdate,finishdate:finishdate ,username:username,report:report  },
            dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                console.log(data)
                data = data;

                Metronic.unblockUI(reportContainer);
                reportTag.text(selectedReportName);


                Reports.initBarCharts(data);
                Reports.initPieCharts(data);

            },
            error: function (data) {
                console.log(data)
                data = [];

                Metronic.unblockUI(reportContainer);
                reportTag.text(selectedReportName);


                Reports.initBarCharts(data);
                Reports.initPieCharts(data);
            }
        });

    }





    return {

        //main function
        init: function () {

            // Metronic.handleLangFields(l);

            currentLang = 1

            getReportData();
            Metronic.addResizeHandler(function () {
                Reports.initPieCharts();
            });




        },



        initBarCharts: function (data) {

            var type = "";
            var title = "";
            var datad = [];
            var maxSizeFormat = "";

            if (data != undefined) {

                if (data != "") {



                    $.each(data[0], function (key) {
                        type = key;

                    });

                    if (type == "totalBandwidth") {
                        maxSizeFormat = (data[0].totalBandwidth).formatSize('a');

                    }
                    if (type == "Download") {
                        maxSizeFormat = parseFloat(data[0].Download).formatSize('a');

                    }

                    else  if (type == "Upload") {
                        maxSizeFormat = parseFloat(data[0].Upload).formatSize('a');

                    }

                    title = selectedReportName;
                    var axiscounter = 0;
                    $.each(data, function (key, value) {

                        var a = "";
                        var b = "";

                        var counter = 0;
                        for (var key in value) {

                            if (counter == 0) {
                                a = value[key];
                                if (a == null) {
                                    a = "null";
                                }
                            }
                            if (counter == 1) {
                                counter = 0;
                                if (type == "totalBandwidth") {
                                    b = parseFloat(value[key]).formatSizeStatic(maxSizeFormat);

                                }
                                else  if (type == "Download") {
                                    b = parseFloat(value[key]).formatSizeStatic(maxSizeFormat);

                                }
                                else if (type == "Upload") {
                                    b = parseFloat(value[key]).formatSizeStatic(maxSizeFormat);

                                }

                                else {
                                    b = value[key];
                                }

                            }
                            counter++;

                        }

                        datad.push({ "category": a, "column-1": b, "color": "#7AADc5" });
                        axiscounter++;
                    });

                    data = datad;
                    axiscounter = 0;
                }
                else {
                    data = [];
                }

            }
            else {
                data = [];
            }


            var chart = AmCharts.makeChart("chartbardiv", {
                "type": "serial",
                "categoryField": "category",
                "startDuration": 1,
                "trendLines": [],
                "fontSize": 10,
                "categoryAxis": {
                    "gridPosition": "start",
                    "labelsEnabled": true,
                    "autoWrap": true,
                },
                "chartCursor": {
                    "enabled": true,
                    "cursorColor": "#F3565D"
                },
                "graphs": [
                    {
                        "showBalloon": false,
                        //"balloonText": "[[category]]:[[value]]" + " " + showtype + "",
                        "fillAlphas": 2,
                        "id": "AmGraph-1",
                        "type": "column",
                        "valueField": "column-1",
                        "lineColorField": "color",
                        "colorField": "color"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                        "title": ""
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "legend": {
                    "enabled": false,
                    "useGraphSettings": true
                },
                "dataProvider": data
            });

            chart.addListener("rollOverGraphItem", function (event) {
                var b = document.getElementById("balloon");
                if (type == "totalBandwidth") {
                    b.innerHTML = event.item.category + ": <b>" + event.item.values.value + " " + maxSizeFormat + "</b>";
                }
                else  if (type == "Upload") {
                    b.innerHTML = event.item.category + ": <b>" + event.item.values.value + " " + maxSizeFormat + "</b>";
                }
                else  if (type == "Download") {
                    b.innerHTML = event.item.category + ": <b>" + event.item.values.value + " " + maxSizeFormat + "</b>";
                }
                else {
                    b.innerHTML = event.item.category + ": <b>" + (event.item.values.value).formatNumber() + "</b>";
                }

                b.style.display = "block";
            });

            chart.addListener("rollOutGraphItem", function (event) {
                var b = document.getElementById("balloon");
                b.style.display = "none";
            });

            // For the clarity of code we're going to use jQuery to track mouse movement
            // To implement a mouse tracking solution with plain JavaScript please see this thread:
            // http://stackoverflow.com/questions/7790725/javascript-track-mouse-position
            $("#chartbardiv").mousemove(function (event) {
                var b = document.getElementById("balloon");
                b.style.top = event.pageY + 'px';
                b.style.left = event.pageX + 'px';
            });


            AmCharts.checkEmptyData = function (chart) {

                if (0 == chart.dataProvider.length) {
                    // set min/max on the value axis
                    chart.valueAxes[0].minimum = 0;
                    chart.valueAxes[0].maximum = 100;

                    // add dummy data point
                    var dataPoint = {
                        dummyValue: 0
                    };
                    dataPoint[chart.categoryField] = '';
                    chart.dataProvider = [dataPoint];

                    // add label
                    chart.addLabel(0, '50%','Chart contain no data', 'center', 15);

                    // set opacity of the chart div
                    chart.chartDiv.style.opacity = 0.5;

                    // redraw it
                    chart.validateNow();
                }

            }

            AmCharts.checkEmptyData(chart);

        },

        initPieCharts: function (data) {

            var type = "";
            var title = "";
            var datad = [];
            var maxSizeFormat = "";

            if (data != undefined) {

                if (data != "") {

                    $.each(data[0], function (key) {
                        type = key;
                    });

                    if (type == "totalBandwidth") {
                        maxSizeFormat = parseFloat(data[0].totalBandwidth).formatSize('a');

                    }
                    if (type == "Download") {
                        maxSizeFormat = parseFloat(data[0].Download).formatSize('a');

                    }
                    if (type == "Upload") {
                        maxSizeFormat = parseFloat(data[0].Upload).formatSize('a');

                    }


                    title = selectedReportName;
                    var axiscounter = 0;
                    $.each(data, function (key, value) {

                        var a = "";
                        var b = "";

                        var counter = 0;
                        for (var key in value) {

                            if (counter == 0) {
                                a = value[key];
                                if (a == null) {
                                    a = "null";
                                }
                            }
                            if (counter == 1) {
                                counter = 0;
                                if (type == "totalBandwidth") {
                                    b =parseFloat (value[key]).formatSizeStatic(maxSizeFormat);

                                }
                                else    if (type == "Download") {
                                    b = parseFloat(value[key]).formatSizeStatic(maxSizeFormat);

                                }
                                else   if (type == "Upload") {
                                    b = parseFloat(value[key]).formatSizeStatic(maxSizeFormat);

                                }
                                else {
                                    b = value[key];
                                }

                            }
                            counter++;

                        }

                        datad.push({ "category": a, "column-1": b });


                        axiscounter++;
                    });

                    data = datad;
                    axiscounter = 0;
                }
                else {
                    data = [];
                }

            }
            else {
                data = [];
            }

            var chart = AmCharts.makeChart("chartpiediv", {
                "type": "pie",
                "theme": "light",
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]] " + maxSizeFormat + " </b> ([[percents]]%)</span>",
                "titleField": "category",
                "valueField": "column-1",
                "allLabels": [],
                "balloon": {},
                "legend": {
                    "enabled": false,
                    "align": "center",
                    "markerType": "circle"
                },
                "titles": [],
                "dataProvider": data
            });

            AmCharts.addInitHandler(function (chart) {

                // check if data is mepty
                if (chart.dataProvider === undefined || chart.dataProvider.length === 0) {
                    // add some bogus data
                    var dp = {};
                    dp[chart.titleField] = "";
                    dp[chart.valueField] = 1;
                    chart.dataProvider.push(dp)

                    var dp = {};
                    dp[chart.titleField] = "";
                    dp[chart.valueField] = 1;
                    chart.dataProvider.push(dp)

                    var dp = {};
                    dp[chart.titleField] = "";
                    dp[chart.valueField] = 1;
                    chart.dataProvider.push(dp)

                    // disable slice labels
                    chart.labelsEnabled = false;

                    // add label to let users know the chart is empty
                    chart.addLabel("50%", "50%", 'The chart Contains No Data', "middle", 15);

                    // dim the whole chart
                    chart.alpha = 0.3;
                }

            }, ["pie"]);

        },

        initDashboardDaterange: function () {
            if (rangePickr.length) {
                rangePickr.flatpickr({
                    mode: 'range',
                    dateFormat: "Y-m-d",
                    altFormat: "Y-m-d",
                    defaultDate: [new Date(), new Date()],
                    onClose: function (selectedDates, dateStr, instance) {
                        var _this=this;
                        console.log(selectedDates);
                        var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'d-m-Y');});
                        startdate=dateArr[0];
                        finishdate=dateArr[1];
                        getReportData();
                    },
                    onReady: function (selectedDates, dateStr, instance) {
                        var _this=this;

                        var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'d-m-Y');});
                        startdate=dateArr[0];
                        finishdate=dateArr[1];

                    }

                    });
            }
            if (!jQuery().daterangepicker) {
                return;
            }

            dateranger.daterangepicker({


                    startDate: moment(),
                    endDate: moment(),
                    showDropdowns: false,
                    showWeekNumbers: false,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: false,
                    locale: $.fn.daterangepicker.locale,
                    ranges: $.fn.daterangepicker.ranges,
                    buttonClasses: ['btn btn-sm'],
                    applyClass: ' blue',
                    cancelClass: 'default',
                    format: "DD.MM.YYYY",
                    separator: ' to ',
                },
                function (start, end) {
                   $('#dashboard-report-range span').html(start. format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            );
            var selectorhtml = "<span style='margin-left: 7px; top: 0px; padding:0.2em 1.6em 0.3em; ' class='label label-info'> Today </span>";

            $('#dashboard-report-range span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY') + selectorhtml);
            dateranger.show();

            //change picker val
            dateranger.on('apply.daterangepicker', function (ev, picker) {
 
                datepickerVal = toDateRange(picker.chosenLabel);

                var selectorhtml = "<span style='margin-left: 7px; top: 0px; padding:0.2em 1.6em 0.3em; ' class='label label-info'> " + picker.chosenLabel + " </span>";
                $('#dashboard-report-range span span').remove();
              $('#dashboard-report-range span').append(selectorhtml);

                dateranger.show();
                    getReportData();

            });

        }

    };

}();

jQuery(document).ready(function () {
 // init metronic core componets


});
