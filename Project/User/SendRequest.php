<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST['btn_sr']))
{
	$user=$_SESSION['uid'];
	$date=$_POST['date_date'];

  $photo = "Image Not Found";
  if($_FILES['file_img']['name']!="")
  {
    $photo=$_FILES['file_img']['name'];
	  $temp=$_FILES['file_img']['tmp_name'];
	  move_uploaded_file($temp,"../Assets/Files/Request/".$photo);
  }



	$date=$_POST['date_date'];
  $font=$_POST['slct_font'];
	$graphics=$_POST['slct_graphics'];
  $total = $_POST["totalText"];
	
  $color=0;
  if($_POST['slct_color']!="")
  {
    $color = $_POST['slct_color'];
  }
  $size=0;
  if($_POST['slct_size']!="")
  {
    $size = $_POST['slct_size'];
  }
  $details=0;
  if($_POST['txt_details']!="")
  {
    $details = $_POST['txt_details'];
  }
  $design=0;
  if($_POST['slct_design']!="")
  {
    $design = $_POST['slct_design'];
  }


  

	$insqry="INSERT INTO `tbl_request`(`request_date`, `request_details`, `request_image`, `design_id`, `graphics_id`, `font_id`, `color_id`, `size_id`, `user_id`, `request_fordate`, `request_amount`)
  values(curdate(),'$details','$photo','$design','$graphics','$font','$color','$size','$user','$date','$total')";
	if($con->query($insqry))
  {
    $selQry = "select max(request_id) as id from tbl_request";
    $res=$con->query($selQry);
		$data=$res->fetch_assoc();

    ?>
    <script>
      alert("Request Sended");
      window.location="Payment2.php?bid=<?php echo $data["id"];?>";
    </script>
    <?php
  }
  else{
    ?>
      <script>
        alert("Failed");
        window.location="SendRequest.php";
      </script>
    <?php
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEND REQUEST</title>
<style>
  sup{
    color: red;
  }
</style>
</head>
<?php
include("Head.php");
?>
<body>

<h1>CUSTOMIZE YOUR SHOE</h1><br>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="653" height="636" border="1">
    <tr>
      <th width="200" scope="row">
        DATE
        
      </th>
      <td width="437"><label for="date_date"></label>
      <input type="date" name="date_date" required id="date_date" /></td>
    </tr>
    <tr>
      <th scope="row">FONT</th>
      <td><label for="slct_font"></label>
        <select name="slct_font" id="slct_font" required>
        <option value="">---select---</option>
        <?php 
		$selqry="select * from tbl_font";
		$res=$con->query($selqry);
		while($data=$res->fetch_assoc())
		{
		?>
        <option value="<?php echo $data['font_id'];?>"> <?php echo $data['font_name'];?></option>
        <?php } ?>
      </select></td>
      
    </tr>
    <tr>
      <th scope="row">GRAPHICS</th>
      <td><label for="slct_graphics"></label>
        <select name="slct_graphics" id="slct_graphics" required onChange="checkPrice()">
        <option value="">---select---</option>
			
        <?php 
		$selqry="select * from tbl_graphics";
		$res=$con->query($selqry);
		while($data=$res->fetch_assoc())
		{
		?>
        <option value="<?php echo $data['graphics_id'];?>"> <?php echo $data['graphics_name'];?>(<?php echo $data['graphics_price'];?>/Pair)</option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <th scope="row">DESIGN</th>
      <td><label for="slct_design"></label>
        <select name="slct_design" id="slct_design" onChange="checkPrice()">
         <option value="">---select---</option> 
		 <?php 
		$selqry="select * from tbl_design";
		$res=$con->query($selqry);
		while($data=$res->fetch_assoc())
		{
		?>
        <option value="<?php echo $data['design_id'];?>"> <?php echo $data['design_name'];?>(<?php echo $data['design_price'];?>)</option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <th scope="row">COLOR</th>
      <td><label for="slct_color"></label>
        <select name="slct_color" id="slct_color">
         <option value="">---select---</option>
          <?php 
		$selqry="select * from tbl_color";
		$res=$con->query($selqry);
		while($data=$res->fetch_assoc())
		{
		?>
        <option value="<?php echo $data['color_id'];?>"> <?php echo $data['color_name'];?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <th scope="row">SIZE</th>
      <td><label for="slct_size"></label>
        <select name="slct_size" id="slct_size"  onChange="checkPrice()">
         <option value="">---select---</option>
          <?php 
		$selqry="select * from tbl_size";
		$res=$con->query($selqry);
		while($data=$res->fetch_assoc())
		{
		?>
        <option value="<?php echo $data['size_id'];?>"> <?php echo $data['size_name'];?>(<?php echo $data['size_price'];?>)</option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
      <th scope="row">DETAILS</th>
      <td><label for="txt_details"></label>
      <textarea name="txt_details" id="txt_details" cols="45" rows="5"></textarea></td>
    </tr>
    <tr>
      <th scope="row">IMAGE</th>
      <td><label for="file_img"></label>
      <input type="file" name="file_img" id="file_img" /></td>
    </tr>
   
    <tr>
      <th colspan="2" scope="row">
      <input type="submit" name="btn_sr" id="btn_sr" value="ORDER" />
      <span id="totalAmount" align="right"></span>
      <input type="hidden" name="totalText" id="totalText" />

    </th>
    </tr>
  </table>
  
</form>
</body>
</html>
<script src="../Assets/JQ/jQuery.js"></script>
 <script>    

function checkPrice()
{
	var graphics = document.getElementById("slct_graphics").value;
  var design = document.getElementById("slct_design").value;
  var size = document.getElementById("slct_size").value;


  $.ajax({
		url:"../Assets/AjaxPages/AjaxPrice.php?graphics="+graphics+"&design="+design+"&size="+size,
		success: function(a){
      if(a.trim()!=="")
      {
        document.getElementById("totalAmount").innerHTML = "Total Amount ="+ a; 
        document.getElementById("totalText").value = a; 
      }
		}
	});
}

</script>
<script>
    $(function () {
       // console.log("haii")
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;


        console.log(maxDate);
        $('#date_date').attr('min', maxDate);
    });
</script>
<?php
include("Foot.php");
?>