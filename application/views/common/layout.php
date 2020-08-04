<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<!-- head -->
<?php echo $build->head ?>

<body>
    <!-- <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> -->

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <?php echo $build->header ?>
    
        <div class="<?php echo $build->header ? 'page-wrapper':''?>">
            <div class="container-fluid">
                <?php echo $build->contents ?>
            </div>
            
            <?php echo $build->footer ?>
        </div>
    </div>

</body>

</html>