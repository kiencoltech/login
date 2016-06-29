@section('bootstrap')
{{-- script --}}
{{ HTML::script('script/jquery-2.1.4.min.js',['type' => 'text/javascript']) }}
{{ HTML::script('script/jquery-ui-1.11.4.min.js') }}
{{ HTML::script('bootstrap/js/bootstrap.min.js') }}
{{ HTML::script('script/moment-2.10.6.js') }}

{{-- css --}}
{{ HTML::style('css/jquery-ui-1.11.4.min.css') }}
{{ HTML::style('bootstrap/css/bootstrap.min.css') }}
@stop