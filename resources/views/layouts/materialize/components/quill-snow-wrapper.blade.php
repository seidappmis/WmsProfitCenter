<textarea name="{{$name}}" style="display:none" id="textarea-{{$name}}"></textarea>
<div id="full-wrapper">
    <div id="full-container-{{$name}}">
        <div class="editor" style="max-height: 70vh; overflow-y: scroll;">{!!$value!!}</div>
    </div>
</div>

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/quill/quill.snow.css') }}">
@endpush

@push('vendor_js')
<script src="{{ url('materialize/vendors/quill/katex.min.js') }}" type="text/javascript"></script>
<script src="{{ url('materialize/vendors/quill/highlight.min.js') }}" type="text/javascript"></script>
<script src="{{ url('materialize/vendors/quill/quill.min.js') }}" type="text/javascript"></script>
@endpush

@push('script_js')
<script type="text/javascript">
  var fullEditor = new Quill('#full-container-{{$name}} .editor', {
    bounds: '#full-container-{{$name}} .editor',
    modules: {
      'formula': true,
      'syntax': true,
      'toolbar': [
        [{
          'font': []
        }, {
          'size': []
        }],
        ['bold', 'italic', 'underline', 'strike'],
        [{
          'color': []
        }, {
          'background': []
        }],
        [{
          'script': 'super'
        }, {
          'script': 'sub'
        }],
        [{
          'header': '1'
        }, {
          'header': '2'
        }, 'blockquote', 'code-block'],
        [{
          'list': 'ordered'
        }, {
          'list': 'bullet'
        }, {
          'indent': '-1'
        }, {
          'indent': '+1'
        }],
        ['direction', {
          'align': []
        }],
        ['link', 'image', 'video', 'formula'],
        ['clean']
      ],
    },
    theme: 'snow'
  });
  // add browser default class to quill select 
  var quillSelect = $("select[class^='ql-'], input[data-link]" );
  quillSelect.addClass("browser-default");

  // var editors = [bubbleEditor, snowEditor, fullEditor];
</script>
@endpush