<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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

  jQuery(document).ready(function($) {
      $('.datepicker').datepicker();
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

</script>
