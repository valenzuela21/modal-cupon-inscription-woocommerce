(function($){
       var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
        } );

        table.buttons().container()
            .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
})(jQuery)