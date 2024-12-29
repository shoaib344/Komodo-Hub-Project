<?php

session_start();

# check if the teacher is logged in
if (isset($_SESSION['teacher_id'])) {
    # check if the key is submitted
    if(isset($_POST['key'])){
       # database connection file
	//    include '../db.conn.php';

	   # creating simple search algorithm :) 
	   $key = "%{$_POST['key']}%";
     
	   $sql = "SELECT * FROM teachers
	           WHERE teacher_id
	           ";
       $stmt = $connect->prepare($sql);
       $stmt->execute([$key, $key]);

       if($stmt->rowCount() > 0){ 
         $teachers = $stmt->fetchAll();

         foreach ($teachers as $teacher) {
         	if ($teacher['teacher_id'] == $_SESSION['teacher_id']) continue;
       ?>
       <li class="list-group-item">
		<a href="chat.php?teacher=<?=$teacher['username']?>"
		   class="d-flex
		          justify-content-between
		          align-items-center p-2">
			<div class="d-flex
			            align-items-center">

			    <img src="uploads/<?=$teacher['p_p']?>"
			         class="w-10 rounded-circle">

			    <h3 class="fs-xs m-2">
			    	<?=$teacher['username']?>
			    </h3>            	
			</div>
		 </a>
	   </li>
       <?php } }else { ?>
         <div class="alert alert-info 
    				 text-center">
		   <i class="fa fa-teacher-times d-block fs-big"></i>
           The teacher "<?=htmlspecialchars($_POST['key'])?>"
           is  not found.
		</div>
    <?php }
    }

}else {
	header("Location: ../../main.php");
	exit;
}