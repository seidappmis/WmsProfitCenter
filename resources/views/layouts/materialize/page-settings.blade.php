<script type="text/javascript">
    initiateCloseNav()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.collapsible-header .no-propagation').click(function(e){ e.stopPropagation(); });

    jQuery(document).ready(function($) {
      // add class styling for select2
      $.each($('select'), function(index, val) {
         /* iterate through array or object */
         if ($(val).is(':required')) {
          $(val).parent().find('span.select2-selection').addClass('select2-required')
         }
      });

      $('.datepicker').datepicker();
    });


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


function get_select2_ajax_options(url) {
  return {
    url: url,
    dataType: 'json',
    type: 'get',
    delay: 250,
    data: function(params) {
      return get_select2_search_term(params);
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

function get_select2_search_term(params){
  var search_term = {
    q: params.term || '', // search term
    page_limit: 10,
    page: params.page || 1
  };

  return search_term;
}

function setLoading(state = true){
    if (state) {
        $('.submit-btn').addClass('disabled');
    } else {
        $('.submit-btn').removeClass('disabled');
    }
}

function showSwalError(xhr){
  var errorDetail = '';
  $.each(xhr.responseJSON.errors, function(index, val) {
       /* iterate through array or object */
       errorDetail += val[0];
  });
  swal(xhr.responseJSON.message, errorDetail, "error")
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
