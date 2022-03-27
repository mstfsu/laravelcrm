!function (a) {
    a.fn.daterangepicker.locale = {
        "format": "YYYY-MM-DD",
        "separator": " / ",
        "applyLabel": "Kaydet",
        "cancelLabel": "İptal",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
           "Pz", "Pzt", "Sal", "Çrş", "Prş", "Cu", "Cts"
        ],
        "monthNames": [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık"
        ],
        "firstDay": 1
    }

    a.fn.daterangepicker.ranges = {
        'Son 7 gün': [moment().subtract('days', 6), moment()],
        'Son 30 gün': [moment().subtract('days', 29), moment()],
        'Bu ay': [moment().startOf('month'), moment().endOf('month')],
        'Geçen ay': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    }

}(jQuery);