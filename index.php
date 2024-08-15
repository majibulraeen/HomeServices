<?php
include_once "./include/header.php"; 
?>
<style type="text/css">
  .back-image {
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
  min-height: 90vh;
  border-radius: 0px;
  margin-top:auto;
  height: 300px;
}
#Services{
  height: 400px;
}
</style>
  <!-- Start Header Jumbotron-->
  <header class="jumbotron back-image" style="background-image: url(./images/logo.png);">
    <div class="myclass mainHeading">
      <h1 class="text-uppercase text-danger font-weight-bold">Welcome to Home Services</h1>
      <h3 class="font-italic">Customer's Happiness is our Aim</h3>
      <a href="./login.php" class="btn btn-success mr-4">Login</a>
      <a href="./register.php" class="btn btn-danger mr-4">Register As Provider</a>
    </div>
  </header> <!-- End Header Jumbotron -->


  <div class="container">
    <!--Introduction Section-->
    <div class="jumbotron">
      <h3 class="text-center">Home Services</h3>
      <p>
        Home Services is Nepal leading chain of multi-brand Electronics and Electrical service
        workshops offering
        wide array of services. We focus on enhancing your uses experience by offering world-class
        Electronic
        Appliances maintenance services. Our sole mission is “To provide Electronic Appliances care
        services to
        keep the devices fit and healthy and customers happy and smiling”.

        With well-equipped Electronic Appliances service centres and fully trained mechanics, we
        provide quality
        services with excellent packages that are designed to offer you great savings.

        Our state-of-art workshops are conveniently located in many cities across the country. Now you
        can book
        your service online by doing Registration.
      </p>
    </div>
  </div>
  <!--Introduction Section End-->
  <!-- Start Services -->
  <div class="container text-center border-bottom" id="Services">
    <h2>Our Services</h2>
    <div class="row mt-4">
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fa fa-tv fa-5x text-success"></i></a>
        <h4 class="mt-4">Electronic Appliances</h4>
      </div>
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fa fa-sliders fa-5x text-primary"></i></a>
        <h4 class="mt-4">Home Cleaning</h4>
      </div>
      <div class="col-sm-4 mb-4">
        <a href="#"><i class="fa fa-cogs fa-5x text-info"></i></a>
        <h4 class="mt-4">Fault Repair</h4>
      </div>
    </div>
  </div> <!-- End Services -->
  
<?php include_once "include/footer.php";

