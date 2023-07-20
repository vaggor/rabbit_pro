<!DOCTYPE html>
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->
	<title></title>
</head>
<body>
	<div class="container">
		
		<div class="row" style="margin-top: 10px;width: 900px;">
		    <div class="container border " style="background-color: #f8f8f8;">
		    	<?php foreach($data as $data){ ?>
				<div class="row">
		    		<div id="product1" class="col-sm-2 col-xs-4 col-md-4 order-md-1 item-photo">
				    <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://localhost:8888/rabbit_pro/app/breeders/view/<?php echo $data['id']; ?>&choe=UTF-8" title="Link to Google.com" />
				    </div>
				    <div class="col-sm-10 col-md-8 order-md-2 col-xs-8 " style="border: 0px solid gray;">
				    <h3 class="mb-3"><?php echo $data['name']; ?></h3>
				    <h6 class="title-price mb-3">ID: <small><?php echo $data['breeder_id']; ?> </small></h6>
				    <h6 class="title-price mb-3">Cage: <small><?php echo $data['cage']; ?> </small></h6>
				    <h6 class="title-price mb-3">Breed: <small><?php echo $data['breed_name']; ?> </small></h6>
				    <h6 class="title-price mb-3">Color: <small><?php echo $data['color']; ?> </small></h6>
				    <h6 class="title-price mb-3">Date of birth: <small><?php echo date('d M,Y', strtotime($data['date_born'])); ?> </small></h6>
				    <h6 class="title-price mb-3">Sex: <small><?php echo $data['sex_name']; ?> </small></h6>			   
				</div>
			</div>
			<?php } ?>
		</div>

	</div>
</body>
</html>



