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
        'Son saat': [moment(), moment().add(-1, 'day')],
        'Bugün': [moment(), moment()],
        'Dün': [moment().add(-1, 'day'), moment().add(-1, 'day')],
        'Bu hafta': [moment().startOf('week'), moment().endOf('week')],
        'Geçen hafta': [moment().add(-1, 'week').startOf('week'), moment().add(-1, 'week').endOf('week')],
        'Bu ay': [moment().startOf('month'), moment().endOf('month')],
        'Geçen ay': [moment().add(-1, 'month').startOf('month'), moment().add(-1, 'month').endOf('month')],
        'Bu yıl': [moment().startOf('year'), moment().endOf('year')]
    }

}(jQuery);