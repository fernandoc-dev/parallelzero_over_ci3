<!--head-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (isset($title)) {
                echo $title;
            } else {
                echo "Parallel Zero";
            } ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome6/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <?php
    echo "\n\t<!-- Dynamic dependencies loading -->\n";
    if (isset($sections_admin['dependencies']['ionicons'])) {
        echo "\n\t<!-- Ionicons -->\n";
        echo "<link rel=\"stylesheet\" href=\"https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css\">\n";
    }
    if (isset($sections_admin['dependencies']['summernote'])) {
        echo "\n\t<!-- Summernote -->\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/summernote/summernote-bs4.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['codemirror'])) {
        echo "\n\t<!-- CodeMirror -->\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/codemirror/codemirror.css') . "\">\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/codemirror/theme/monokai.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['simplemde'])) {
        echo "\n\t<!-- SimpleMDE -->\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/simplemde/simplemde.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['icheck'])) {
        echo "\n<!-- iCheck -->\n";
        echo "<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['jqvmap'])) {
        echo "\n<!-- JQVMap -->\n";
        echo "<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/jqvmap/jqvmap.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['overlayscrollbars'])) {
        echo "\n<!-- overlayScrollbars -->\n";
        echo "<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['date_range_picker'])) {
        echo "\n<!-- Daterange picker -->\n";
        echo "<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['tempusdominus'])) {
        echo "\n\t<!-- Tempusdominus Bootstrap 4 -->\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') . "\">\n";
    }
    if (isset($sections_admin['dependencies']['select2'])) {
        echo "\n\t<!-- Select2 -->\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/select2/css/select2.min.css') . "\">\n";
        echo "\t<link rel=\"stylesheet\" href=\"" . base_url('assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') . "\">\n";
    }
    ?>
    <!-- My own CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/parallel_zero/css/my_admin_styles.css') ?>">
</head>