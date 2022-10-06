<?php 
session_start();
$pagetitle="item";
include "init.php";

// check if item id is numeric and but id in $itemid
$itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid']:0;
    //fetch data from database
$stmt=$conn->prepare('SELECT items.*, categories.name as catname , users.username as username  from items inner join categories on categories.catID = items.catID 
inner join users on users.userID = items.userID
 where item_id=? limit 1');
$stmt->execute(array($itemid));
    //but data in array

$count=$stmt->rowCount();
$row=$stmt->fetch();
if ($count > 0 ) {
?>
    <div class="container">
    <h1 class="text-center pt-4"><?php echo $row['name']?></h1>
    <div class="row">
    <div class="col-4">
        <img src="layout/img/insta-3.jpg" class="img-thumbnail" alt="...">
    </div>
        <div class="col-8">
    <ul class="list-group list-item">
        <li class="list-group-item "><h2> <?php echo $row['name']  ?></h2> </li>
        <li class="list-group-item "><p> <?php echo $row['description']  ?> </p></li>
        <div class="itemin">
        <li class="list-group-item "> <i class="fa-solid fa-calendar-days"></i> <?php echo $row['add_date']  ?></li>   
        <li class="list-group-item "> <i class="fa-solid fa-money-check"></i> Price : <?php echo $row['price']  ?></li>
        <li class="list-group-item "> <i class="fa-solid fa-globe"></i> country made : <?php echo $row['country_made']  ?></li>
        <li class="list-group-item "> <i class="fa-solid fa-tags"></i> Category made :<a href="categories.php?pageid=<?php echo $row['catID']; ?>"> <?php echo $row['catname']  ?></a></li>
        <li class="list-group-item "> <i class="fa-solid fa-user"></i> Added by :<a href="#"> <?php echo $row['username']  ?></a></li>
        </div>   

            
        </ul>
    </div>
    <hr style="margin: 21px;">
<div class="row pt-5 pb-5">
        <div class="col-5">
        <h3>Add Comment</h3>
        <?php if (isset($_SESSION['user'])) {?>
        <form acttion="<?php echo $_SERVER['PHP_SELF'].'?itemid'.$row['item_id'] ?>" method="POST">
        <div class="form-floating">
        <textarea class="form-control " name="comment" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px" required></textarea>
        <label for="floatingTextarea2">Add your Comment here</label>
        <button class="btn btn-primary bcomment"> Add Comment</button>
        </div>
        </form>
        <?php } else { echo '<div class="cregister pb-2"><a href="login.php">Login</a> or <a href="signup.php">Creat account</a> to be aple to add comment</div>';?>
            <div class="form-floating">
        <textarea class="form-control " placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px" disabled></textarea>
        <label for="floatingTextarea2">Add your Comment here</label>
        <button class="btn btn-primary bcomment"> Add Comment</button>
        </div>
        <?php }
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $comment=$_POST['comment'];
            $userid=$row['userID'];
            $itedmid=$row['item_id'];
            if (!empty($comment)){

            $stmt=$conn->prepare('INSERT into comments(comment,status,comment_data	,item_id,userID) values(:comment,0,now(),:itemid,:userid)');
            $stmt->execute(array(
                'comment'   => $comment,
                'itemid'    =>$itedmid,
                'userid'    =>$userid
            ));
              if ($stmt){
            echo '<div class="alert alert-success">Comment added succsessfully</div>';
        }
        }
      
        }
        
        

        ?>

    </div>
<div class="col-7">
        <?php
        $stmt=$conn->prepare('SELECT comments.* , users.username as username  from comments 
                                inner join users on users.userID = comments.userID 
                                where item_id=? and status=1 order by c_id desc');
        $stmt->execute(array($row['item_id']));
        $comments=$stmt->fetchALL();

        ?>
        
            <div class=" align-items-md-stretch">
                <div class="">
                    <div class="h-100 p-5 text-white bg-dark rounded-3">
                        <div class="headc">
                    <h2 class="text-center">Comments</h2>
                    </div>

                        <?php
                        if (empty($comments)) {
                            echo '<p class="text-center fw-bold">This item have no comments</p>';
                        }else{
                        foreach ($comments as $commen) {?>
                        <div class="commentbox">
                        <div class="row">                

                        <div class="col-3 text-center">
                        <img src="layout/img/insta-2.jpg" class="rounded  img-circle" alt="...">
                        <?php echo $commen['username']?>
                        </div>
                    
                        <div class="col-9 text-center">
                        <p class="commentcontrol"><?php echo $commen['comment']?></p>
                        </div>
                    </div>
                        </div>
                        <hr>
                    <?php } } ?>
                    

                
        </div>
</div



<?php
}else{
    echo 'there no such id';
}
include $tpl . "fotter.php";
?>