$(function() {
  'use strict';

  $(function() {
    var table = $('#dataTableExample').DataTable({
      buttons: [
        'copy', 'excel', 'csv','colvis'
      ],
    });
    table.buttons().container()
        .appendTo( $('.col-sm-12:eq(0)', table.table().container() ) );
    $('#dataTableExample').each(function() {
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Search');
      search_input.removeClass('form-control-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');

    });

  });
});