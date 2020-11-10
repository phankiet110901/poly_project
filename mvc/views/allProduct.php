<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>All Products</title>
	<!-- Header extensions -->
	<?php include_once "./mvc/views/include/header_extensions.php";?>
    <!-- custom-css -->
    <link rel="stylesheet" href="./css/main.css" />
  </head>
  <body>
		<!-- Header -->
		<?php include_once "./mvc/views/include/header.php";?>
		<section class="product">
			<div class="container text-center">
				<h3 class="pb-5 pt-5">ALL</h3>
				<div class="row">
					<?php foreach($data as $key): ?>
					<div class="col-4">
						<a href="./productdetail&&id=<?=$key["productID"]?>">
							<img src="./img/products/<?=$key["productImg"]?>" alt="">
							<p><?=$key["productName"]?> <span>$<?=$key["productPrice"]?></span></p>	
						</a>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<!-- Footer -->
	<?php include_once "./mvc/views/include/footer.php";?>
	<!-- Extensions -->
	<?php include_once "./mvc/views/include/footer_extensions.php";?>
  </body>
</html>
