<?php include("includes/connection.php");

include("includes/head.php");

?>
<!DOCTYPE html>
 <html>
 <head>
<style>
select {
           border-radius: 5px;
           box-shadow: 1px 1.732px 5px 0px rgb( 55, 52, 52 );
          border: 1px solid steelblue;
          background-color: white;
          font-family: "Yu Gothic UI Light";
          position: relative;
          left: 200px;
          top: 80px;
          width: 250px;
          height: 40px;
        }

       input{
           border-radius: 5px;
           box-shadow: 1px 1.732px 5px 0px rgb( 55, 52, 52 );
           border: 1px solid rgb(33,33,33);
          font-weight: bold;
          background-color: #234;
          font-family: "Yu Gothic UI Light";
          color: white;
          position: relative;
          left: 200px;
          top: 80px;
          width: 150px;
          height: 40px;
       }

        .photo {
            position: relative ;
            width: 300px;
           height : 250px;
        }

    .desc-title{
        color:#2d70d5;
        font-variant: small-caps;
        font-family: "Yu Gothic UI Light";
        font-size: 29px;
        position: relative;
        top: 0px;
        left: 5px;
        text-decoration: none;
    }
    .desc-content{
        position: relative;
        font-size: 18px;
        font-family:  "Yu Gothic UI Light";
        top: 0px;

    }
    .desc-content2{
        position: relative;
        font-size: 18px;
        font-family:  "Yu Gothic UI Light";
        top: -20px;
    }

     .pic-table{
            border: 8px solid white;
            box-shadow: 0px 6px 20px 0px rgba(0, 0, 0, 0.2);
            background-color: #fafafa;
            border-collapse: collapse;
            float: left;
            overflow: auto;
            margin: 0px 50px 100px 0px;
        }
        .space{
          margin-top: 120px;
          position: relative;
          left:130px;

        }



</style>
<script>
function YNconfirm() {
    if (window.confirm('Are you sure you want to delete this artwork?'))
    {
        return true;
    }
    else
        return false;
};
</script>
</head>
  <?php 
  session_start();
  $user_id = $_SESSION['USER_ID'];
  $sum="select sum(ART_PRICE) as totalx,cart_id from art_work,cart,user where cart.user_id=user.user_id AND art_work.art_id=cart.art_id ";
  $result_category2 = mysqli_query($conn,$sum);
  $row2=mysqli_fetch_assoc($result_category2);
  
  
  $query_category1="SELECT art_work.art_imagepath,art_work.art_id, art_work.art_title,art_work.art_price, user.user_fname, user.user_mname,user.user_lname,art_work.art_description,art_work.art_imagepath,art_work.art_status,art_work.art_category
                         FROM art_work,user,cart
                        where art_work.user_id = user.user_id AND art_work.art_status = 'Available' AND cart.art_id=art_work.art_id AND cart.user_id='$user_id'  ORDER BY art_work.art_title ASC";
            $result_category1 = mysqli_query($conn,$query_category1);
 if(mysqli_num_rows($result_category1) <=0)
        {
            echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><h1 align="Center">No Artworks Available </h1>';
        }
        else{
            while($row1 = mysqli_fetch_array($result_category1))
{
				
                  echo ' <div class="space" >
                            <table  class="pic-table">
                                <tr>
                                    <td>
                                        <img class="photo" src="pictures/arts/'.$row1['art_imagepath'].'" > <br>'.

                                        '<a  href=info_art.php?id='.$row1['art_id'].' class="desc-title"> '.$row1['art_title'].' </a>

                                         <p class="desc-content">'.$row1['art_category'].'</p>

                                         <p class="desc-content" style="float: right;">&#8377 '.$row1['art_price'].'.00</p> <br>

                                         <p class="desc-content2">'.$row1['user_fname'].' '.$row1['user_mname'].' '.$row1['user_lname'].'</p>
                                    
										<p>
                                            
                                                <a class="deletebtn" href =delete_cart.php?delete='.$row1['art_id'].' onclick="return(YNconfirm());"> &#10006; Delete</a>
                                        </p>
										
									</td>
                                </tr>
                            </table>
                        </div>';
            }
}
        echo "<br><br>";


        ?>
    </div>
	<body>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><form action="shipping1.php" method="post">
	<input type="hidden"  name="total" value="<?php echo $row2['totalx']; ?>">
	<input type="hidden"  name="user_id" value="<?php echo $user_id ?>">
	<input type="submit" name="submit" value="<?php echo "Pay Rs.";echo $row2['totalx']; ?>">
	</form>
	</body>
<p class="title"></p>
<?php

include("includes/footer.php");
?>
