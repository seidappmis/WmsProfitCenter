<script type="text/javascript">
    initiateCloseNav()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.extend(true, $.fn.dataTable.defaults, {
        "pageLength": 15,
        "searchDelay": 1000,
    });

    Inputmask.extendAliases({
        'cbm_mask': {
          // alias: "numeric",
          numericInput: true,
          mask: "(9,999){+|1}.000",
          placeholder: "0",
          definitions: {
              "0": {
                  validator: "[0-9\uFF11-\uFF19]"
              }
          }
        }
      });

    $('.collapsible-header .no-propagation').click(function(e){ e.stopPropagation(); });
    $('.dataTable .input-filter-column').click(function(e){ e.stopPropagation(); });

    jQuery(document).ready(function($) {
      // add class styling for select2
      $('select.select2-data-ajax').change(function(event) {
        /* Act on the event */
           if ($(this).is(':required')) {
            $(this).parent().find('span.select2-selection').addClass('select2-required')
          }
      });
      setTimeout(function() {
        $.each($('select'), function(index, val) {
           /* iterate through array or object */
           if ($(val).is(':required')) {
            $(val).parent().find('span.select2-selection').addClass('select2-required')
           }
           if ($(val).hasClass('select2-required')) {
            $(val).parent().find('span.select2-selection').addClass('select2-required')
           }
        });
      }, 10);

      $('.datepicker').datepicker({
        autoClose: true,
        format: 'yyyy-mm-dd'
      });
    });

    function set_select2_required(selector){
      if ($(selector).is(':required')) {
        $(selector).parent().find('span.select2-selection').addClass('select2-required')
      }
    }


    // jQuery.validator.setDefaults({
    //   errorElement : 'div',
    //   errorPlacement: function(error, element) {
    //     var placement = $(element).data('error');
    //     if (placement) {
    //       $(placement).append(error)
    //         } else {
    //       error.insertAfter(element);
    //       }
    //     },
    // });
    
  $('.modal').modal({
    dismissible: false, // Modal can be dismissed by clicking outside of the modal
    opacity: .5, // Opacity of modal background
    inDuration: 300, // Transition in duration
    outDuration: 200, // Transition out duration
    startingTop: '4%', // Starting top style attribute
    endingTop: '10%', // Ending top style attribute
    ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
    alert("Ready");
    console.log(modal, trigger);
    },
    complete: function() { alert('Closed'); } // Callback for Modal close
});


function get_select2_ajax_options(url, extraFilter = null) {
  return {
    url: url,
    dataType: 'json',
    type: 'get',
    delay: 250,
    data: function(params) {
      return get_select2_search_term(params, extraFilter);
    },
    processResults: function(data, params) {
      return {
        results: data.items,
        'pagination': {
          'more': data.more
        }
      };
    },
    cache: true,
  };
}

function setDecimal(number, precision = 3){
  return parseFloat(number).toFixed(precision)
}

function get_select2_search_term(params, extraFilter){
  var search_term = {
    q: params.term || '', // search term
    page_limit: 10,
    page: params.page || 1
  };

  Object.assign(search_term, extraFilter)

  return search_term;
}

function setLoading(state = true){
    if (state) {
        $('.btn').addClass('disabled')
        $('.btn-small').addClass('disabled')
        $('.btn-save').addClass('disabled')
        $('.submit-btn').addClass('disabled');
    } else {
        $('.btn').removeClass('disabled')
        $('.btn-small').removeClass('disabled')
        $('.btn-save').removeClass('disabled')
        $('.submit-btn').removeClass('disabled');
    }
}

function showSwalError(xhr){
  var errorDetail = '';
  $.each(xhr.responseJSON.errors, function(index, val) {
       /* iterate through array or object */
       errorDetail += val[0];
  });
  swal({
    title: xhr.responseJSON.message,
    text: errorDetail,
    timer: 1500,
    buttons: false
  })
}

function showSwalAutoClose(title, message){
  swal({
    title: title,
    text: message,
    timer: 1500,
    buttons: false
  })
}

function set_select2_value(selector, id, text) {
  let val = '<option value="' + id + '" selected>' + text + '</option>';
  $(selector).append(val).trigger('change');
}

function set_datatables_checkbox(tableSelector, datatable_object) {
  $(tableSelector + ' tbody').on('change', 'input[type="checkbox"]', function(event) {
    event.preventDefault();
    /* Act on the event */
    var row = $(this).closest('tr');
    var data = datatable_object.row(row).data();
    row.toggleClass('selected');

    if ($(this).attr("checked")) {
      $(this).attr('checked', false);
    } else {
      $(this).attr('checked', true);
    }
  });

  // SElect All
  $('thead input[type="checkbox"]', datatable_object.table().container()).on('click', function (e) {
      if (this.checked) {
          $(this).attr('checked', true);
          $(tableSelector + ' tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
          $(this).attr('checked', false);
          $(tableSelector + ' tbody input[type="checkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
  });
}
$(".nav-collapsible .navbar-toggler").click(function() {
  if (localStorage.getItem('sidenavClosed') == 1) {
    localStorage.setItem("sidenavClosed", 0);
  } else {
    localStorage.setItem("sidenavClosed", 1);
  }
})
function initiateCloseNav(){
  if (localStorage.getItem('sidenavClosed') == 1) {
    $(".sidenav-main").toggleClass("nav-expanded");
    $("#main").toggleClass("main-full");
    $('.nav-collapsible .navbar-toggler')
      .children()
      .text("radio_button_unchecked");
   $(".sidenav-main").removeClass("nav-lock");
   $(".navbar .nav-collapsible").removeClass("sideNav-lock");
   if (!$(".sidenav-main.nav-collapsible").hasClass("nav-lock")) {
       var openLength = $(".collapsible .open").children().length;
       $(".sidenav-main.nav-collapsible, .navbar .nav-collapsible")
          .addClass("nav-collapsed")
          .removeClass("nav-expanded");
       $("#slide-out > li.open > a")
          .parent()
          .addClass("close")
          .removeClass("open");
       setTimeout(function() {
          // Open only if collapsible have the children
          if (openLength > 1) {
             $(".collapsible").collapsible("close", $(".collapsible .close").index());
          }
       }, 100);
    }
  }
}

</script>
