<footer class="main-footer">
    &copy; {{ date('Y') }}<a href="#">Valuez Hut</a>. All Rights Reserved.
</footer>

<!-- Vendor JS -->
<script src="{{ asset('assets/src/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    });
</script>
@yield('script-section')
<!-- edulearn App -->
<script src="{{ asset('assets/src/js/demo.js') }}"></script>
<script src="{{ asset('assets/src/js/template.js') }}"></script>
<script src="{{ asset('assets/src/js/pages/data-table.js') }}"></script>
