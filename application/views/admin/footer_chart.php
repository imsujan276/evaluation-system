<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$link = base_url('assets/framework/bootstrap/admin/');
?>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<div class="row-fluid">
    <div id="footer" class="span12"> 2017 &copy; Evaluation System. </div>
</div>
<script type="text/javascript">

    var datafromphp = [];


<?php echo $data_chart; ?>

</script>
<!--end-Footer-part-->
<script src="<?php echo $link; ?>js/jquery.min.js"></script> 
<script src="<?php echo $link; ?>js/bootstrap.min.js"></script> 
<script src="<?php echo $link; ?>js/jquery.flot.min.js"></script> 
<script src="<?php echo $link; ?>js/jquery.flot.pie.min.js"></script> 
<script src="<?php echo $link; ?>js/matrix.charts.js"></script> 
<script src="<?php echo $link; ?>js/jquery.flot.resize.min.js"></script> 
<script src="<?php echo $link; ?>js/matrix.js"></script> 
<script src="<?php echo $link; ?>js/jquery.peity.min.js"></script> 
<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
                resetMenu();
            }
            // else, send page to designated URL            
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>
<!--Turning-series-chart-js-->
</body>
</html>
