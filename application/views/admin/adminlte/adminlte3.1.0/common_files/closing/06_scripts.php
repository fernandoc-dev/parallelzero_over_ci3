<!-- jQuery -->
<script src="<?php echo base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/adminlte/dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/adminlte/dist/js/demo.js') ?>"></script>
<?php
echo "\n<!-- Dynamic dependencies loading -->";
if (isset($sections_admin['dependencies']['jqueryui'])) {
    echo "\n<!-- jQuery UI 1.11.4 -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/jquery-ui/jquery-ui.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['uibutton'])) {
    echo "\n<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->\n";
    echo "<script>$.widget.bridge('uibutton', $.ui.button)</script>";
}
if (isset($sections_admin['dependencies']['tempusdominus'])) {
    echo "\n<!-- Tempusdominus Bootstrap 4 -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['summernote'])) {
    echo "\n<!-- Summernote -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/summernote/summernote-bs4.min.js') . "\"></script>\n";
}
if (isset($sections_admin['dependencies']['codemirror'])) {
    echo "\n<!-- CodeMirror -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/codemirror/codemirror.js') . "\"></script>\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/codemirror/mode/css/css.js') . "\"></script>\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/codemirror/mode/xml/xml.js') . "\"></script>\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/codemirror/mode/htmlmixed/htmlmixed.js') . "\"></script>\n";
}
if (isset($sections_admin['dependencies']['charts']['chartjs'])) {
    echo "\n<!-- ChartJS -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/chart.js/Chart.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['charts']['sparkline'])) {
    echo "\n<!-- Sparkline -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/sparklines/sparkline.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['charts']['knobchart'])) {
    echo "\n<!-- jQuery Knob Chart -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/jquery-knob/jquery.knob.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['jqvmap'])) {
    echo "\n<!-- JQVMap -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/jqvmap/jquery.vmap.min.js') . "\"></script>";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['overlayscrollbars'])) {
    echo "\n<!-- overlayScrollbars -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['date_range_picker'])) {
    echo "\n<!-- daterangepicker -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/moment/moment.min.js') . "\"></script>";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['select2'])) {
    echo "\n<!-- select2 -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/select2/js/select2.full.min.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['dashboard'])) {
    echo "\n<!-- AdminLTE dashboard demo (This is only for demo purposes) -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/dist/js/pages/dashboard.js') . "\"></script>";
}
if (isset($sections_admin['dependencies']['switch'])) {
    echo "\n<!-- Bootstrap Switch -->\n";
    echo "<script src=\"" . base_url('assets/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') . "\"></script>";
}

echo "\n<!-- Specific scripts -->\n";

if (isset($sections_admin['dependencies']['summernote'])) {
    echo "\n<!-- Summernote -->\n";
    echo "
    <script>
    $(document).ready(function() {
        $(\"#content\").summernote({
            placeholder: 'Place here the content',
            height: 220,
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {

                    for (var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
                    }
                }
            }
        });
    });

    function sendFile(file, el) {
        var form_data = new FormData();
        form_data.append('file', file);
        $.ajax({
            data: form_data,
            type: \"POST\",
            url: 'get_pictures',
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                $(el).summernote('editor.insertImage', url);
            }
        });
    }
</script>
    ";
}

if (isset($sections_admin['dependencies']['codemirror'])) {
    echo "\n<!-- CodeMirror -->\n";
    echo "<script>
    $(function () {
        //CodeMirror
            CodeMirror.fromTextArea(document.getElementById(\"codeMirrorDemo\"), {
            tmode: \"htmlmixed\",
            theme: \"monokai\"
        });
    })
</script>";
}
if (isset($sections_admin['dependencies']['select2'])) {
    echo "\n<!-- select2 -->\n";
    echo "<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    $('.select2bs4').select2(
        {theme: 'bootstrap4'}
    )
    })
</script>";
}
if (isset($sections_admin['dependencies']['switch'])) {
    echo "\n<!-- Switch -->\n";
    echo "<script>
    $(function () {
        $(\"input[data-bootstrap-switch]\").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    })
</script>";
}
?>
<script>
    //Script to activate the filter function for the "search" input in admin
    $(document).ready(function() {
        $("#table_search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table_body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        const selectElement = document.querySelector('#id_course');
        selectElement.addEventListener('change', (event) => {
            alert("Hola Mundo!");
        });
    })
</script>