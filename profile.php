<?php session_start();include "init.php";
$pagetitle="My profile";
if (isset($_SESSION['user'])) {

$stmt=$conn->prepare('SELECT * from users where username=?');
$stmt->execute(array($sessionuser));
$users=$stmt->fetchall();

?>
<div class="row">
<div class=" flex-md-equal w-100 ">
    <div class="bg-dark me-md-6  px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden ph">
    <div class="my-3 py-3 cb">
        <h2 class="display-5">Hellow <?php echo $sessionuser;?></h2>
        <p class="lead">Here you can see your information</p>
    </div>
    <div class="bg-light shadow-sm mx-auto" style="width: 80%; height: 100%; border-radius: 21px 21px 0 0; background-color:#eee !important; ">
    <div class="container">
        <ul class="list-group  uprofile  ">
            <li class="list-group-item lih float-end" aria-current="true">Your Information</li>
            <?php  foreach ($users as $user) {
            echo '<li class="list-group-item "> <i class="fa-solid fa-unlock-keyhole"></i> Login Name   :    '.$user['username'].'</li>';
            echo '<li class="list-group-item "> <i class="fa-regular fa-envelope"></i> Email    :    '.$user['email'].'</li>';
            echo '<li class="list-group-item "><i class="fa-regular fa-user"></i>   Full Name   : '.$user['fullname'].'</li>';
            echo '<li class="list-group-item "> <i class="fa-solid fa-calendar-days"></i>    Date  : '.$user['date'].'</li>';

            } ?>
            
            </div>
        </ul>
        <ul class="list-group  uprofile  ">

            <li class="list-group-item lih float-end" aria-current="true">Your Categories</li>
            <li class="list-group-item text-center" >
           <div class="container marketing">
    <!-- Three columns of text below the carousel -->
    <div class="row mt-3">
    <?php
    $items=getitems('userID',$user['userID'],2);
    if (empty($items)) {
        echo '<p class="alert alert-danger text-center mb-0" >There is no items , Create <a href="#"> New item </a> </p>';
    }else{
    foreach ($items as $item) {
    ?>
        <div class="col-lg-4 col-sm-6 col-md-4 ">
            <div class="subitemp">
                <?php if ($item['approval'==0]) {?>
                <div class="approval">Pennding to approve</div>
              <?php }?>
            <img src="layout/img/insta-2.jpg" class="rounded  img-circle" alt="..."  width="140" height="140" style="margin: 12px;">
        <h2><a href="item.php?itemid=<?php echo $item['item_id']; ?>"><?php echo $item['name'] ?></a></h2>
        <p><?php echo $item['description'] ?></p>
        <p><a class="btn btn-secondary" href="#">View details &raquo;</a></p>
            <div class="float-end dateitem"><?php echo $item['add_date'] ?></div>
        </div>
    </div>
    <?php }} ?>
    <!-- /.col-lg-4 -->

    </div><!-- /.row -->


    </li>
            
            </div>
        </ul>
</div>
    </div>
</div>

<?php }else {
    header('location:login.php');
}

include $tpl . "fotter.php";?>