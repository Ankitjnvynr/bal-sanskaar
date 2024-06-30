

$(document).ready(function () {
    let table = new DataTable('#myTable', {
        // dom: 'Bfrtip',
        // buttons: [
        //      'excel', 'pdf',
        //     {
        //         extend: 'print',
        //         text: 'Print'
        //     }
        // ]
    });
});

// $(document).ready(function () {
//     var table = $('#myTable').dataTable();
//     var tableTools = new $.fn.dataTable.TableTools(table, {
//         "buttons": [
//             "copy",
//             "csv",
//             "xls",
//             "pdf",
//             { "type": "print", "buttonText": "Print me!" }
//         ]
//     });

//     $(tableTools.fnContainer()).insertAfter('div.info');
// });