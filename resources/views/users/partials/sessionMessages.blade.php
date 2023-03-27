{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0---}}
{{--     alpha/css/bootstrap.css" rel="stylesheet">--}}

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}

<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<div class="card-flush py-4">
    <div class="form-group">
        <script>
            @if(Session::has('success'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
            toastr.success("{{ session('success') }}");
            @endif

                @if(Session::has('error'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
            toastr.error("{{ session('error') }}");
            @endif

                @if(Session::has('info'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
            toastr.info("{{ session('info') }}");
            @endif

                @if(Session::has('warning'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
            toastr.warning("{{ session('warning') }}");
            @endif
        </script>

    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <p><strong>Opps Something went wrong</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif


