/**
 * DataTables Basic
 */

$(function () {
  'use strict';

  var dt_advance_table = $('.datatables-advance'),
    dt_payment_table = $('.datatables-payment'),
    dt_pmfunded_table = $('.datatables-pm-funded'),
    dt_nacha_table =  $('.datatables-nacha'),
    dt_index_table = $('.datatables-index'),
    dt_date_table = $('.dt-date'),
    dt_complex_header_table = $('.dt-complex-header'),
    dt_row_grouping_table = $('.dt-row-grouping'),
    dt_multilingual_table = $('.dt-multilingual'),
    assetPath = '../../../app-assets/';

  if ($('body').attr('data-framework') === 'laravel') {
    assetPath = $('body').attr('data-asset-path');
  }

  // DataTable with buttons
  // --------------------------------------------------------------------

  var textDom = '<"card-header border-bottom p-1"<"head-label">><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-8 text-right"<"d-inline-block px-2"f><"d-inline-block"B>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>';
  
  if (dt_advance_table.length) {
    $.ajax({
      data: '',
      url: "/advances/data",
      type: "GET",
      success: function(balanceData){
        // if(empty(balanceData)) {
        //   textDom = '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>';
        // }
        var dt_basic = dt_advance_table.DataTable({
          data: balanceData,
          columns: [
            { data: 'id' },
            { data: 'id' }, // used for sorting so will hide this column
            { data: 'contact_id' },
            { data: 'advance_id' },
            { data: 'business_name' },
            { data: 'full_name' },
            { data: 'payment' },
            { data: 'advance_status' },
            { data: 'id',
            render: function ( data, type, row, meta ) {
              return '<a class="item-details" onclick="showDetail('+data+',\'/advances/\')">' +
                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                ' </a>';
            }
          }
        ],
          columnDefs: [
            /*
            {
              // For Responsive
              className: 'control',
              orderable: false,
              responsivePriority: 2,
              targets: 0
            },
            {
              // For Checkboxes
              targets: 1,
              orderable: false,
              responsivePriority: 3,
              render: function (data, type, full, meta) {
                return (
                  '<div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                  data +
                  '" /><label class="custom-control-label" for="checkbox' +
                  data +
                  '"></label></div>'
                );
              },
              checkboxes: {
                selectAllRender:
                  '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>'
              }
            },
            */
            {
              targets: 1,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 3
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              orderable: false,
              /*
              render: function (data, type, full, meta) {
                return (
                  '<div class="dropdown-menu dropdown-menu-right">' +
                  '<a href="javascript:;" class="dropdown-item">' +
                  feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) +
                  'Details</a>' +
                  '<a href="javascript:;" class="dropdown-item">' +
                  feather.icons['archive'].toSvg({ class: 'font-small-4 mr-50' }) +
                  'Archive</a>' +
                  '<a href="javascript:;" class="dropdown-item delete-record">' +
                  feather.icons['trash-2'].toSvg({ class: 'font-small-4 mr-50' }) +
                  'Delete</a>' +

                  '<a href="javascript:;" class="item-details">' +
                  feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                  ' </a>' +
                  '<a href="javascript:;" class="item-delete">' +
                  feather.icons['trash-2'].toSvg({ class: 'font-small-4' }) +
                  ' </a>' +
                  '<a href="javascript:;" class="item-edit">' +
                  feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                  ' </a>'
                  '<a href="#" class="item-details" onClick="showDetail(this)">' +
                  feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                  ' </a>'
                );       
              }
              */
            }
          ],
          order: [[1, 'desc']],
          dom:
            textDom,
          displayLength: 50,
          lengthMenu: [10, 25, 50, 75, 100],
          buttons: [
            /*
            {
              extend: 'collection',
              className: 'btn btn-outline-secondary dropdown-toggle mr-2',
              text: feather.icons['share'].toSvg({ class: 'font-small-4 mr-50' }) + 'Export',
              buttons: [
                {
                  extend: 'print',
                  text: feather.icons['printer'].toSvg({ class: 'font-small-4 mr-50' }) + 'Print',
                  className: 'dropdown-item',
                  exportOptions: { columns: [3, 4, 5, 6, 7] }
                },
                {
                  extend: 'csv',
                  text: feather.icons['file-text'].toSvg({ class: 'font-small-4 mr-50' }) + 'Csv',
                  className: 'dropdown-item',
                  exportOptions: { columns: [3, 4, 5, 6, 7] }
                },
                {
                  extend: 'excel',
                  text: feather.icons['file'].toSvg({ class: 'font-small-4 mr-50' }) + 'Excel',
                  className: 'dropdown-item',
                  exportOptions: { columns: [3, 4, 5, 6, 7] }
                },
                {
                  extend: 'pdf',
                  text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 mr-50' }) + 'Pdf',
                  className: 'dropdown-item',
                  exportOptions: { columns: [3, 4, 5, 6, 7] }
                },
                {
                  extend: 'copy',
                  text: feather.icons['copy'].toSvg({ class: 'font-small-4 mr-50' }) + 'Copy',
                  className: 'dropdown-item',
                  exportOptions: { columns: [3, 4, 5, 6, 7] }
                }
              ],
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
                $(node).parent().removeClass('btn-group');
                setTimeout(function () {
                  $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                }, 50);
              }
            },
            */
            {
              text: feather.icons['download'].toSvg({ class: 'mr-50 font-small-4' }) + 'Import Records',
              className: 'create-new btn btn-primary',
              attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
              },
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
              }
            }
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return 'Details of ' + data['full_name'];
                }
              }),
              type: 'column',
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                    : '';
                }).join('');
    
                return data ? $('<table class="table"/>').append(data) : false;
              }
            }
          },
          language: {
            paginate: {
              // remove previous & next text from pagination
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });        

      }      
    });
    $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
  }

  if (dt_payment_table.length) {
    $.ajax({
      data: '',
      url: "/payment/details/data",
      type: "GET",
      success: function(paymentData){
          var dt_basic = dt_payment_table.DataTable({
          data: paymentData,
          columns: [
            { data: 'id' },
            { data: 'id' }, // used for sorting so will hide this column
            { data: 'contact_id' },
            { data: 'trans_id' },
            { data: 'advance_id' },
            { data: 'funding_date' },
            { data: 'status' },
            { data: 'balance' },
            { data: 'trans_type' },
            { data: 'id',
            render: function ( data, type, row, meta ) {
              return '<a class="item-details" onclick="showDetail('+data+',\'/payment/details/\')">' +
                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                ' </a>';
            }
          }
        ],
          columnDefs: [
            {
              targets: 1,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 3
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              orderable: false,
            }
          ],
          order: [[1, 'desc']],
          dom:
            textDom,
          displayLength: 50,
          lengthMenu: [10, 25, 50, 75, 100],
          buttons: [
            {
              text: feather.icons['download'].toSvg({ class: 'mr-50 font-small-4' }) + 'Import Records',
              className: 'create-new btn btn-primary',
              attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
              },
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
              }
            }
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return 'Details of ' + data['full_name'];
                }
              }),
              type: 'column',
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                    : '';
                }).join('');
    
                return data ? $('<table class="table"/>').append(data) : false;
              }
            }
          },
          language: {
            paginate: {
              // remove previous & next text from pagination
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });        

      }      
    });
    $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
  }

  if (dt_pmfunded_table.length) {
    $.ajax({
      data: '',
      url: "/pm/funded/data",
      type: "GET",
      success: function(pmfundedData){
          var dt_basic = dt_pmfunded_table.DataTable({
          data: pmfundedData,
          columns: [
            { data: 'id' },
            { data: 'id' }, // used for sorting so will hide this column
            { data: 'contact_id' },
            { data: 'business_name' },
            { data: 'last_name' },
            { data: 'first_name' },
            { data: 'address' },
            { data: 'city' },
            { data: 'state' },
            { data: 'zip_code' },
            { data: 'email' },
            { data: 'cell_phone' },
            { data: 'id',
            render: function ( data, type, row, meta ) {
              return '<a class="item-details" onclick="showDetail('+data+',\'/pm/funded/\')">' +
                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                ' </a> &nbsp; <a class="item-details" onclick="showSyndicateDetail('+data+',\'/pm/funded/\')">' +
                feather.icons['zoom-in'].toSvg({ class: 'font-small-4' });
            }
          }
        ],
          columnDefs: [
            {
              targets: 1,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 3
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              orderable: false,
            }
          ],
          order: [[1, 'desc']],
          dom:
            textDom,
          displayLength: 50,
          lengthMenu: [10, 25, 50, 75, 100],
          buttons: [
            {
              text: feather.icons['download'].toSvg({ class: 'mr-50 font-small-4' }) + 'Import Records',
              className: 'create-new btn btn-primary',
              attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
              },
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
              }
            }
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return 'Details of ' + data['full_name'];
                }
              }),
              type: 'column',
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                    : '';
                }).join('');
    
                return data ? $('<table class="table"/>').append(data) : false;
              }
            }
          },
          language: {
            paginate: {
              // remove previous & next text from pagination
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });        

      }      
    });
    $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
  }

  if (dt_nacha_table.length) {
    $.ajax({
      data: '',
      url: "/nacha/data",
      type: "GET",
      success: function(nachaData){
          var dt_basic = dt_nacha_table.DataTable({
          data: nachaData,
          columns: [
            { data: 'id' },
            { data: 'id' }, // used for sorting so will hide this column
            { data: 'name' },
            { data: 'routing_number' },
            { data: 'account_number' },
            { data: 'amount' },
            { data: 'trans_id' },
            { data: 'trace_number' },
            { data: 'filename' },
            { data: 'id',
            render: function ( data, type, row, meta ) {
              return '<a class="item-details" onclick="showDetail('+data+',\'/nacha/\')">' +
                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                ' </a>';
            }
          }
        ],
          columnDefs: [
            {
              targets: 1,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 3
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              orderable: false,
            }
          ],
          order: [[1, 'desc']],
          dom:
            textDom,
          displayLength: 50,
          lengthMenu: [10, 25, 50, 75, 100],
          buttons: [
            {
              text: feather.icons['download'].toSvg({ class: 'mr-50 font-small-4' }) + 'Import Records',
              className: 'create-new btn btn-primary',
              attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
              },
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
              }
            }
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return 'Details of ' + data['name'];
                }
              }),
              type: 'column',
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                    : '';
                }).join('');
    
                return data ? $('<table class="table"/>').append(data) : false;
              }
            }
          },
          language: {
            paginate: {
              // remove previous & next text from pagination
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });        

      }      
    });
    $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
  }


  if (dt_index_table.length) {
    $.ajax({
      data: '',
      url: "/advances/data",
      type: "GET",
      success: function(balanceData){
        var dt_basic = dt_index_table.DataTable({
          data: balanceData,
          columns: [
            { data: 'id' },
            { data: 'id' }, // used for sorting so will hide this column
            { data: 'contact_id' },
            { data: 'advance_id' },
            { data: 'business_name' },
            { data: 'full_name' },
            { data: 'payment' },
            { data: 'advance_status' },
            { data: 'id',
            render: function ( data, type, row, meta ) {
              return '<a class="item-details" href="/advances/detail/view/id/'+data+'">' +
                feather.icons['file-text'].toSvg({ class: 'font-small-4' }) +
                ' </a>';
            }
          }
        ],
          columnDefs: [
            {
              targets: 1,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 3
            },
            {
              // Actions
              targets: -1,
              title: 'Actions',
              orderable: false,
            }
          ],
          order: [[1, 'desc']],
          dom:
            textDom,
          displayLength: 50,
          lengthMenu: [10, 25, 50, 75, 100],
          buttons: [
            {
              text: feather.icons['download'].toSvg({ class: 'mr-50 font-small-4' }) + 'Import Records',
              className: 'create-new btn btn-primary',
              attr: {
                'data-toggle': 'modal',
                'data-target': '#modals-slide-in'
              },
              init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
              }
            }
          ],
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function (row) {
                  var data = row.data();
                  return 'Details of ' + data['full_name'];
                }
              }),
              type: 'column',
              renderer: function (api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td>' +
                        col.data +
                        '</td>' +
                        '</tr>'
                    : '';
                }).join('');
    
                return data ? $('<table class="table"/>').append(data) : false;
              }
            }
          },
          language: {
            paginate: {
              // remove previous & next text from pagination
              previous: '&nbsp;',
              next: '&nbsp;'
            }
          }
        });        

      }      
    });
    $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
  }


  // Flat Date picker
  if (dt_date_table.length) {
    dt_date_table.flatpickr({
      monthSelectorType: 'static',
      dateFormat: 'm/d/Y'
    });
  }

  // Add New record
  // ? Remove/Update this code as per your requirements ?
  var count = 101;
  $('.data-submit').on('click', function () {
    /*
    var $new_name = $('.add-new-record .dt-full-name').val(),
      $new_post = $('.add-new-record .dt-post').val(),
      $new_email = $('.add-new-record .dt-email').val(),
      $new_date = $('.add-new-record .dt-date').val(),
      $new_salary = $('.add-new-record .dt-salary').val();

    if ($new_name != '') {
      dt_basic.row
        .add({
          responsive_id: null,
          id: count,
          full_name: $new_name,
          post: $new_post,
          email: $new_email,
          start_date: $new_date,
          salary: '$' + $new_salary,
          status: 5
        })
        .draw();
      count++;
      $('.modal').modal('hide');
    }
    */
  });

  /*
  //dt_advance_table
  //.on(  
    // $('.datatables-advance tbody').on('click', '.item-details', function () {
    //   // Mostramos el modal
    //     $('#modal-detail').modal('show');
    // });
    
    $('.datatables-advance tbody').on('click', '.item-details', function(event){
      var project_id = $(this).attr("id");
    }),

    // Delete Record
    $('.datatables-advance tbody').on('click', '.delete-record', function () {
      dt_basic.row($(this).parents('tr')).remove().draw();
    })
  //);
  */

});

function empty(e) {
  switch (e) {
    case "":
    case null:
    case "null":
    case typeof this == "undefined":
      return true;
    default:
      return false;
  }
}

function showDetail(id,prefixUrl)
{
  $.ajax({
    data: '',
    url: prefixUrl+"detail/id/"+id,
    type:"GET",
    success:function(data) {
      var advanceData = data[0];
      var indexName = "", counter = 0;
      var htmlTitle = advanceData.modal_title;
      var htmlBody = '<table class="table">';
      var dateValue;
      $(".modal-title").html(htmlTitle);
      $.each(advanceData, function(index, item) {
        counter++;
        if (index=='updated_at' || index=='created_at') {
          dateValue = new Date(item);
          item = dateValue.getFullYear()+'-'+(dateValue.getMonth()+1)+'-'+dateValue.getDate()+' '+dateValue.getHours()+':'+dateValue.getMinutes()+':'+dateValue.getSeconds();
        }
        indexName = index.replace("_", " ");
        index = indexName.charAt(0).toUpperCase().concat(indexName.substring(1, indexName.length));
        item = empty(item) ? "" : item;
        htmlBody += '<tr data-dt-row="'+advanceData.id+'" data-dt-column="'+counter+'"></tr>';
        htmlBody += '<td>'+index+':</td>';
        htmlBody += '<td>'+item+'</td>';
        htmlBody += '</tr>';
      });
      htmlBody += '</table>';
      $(".modal-body").html(htmlBody);
      $("#modal-detail").modal("show");
    }
  });
}

function showSyndicateDetail(id,prefixUrl)
{
  var htmlBody = "";
  var titleClass = "";
  $.ajax({
    data: '',
    url: prefixUrl+"syndicate/id/"+id,
    type:"GET",
    success:function(data) {
      data.forEach(function(element) {
        var indexName = "", counter = 0;
        var htmlTitle = 'Syndicate Detail '+id;
        var dateValue;
        htmlBody += '<table class="table">';
        $(".modal-title").html(htmlTitle);
        $.each(element, function(index, item) {
          counter++;
          titleClass = '';
          if (index=='updated_at' || index=='created_at') {
            dateValue = new Date(item);
            item = dateValue.getFullYear()+'-'+(dateValue.getMonth()+1)+'-'+dateValue.getDate()+' '+dateValue.getHours()+':'+dateValue.getMinutes()+':'+dateValue.getSeconds();
          }
          if (index!='funded_report_id' && index!='id') {
            if (index=='syndicators_name') {
              titleClass = 'h5';
            } 
            indexName = index.replace("_", " ");
            index = indexName.charAt(0).toUpperCase().concat(indexName.substring(1, indexName.length));
            item = empty(item) ? "" : item;
            htmlBody += '<tr data-dt-row="'+element.id+'" data-dt-column="'+counter+'"></tr>';
            htmlBody += '<td class="'+titleClass+'">'+index+':</td>';
            htmlBody += '<td class="'+titleClass+'">'+item+'</td>';
            htmlBody += '</tr>';
          }
        });
        htmlBody += '</table><br />';
      });
      $(".modal-body").html(htmlBody);
      $("#modal-detail").modal("show");
    }
  });
}
