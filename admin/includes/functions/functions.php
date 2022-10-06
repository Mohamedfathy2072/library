 <?php
 /**
  * title function that get the title in case the page has it's title in $pagetitle
  */
  function get_title(){
    global $pagetitle;
    if (isset($pagetitle)) {
        echo $pagetitle;
    }else {
        echo 'default';
    }
  }
  /**
   * redirect function [ accebt argument]
   * $errmessage = [echo the error message]
   * $seconds = [seconds before  redirectig ]
   * 
   */
  function redirecthome($mssg,$url=null,$seconds=3){
    if ($url==null) {
      $url='login.php';
      $link='login page';
    }else {
      $url= isset($_SERVER['HTTP_REFERER']) &&  $_SERVER['HTTP_REFERER']!=='' ? $_SERVER['HTTP_REFERER'] : 'login.php';
      $link='previous page';

    }
    echo $mssg;
                    
    echo '<div class="  alert alert-info text-center " 
    role="alert">you will redirect to '.$link.' page after '.$seconds.' seconds</div>';
    header("refresh:$seconds;url=$url");


  }
    /**
   * check item function [accebt argument]
   * $select  = [item to select ex: username,email]
   * $from    = [taple name ex:users ]
   * $value   = [value of select  ]
   */
  function checkitem($select,$from,$value){
    global $conn;
    $stmt2=$conn->prepare('SELECT '.$select.' FROM '.$from.' where '. $select.' =?');
    $stmt2->execute(array($value));
    $count=$stmt2->rowCount();
return $count;
  }
    /**
   * count item function [accebt argument]
   * function used to count number of items
   * $item  = [item to count]
   * $taple    = [taple name ex:users ]
   */
  function countitem($item,$taple){
    global $conn;
    $stmt2=$conn->prepare('SELECT count('.$item.') FROM '.$taple.'');
    $stmt2->execute(  );
    $count=$stmt2->fetchcolumn();
    return $count;
  }
    /**
   * latestitems  [accebt argument]
   * function used to get latest [items-users...] 
   * $select  = [item to select ex: username,email]
   * $taple    = [taple name ex:users ]
   * $order =[order by ex:userid]
   * $limit
   */
  function getlatest($select,$taple,$order,$limit=5){
    global $conn;
    $stmt2=$conn->prepare('SELECT '.$select.' FROM '.$taple.' ORDER BY '. $order.' DESC limit '.$limit.'');
    $stmt2->execute();
    $rows=$stmt2->fetchall();
    return $rows;
  }
  // "<a href='members.php?do=activate&userid=".
  //                                                       $value['userID']."' class='btn btn-info'
  //                                                        style='margin-left:5px' float-end><i class='fa-solid fa-circle-check'></i> Activate</a>";