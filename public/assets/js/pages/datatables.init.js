/******/ (function() { // webpackBootstrap
/*!***********************************************!*\
  !*** ./resources/js/pages/datatables.init.js ***!
  \***********************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/
$(document).ready(function () {
  $('#datatable').DataTable(); //Buttons examples

  var isLandscapeExport = $('#datatable-buttons').data('export-landscape') === true;
  var table = $('#datatable-buttons').DataTable({
    lengthChange: false,
    buttons: isLandscapeExport ? [{
      extend: 'excelHtml5',
      text: 'Excel',
      customize: function (xlsx) {
        var worksheet = xlsx.xl.worksheets['sheet1.xml'];
        $('worksheet', worksheet).append('<pageSetup orientation="landscape" paperSize="9"/>');
      }
    }, {
      extend: 'pdfHtml5',
      text: 'PDF',
      orientation: 'landscape',
      pageSize: 'LEGAL'
    }] : ['copy', 'excel', 'pdf', 'colvis']
  });
  table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
  $(".dataTables_length select").addClass('form-select form-select-sm');
});
/******/ })()
;