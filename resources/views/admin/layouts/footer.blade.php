<script src="{{ asset('dist-admin/js/scripts.js') }}"></script>
<script src="{{ asset('dist-admin/js/custom.js') }}"></script>
<script src="{{ asset('dist-admin/js/iziToast.min.js') }}"></script>

@if(session('success'))
    <script>
        iziToast.success({
            message: '{{ session('success') }}',
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#2ecc71',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>
@endif
@if(session('error'))
    <script>
        iziToast.error({
            message: '{{ session('error') }}',
            position: 'topRight',
            timeout: 3000,
            progressBarColor: '#FF0000',
            transitionIn: 'bounceInDown',
            transitionOut: 'fadeOutUp'
        });
    </script>
@endif
