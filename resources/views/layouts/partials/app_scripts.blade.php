<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/js/init-alpine.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer ></script>
<script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
<script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>
{{ $scripts ?? '' }}

@if (session()->has('success'))
    <script>
        toastr.success("{{ session('success') }}")
    </script>
@endif
