<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>S2P 프로젝트</title>
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>assets/theme/images/favicon.png">

    <!-- Theme CSS -->
    <link href="<?php echo base_url()?>assets/theme/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/theme/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/theme/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>assets/theme/dist/css/style.min.css" rel="stylesheet">
    
    <!-- Theme Javascript -->
    <script src="<?php echo base_url()?>assets/theme/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/dist/js/app-style-switcher.js"></script>
    <script src="<?php echo base_url()?>assets/theme/dist/js/feather.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/dist/js/sidebarmenu.js"></script>
    <script src="<?php echo base_url()?>assets/theme/dist/js/custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/extra-libs/c3/d3.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/extra-libs/c3/c3.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/libs/chartist/dist/chartist.min.js"></script>
    <!-- <script src="<?php echo base_url()?>assets/theme/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script> -->
    <script src="<?php echo base_url()?>assets/theme/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo base_url()?>assets/theme/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url()?>assets/theme/dist/js/pages/dashboards/dashboard1.min.js"></script>

    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/common.css')?>">
    <?php if (!empty($build->addCss)) { ?>
        <?php foreach ($build->addCss as &$value) { ?>
            <link rel="stylesheet" href="<?php echo $value ?>" />
        <?php } ?>
    <?php } ?>

    <!-- Custom Javascript -->
    <script>
        const SUCCESS_CODE = <?php echo config_item('SUCCESS_CODE')?>;
        const VALIDATION_FAIL_CODE = <?php echo config_item('VALIDATION_FAIL_CODE')?>;
        const FAIL_CODE = <?php echo config_item('FAIL_CODE')?>;
        const NOT_FOUND_CODE = <?php echo config_item('NOT_FOUND_CODE')?>;
    </script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.kr.min.js"></script>
    <script src="<?php echo base_url('assets/js/common.js')?>"></script>
    <?php if (!empty($build->addJs)) { ?>
        <?php foreach ($build->addJs as &$value) { ?>
            <script type="text/javascript" src="<?php echo $value ?>"></script>
        <?php } ?>
    <?php } ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>