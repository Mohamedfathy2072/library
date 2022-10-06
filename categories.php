<?php
session_start();
include "init.php";
// echo '<div class="container">';
// echo '<h1 class="  text-center pt-3 ">'.str_replace('-',' ',$_GET['name']).'</h1>';
// foreach (getitems('catID',$_GET['pageid']) as $item) {
//     echo $item['name'];
// }
// echo '</div>';
?>
<div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
    <h1 class="  text-center pt-3 ">name</h1>
    
    <?php
    foreach (getitems('catID',$_GET['pageid']) as $item) {
    ?>
    
        <div class="col-lg-4 col-sm-6 col-md-4 ">
            <div class="supitem">
        <!-- <svg class="bd-placeholder-img rounded-circle" width="140" height="140" style="padding: px;margin: 12px;" xmlns="" role="img"
                aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice"
        focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg> -->
             <img src="layout/img/insta-2.jpg" class="rounded  img-circle" alt="..."  width="140" height="140" style="margin: 12px;">

        <h2><a style="text-decoration:none" href="item.php?itemid=<?php echo $item['item_id']; ?>"><?php echo $item['name'] ?></a></h2>
        <h6><?php echo $item['description'] ?></h6>
        <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
            <div class="float-end dateitem"><?php echo $item['add_date'] ?></div>

        </div>
    </div>
    <?php } ?>
    <!-- /.col-lg-4 -->

    </div><!-- /.row -->


<?php
include $tpl . "fotter.php";
?>