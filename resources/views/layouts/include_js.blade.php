<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS Files -->
{{-- <script src="{{ url('vendor/apexcharts/apexcharts.min.js') }}"></script> --}}
<script src="{{ url('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ url('vendor/chart.js/chart.umd.js') }}"></script> --}}
{{-- <script src="{{ url('vendor/quill/quill.min.js') }}"></script> --}}
{{-- <script src="{{ url('vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
<script src="{{ url('vendor/tinymce/tinymce.min.js') }}"></script>
{{-- <script src="{{ url('vendor/php-email-form/validate.js') }}"></script> --}}
<script src="{{ url('js/jquery.min.js') }}"></script>
{{--
<script src="{{ url('js/xlsx.full.min.js') }}"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="//cdn.sheetjs.com/xlsx-0.19.1/package/dist/xlsx.full.min.js"></script>
--}}

<!-- Template Main JS File -->
<script src="{{ url('js/main.js') }}"></script>

<script type="text/javascript">
    function submitLogout(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    };

    function showProgressScreen() {
        $('#modal-spinner').modal('show');
    };

    function hideProgressScreen() {
        $('#modal-spinner').modal('hide');
    };

    $(window).on('unload', function() {
        showProgressScreen();
    });
</script>

@stack('javascript')

</body>
</html>