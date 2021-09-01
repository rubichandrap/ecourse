<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- js jquery -->
{{-- <script src="{{ asset('asset/argon/js/plugins/jquery/dist/jquery.min.js') }}"></script> --}}
<script src="{{ asset('asset/jquery/jquery-3.4.1.min.js') }}"></script>
<!-- js argon -->
<script src="{{ asset('asset/argon/js/argon-dashboard.min.js') }}"></script>
<!-- js main -->
<script src="{{ asset('asset/main/js/animate.js') }}"></script>
<!-- js ajax calls -->
<script src="{{ asset('asset/main/js/ajax-calls.js') }}"></script>
<!-- js fontawesome -->
<script src="{{ asset('asset/fontawesome-free-5.12.0/js/all.min.js') }}"></script>
<!-- js jquery datatables -->
<script src="{{ asset('asset/main/js/jquery.dataTables.min.js') }}"></script>
<!-- js bootstrap datatables -->
<script src="{{ asset('asset/main/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- datatables activation -->
<script type="text/javascript">
    $(document).ready(function() {
        const table = $('#table');
        const deflect = $('#table #deflection');
        if (table) {
            if (deflect.length < 1) {
                $(table).DataTable({
                    scrollX: true,
                    scrollCollapse: true,
                });
            } else {
                return false;
            }
        }
    });
</script>
<!-- ck finder -->
<script src="{{ asset('asset/ckfinder_php_3.5.1/ckfinder/ckfinder.js') }}"></script>
<!-- ck editor -->
<script src="{{ asset('asset/ckeditor_4.14.0_standard/ckeditor/ckeditor.js') }}"></script>
<!-- ck editor activation -->
<script type="text/javascript">
    $(document).ready(() => {
        const base_url = window.location.origin;
        const ckEditor = document.querySelector('#editor');
        if (ckEditor) {
            CKFinder.setupCKEditor();
            CKEDITOR.replace( 'editor' );
        }
    });
</script>