!function (a) {
    a.fn.daterangepicker.locale = {
        "format": "YYYY-MM-DD",
        "separator": " / ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    }

    a.fn.daterangepicker.ranges = {
        'This hour': [moment(), moment().add(-1, 'day')],
        'Today': [moment(), moment()],
        'Yesterday': [moment().add(-1, 'day'), moment().add(-1, 'day')],
        'This week': [moment().startOf('week'), moment().endOf('week')],
        'Last week': [moment().add(-1, 'week').startOf('week'), moment().add(-1, 'week').endOf('week')],
        'This month': [moment().startOf('month'), moment().endOf('month')],
        'Last month': [moment().add(-1, 'month').startOf('month'), moment().add(-1, 'month').endOf('month')],
        'This year': [moment().startOf('year'), moment().endOf('year')]
    }

}(jQuery);