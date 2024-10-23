<?php include("assets/common/header.php"); ?>

<?php 
  $data = getENGP($mysqli);
?>

<div class="ltn__breadcrumb-area ltn__breadcrumb-area-2 ltn__breadcrumb-color-white bg-overlay-theme-black-90 bg-image" data-bg="assets/img/bg/img-parallax.jpg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="ltn__breadcrumb-inner ltn__breadcrumb-inner-2 justify-content-between">
          <div class="section-title-area ltn__section-title-2">
            <h6 class="section-subtitle ltn__secondary-color">//  National Greening Program</h6>
            <h1 class="section-title white-color">Accomplishments</h1>
          </div>
          <div class="ltn__breadcrumb-list">
            <ul>
              <li><a href="index.php">Home</a></li>
              <li>Accomplishments</li>
              <li>Statistics</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="ltn__product-tab-area ltn__product-gutter pt-10 pb-30">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title-area text-center">
          <h1 class="section-title">National Greening Program (NGP) and Enhanced National Greening Program (ENGP) Accomplishments</h1>
        </div>
        <table class="table table-bordered table-striped" id="myTable">
          <thead>
            <tr>
              <th>Year</th>
              <th>Target Area</th>
              <th>Area Planted</th>
              <th>% Accomp</th>
              <th>Seedling Planted</th>
              <th>Jobs Generated</th>
              <th>Persons Employed</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $key) : ?>
              <tr>
                <td><?php echo strtoupper($key['year']); ?></td>
                <td><?php echo strtoupper($key['targetArea']); ?></td>
                <td><?php echo strtoupper($key['areaPlanted']); ?></td>
                <td><?php echo strtoupper($key['accomp']); ?>%</td>
                <td><?php echo strtoupper($key['seedlingPlanted']); ?></td>
                <td><?php echo strtoupper($key['jobsGenerated']); ?></td>
                <td><?php echo strtoupper($key['personsEmployed']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="ltn__product-tab-area ltn__product-gutter pt-10 pb-30">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center">
          <h3>Target Area & Area Planted</h3>
        </div>
        <canvas id="lineChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="ltn__product-tab-area ltn__product-gutter pt-10 pb-30">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="text-center">
          <h3>Jobs Generated & Persons Employed</h3>
        </div>
        <canvas id="barChart" width="400" height="200"></canvas>
      </div>
    </div>
  </div>
</div>



<?php include("assets/common/footer.php"); ?>