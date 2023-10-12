<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>User Request LIST</title>

</head>
<?php  
	ob_start();
include('../Assets/Connection/Connection.php');
include('Head.php');
      
  if(isset($_GET["sts"]))
  {
    $upQry = "update tbl_request set request_status='".$_GET["sts"]."' where request_id='".$_GET["pid"]."'";
    if($con->query($upQry))
    {
      ?>
        <script>
            window.location="ViewRequest.php";
        </script>
      <?php
    }
  
  }  

    ?>

<body>
  <section class="main_content dashboard_part">

    <!--/ menu  -->
    <div class="main_content_iner ">
      <div class="container-fluid p-0">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="QA_section">
              <h1>USER ORDERS</h1>
              <div class="QA_table mb_30">
                <!-- table-responsive -->
                <table class="table lms_table_active">
                  <thead>
                    <tr style="background-color: #74CBF9">
                      <td align="center" scope="col">SL NO</td>
                      <td align="center" scope="col">USER NAME</td>
                      <td align="center" scope="col">USER EMAIL</td>
                      <td align="center" scope="col">REQUEST DATE</td>
                      <td align="center" scope="col">FOR DATE</td>
                      <td align="center" scope="col">color</td>
                      <td align="center" scope="col">GRAPHICS</td>
                      <td align="center" scope="col">DESIGN</td>
                      <td align="center" scope="col">STATUS</td>
                      <td align="center" scope="col">COLOR</td>
                      <td align="center" scope="col">SIZE</td>
                      <td align="center" scope="col">DETAILS</td>
                      <td align="center" scope="col">IMAGE</td>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php
												                          $i = 0;
                                                $selqry = "SELECT * FROM `tbl_request` r inner join tbl_user u on u.user_id=r.user_id inner join tbl_color s on s.color_id=r.color_id inner join tbl_graphics c on c.graphics_id=r.graphics_id where request_status>0";
                                                $res=$con->query($selqry);
                                                while($data=$res->fetch_assoc())
                                                {

                                                    $i++;

                                            ?>
                    <tr>
                      <td>
                        <?php echo $i; ?>
                      </td>
                      <td>
                        <?php echo $data["user_name"]; ?>
                      </td>
                      <td>
                        <?php  echo $data["user_email"]; ?>
                      </td>
                      <td>
                        <?php echo $data['request_date'] ?>
                      </td>
                      <td>
                        <?php echo $data['request_fordate'] ?>
                      </td>
                      <td>
                        <?php echo $data['color_name'] ?>
                      </td>
                      <td>
                        <?php echo $data['graphics_name'] ?>
                      </td>

                      <td>
                        <?php 
          if($data['design_id']!=0)
          {
            $selIce="SELECT * FROM `tbl_design` where design_id ='".$data['design_id']."'";
		        $resIce=$con->query($selIce);
		        $dataIce=$resIce->fetch_assoc();
            echo $dataIce["design_name"];
          }
          else{
            echo "Complementary";
          }
        ?>
                      </td>
                      <td>
            <?php
                  if($data['request_status']=="1")
                  {
                    echo "Order Placed";
                  }
                  else if($data['request_status']=="2")
                  {
                    echo "Order Processing";
                  }
                  else if($data['request_status']=="3")
                  {
                    echo "Order Ready To Deliver";
                  }
                  else if($data['request_status']=="4")
                  {
                    echo "Order Completed";
                  }

              ?>  



        </td>	
                      <td>
                        <?php 
          if($data['color_id']!=0)
          {
            $selCol="SELECT * FROM `tbl_color` where color_id='".$data['color_id']."'";
		        $resCol=$con->query($selCol);
		        $dataCol=$resCol->fetch_assoc();
            echo $dataCol["color_name"];
          }
          else{
            echo "Complementary";
          }
        ?>
                      </td>
                      
                      <td>
                        <?php 
          if($data['size_id']!=0)
          {
            $selTop="SELECT * FROM `tbl_size` where size_id='".$data['size_id']."'";
		        $resTop=$con->query($selTop);
		        $dataTop=$resTop->fetch_assoc();
            echo $dataTop["size_name"];
          }
          else{
            echo "Complementary";
          }
        ?>
                      </td>
                      
                     
                      <td>
                        <?php 
        if($data['request_details']==0)
        {
          echo "Nothing Default";
        }
        else
        {
          echo $data['request_details'];
        } 
        ?>
                      </td>
                     
                      <td>
                        <?php
            if($data['request_image']=="Image Not Found")
            {
                echo "Image Not Found";
            }
            else{
              ?>
                        <a href="../Assets/Files/Request/<?php echo $data['request_image'] ?>" target="_blank">
                          <img src="../Assets/Files/Request/<?php echo $data['request_image'] ?>" width="80"
                            height="80" />
                        </a>
                        <?php
            }
          ?>
                      </td>
                    
                     

                    </tr>
                    <?php                     }


                                            ?>

                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</body>
<?php
		include('Foot.php');
		 ob_end_flush();
		?>

</html>