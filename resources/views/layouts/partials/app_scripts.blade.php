<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/js/init-alpine.js') }}"></script>

<!-- You need focus-trap.js to make the custom modal accessible -->
<script src="{{ asset('assets/js/focus-trap.js') }}" defer></script>

{{ $scripts ?? '' }}

@if (session()->has('success'))
    <script>
        toastr.success("{{ session('success') }}")
    </script>
@endif
