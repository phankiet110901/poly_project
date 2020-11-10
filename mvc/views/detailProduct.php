<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Product Detail</title>
	  <!-- Header extensions -->
	  <?php include_once "./mvc/views/include/header_extensions.php";?>
    <!-- custom-css -->
    <link rel="stylesheet" href="./css/main.css"/>
  </head>
  <body>
    <!-- Header -->
	  <?php include_once "./mvc/views/include/header.php";?>
    <section class="detail-product mb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <img src="./img/products/<?=$data[0]["productImg"]?>" alt="Product's avatar" />
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-9">
            <h3><?=$data[0]["productName"]?></h3>
            <span>$<?=$data[0]["productPrice"]?></span>
            <p class="mt-3">SIZE</p>
            <p class="chooseSize">
              <label for="chooseSize"></label>
              <select name="chooseSize">
                <?php foreach ($data[1] as $key):?>
                <option value="<?=$key['sizeID']?>"><?=$key["sizeName"];?></option>
                <?php endforeach;?>
              </select>
            </p>
          </div>
          <div class="col-3 text-right">
            <p>
              <button class="btn-default btn-white">
                <a href="">ADD TO CART</a>
              </button>
            </p>
            <p>
              <button class="btn-default">
                <a href="">BUY IT NOW</a>
              </button>
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="describeProduct mb-5 mt-5">
      <div class="describeContent">
        <div class="container-fluid">
          <div class="row">
            <div class="col-6">
              <?=$data[0]["productDescription"]?>
              <?php include_once "./include/measure.php";?>
							<p>Sign up to receive 10% off your first purchase</p>
							<div class="emailAdress text-center">
								<input type="text" placeholder="Email Adress">
								<button class="btn-default">ENTER</button>
							</div>
							<img src="./img/products/describe-1.png" alt="" class="pl-0">
							<p>What do you think?...</p>
							<p>
								<div class="row boxComment">
									<div class="col-12">
										<form action="">
											<textarea name="" id="" cols="30" rows="10" placeholder="Say any thing?"></textarea>
											<button class="btn-default">Submit</button>
										</form>
									</div>
								</div>
							</p>
            </div>
            <div class="col-6">
							<img src="./img/products/describe-right-1.png" alt="">
							<img src="./img/products/describe-right-2.png" alt="">
						</div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->
    <?php include_once "./mvc/views/include/footer.php";?>
		<!-- Extensions -->
		<?php include_once "./mvc/views/include/footer_extensions.php";?>
  </body>
</html>
