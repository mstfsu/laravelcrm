var dtIndexTable = $('.users-list-table'),
function  initindexusersTable() {
    var table = dtIndexTable.dataTable({
        processing: true,
        serverSide: true,
        buttons: [

        ],
        dom:
            '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
            '<"col-lg-12 col-xl-6" l>' +
            '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',

        // Buttons with Dropdown

        ajax: {
            url: "/ISP/users/get_online_users",
            data  : {

                owner: $('#owner_filter').val()
            }

        },
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,

            },

            {
                data: 'username',
                name: 'username',


            },
            {
                data: 'fullname',
                name: 'fullname',
                orderable: true,


            },
            {
                data: 'email',
                name: 'email',
                orderable: true,


            },

            {
                data: 'plan',
                name: 'profiles.srvname',
                orderable: true,


            },
            {
                data: 'owner',
                name: 'owners.name',
                orderable: true,
                "searchable": false,


            },
            {
                data: 'mac',
                name: 'isonline.callingstationid',
                orderable: true,



            },
            {
                data: 'vendor',
                name: 'vendor',
                orderable: true,
                "searchable": false


            },
            {
                data: 'ip',
                name: 'isonline.framedipaddress',
                orderable: true,


            },
            {
                data: 'nasportid',
                name: 'isonline.nasportid',
                orderable: true,
                "searchable": false


            },
            {
                data: 'nasipaddress',
                name: 'isonline.nasipaddress',
                orderable: true,
                "searchable": false



            },
            {
                data: 'starttime',
                name: 'starttime',
                orderable: true,
                "searchable": false


            },



            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: "25%"
            }




        ],


        drawCallback: function( settings ) {
            feather.replace()
        },
        language: {
            paginate: {
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },

    });
}