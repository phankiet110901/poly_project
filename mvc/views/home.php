<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Home</title>
	<!-- Header extensions -->
	<?php include_once "./mvc/views/include/header_extensions.php";?>
    <!-- custom-css -->
    <link rel="stylesheet" href="./css/main.css" />
  </head>
  <body>
	<!-- Header -->
	<?php include_once "./mvc/views/include/header.php";?>
    <section class="banner">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <img src="./img/banner1.png" alt="" />
          </div>
          <div class="col-6">
            <img src="./img/banner2.png" alt="" />
          </div>
        </div>
      </div>
    </section>
    <section class="Gday">
			<div class="container">
				<div class="row Gday-top">
					<div class="col-7">
						<img src="./img/gday.png" alt="">
					</div>
					<div class="col-5">
						<div class="gday-content">
							<h1>G'day</h1>
							<p>ɡəˈdeɪ</p>
							<p class="font-italic">good day</p>
							<p>A familiar greeting, used frequently and at any hour.</p>
							<p>Often combined with "mate", as in "G'day Mate!"</p>
							<p>The G'day Sweater, made from 100% organic cotton.</p>
							<button class="btn-default"><a href="./san-pham">SHOP NOW</a></button>
						</div>
					</div>
				</div>
				<div class="row text-center">
					<div class="col-12">
						<div class="subcrise">
							<p>Sign up to receive 10% off your first order.</p>
							<div class="email">
								<input type="text" placeholder="Your email">
								<button class="btn-default"><a href="">SUBCRISE</a></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    <section class="social">
			<div class="container-fluid text-center">
				<p class="font-weight-bold">@ryder_label</p>
				<div class="row">
					<div class="col-3">
						<img src="./img/social-1.jpg" alt="">
						<div class="black-content">
							<div class="black-hover">
							</div>
							<div class="icon-black-hover">
								<i class="fab fa-instagram"></i>
							</div>
						</div>
					</div>
					<div class="col-3">
						<img src="./img/social-2.jpg" alt="">
						<div class="black-content">
							<div class="black-hover">
							</div>
							<div class="icon-black-hover">
								<i class="fab fa-instagram"></i>
							</div>
						</div>
					</div>
					<div class="col-3">
						<img src="./img/social-3.jpg" alt="">
						<div class="black-content">
							<div class="black-hover">
							</div>
							<div class="icon-black-hover">
								<i class="fab fa-instagram"></i>
							</div>
						</div>
					</div>
					<div class="col-3">
						<img src="./img/social-4.jpg" alt="">
						<div class="black-content">
							<div class="black-hover">
							</div>
							<div class="icon-black-hover">
								<i class="fab fa-instagram"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Footer -->
		<?php include_once "./mvc/views/include/footer.php";?>
		<section class="cart d-none">
			<div class="cart-content">
				<div class="row">
					<div class="col-12">
						<div class="cart-header">
							<div class="row">
								<div class="col-6">
									<a href="">The Blue Banded Bee Tee - XS/6</a>
								</div>
								<div class="col-6">
									<p>$89.00</p>
									<button>-</button>
									<button>1</button>
									<button>+</button>
									<div>
										<i class="fa fa-times-circle"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Extensions -->
		<?php include_once "./mvc/views/include/footer_extensions.php";?>
  </body>
</html>
