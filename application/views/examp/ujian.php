<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ujian</title>
  <link href="<?=base_url().'assets/'?>examp/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="<?=base_url().'assets/'?>examp/jquery-1.11.1.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  <style>
  .hide-bullets {
    list-style:none;
    margin-top:20px;
  }

  .thumbnail {
      padding: 0;
  }

  .page{
    background-color:blue;
    text-align:center;
    padding:15px;
  }

  .page2{
    background-color:white;
    width: 100%;
    height:550px;
  }


  .col-sm-2 {
    padding:0;
  }

  .carousel-inner>.item>img, .carousel-inner>.item>a>img {
      width: 100%;
      height:550px;
  }
  </style>
</head>

<body style="background-color:burlywood;">
  
      <div id="main_area">
          <!-- Slider -->
          <div class="row">
              <div class="col-sm-4" id="slider-thumbs">
                  <!-- Bottom switcher of slider -->
                  <ul class="hide-bullets">
                      <li class="col-sm-2">
                          <a class="thumbnail" id="carousel-selector-0">
                            <div class="page">0</div>
                          </a>
                      </li>
  
                      <?php $x = 1; 
                        foreach($sub_question as $sq){ 
                      ?>
                      <li class="col-sm-2">
                          <a class="thumbnail" id="carousel-selector-<?=$x++?>">
                            <div class="page"><?=$x?></div>
                          </a>
                      </li>
                      <?php } ?>
                      
                  </ul>
              </div>
              <div class="col-sm-8">
                  <div class="col-xs-12" id="slider">
                      <!-- Top part of the slider -->
                      <div class="row">
                          <div class="col-sm-12" id="carousel-bounding-box">
                              <div class="carousel slide" id="myCarousel">
                                  <!-- Carousel items -->
                                  <div class="carousel-inner">
                                      <div class="active item" data-slide-number="0">
                                        <div class="page2">1sads</div>
                                      </div>
                                      <?php $y = 1; 
                                        foreach($sub_question as $sq){ 
                                      ?>              
                                      <div class="item" data-slide-number="<?=$y++?>">
                                          <div class="page2"><?=$sq['sub_question']?></div>
                                      </div>
                                      <?php } ?>
                                </div>
                                  <!-- Carousel nav -->
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--/Slider-->
          </div>
          <a href="#myCarousel" role="button" data-slide="prev">
              <button>Back</button>
          </a>
          <a href="#myCarousel" role="button" data-slide="next">
              <button>Next</button>
          </a>
      </div>
</body>

<script src="<?=base_url().'assets/'?>examp/bootstrap.min.js"></script>
<script type="application/javascript">
  jQuery(document).ready(function($) {
    $('#myCarousel').carousel({
      interval: 2000000,
    });

    //Handles the carousel thumbnails
    $('[id^=carousel-selector-]').click(function () {
    var id_selector = $(this).attr("id");
    try {
        var id = /-(\d+)$/.exec(id_selector)[1];
        console.log(id_selector, id);
        jQuery('#myCarousel').carousel(parseInt(id));
    } catch (e) {
        console.log('Regex failed!', e);
    }
    });
    // When the carousel slides, auto update the text
    $('#myCarousel').on('slid.bs.carousel', function (e) {
              var id = $('.item.active').data('slide-number');
            $('#carousel-text').html($('#slide-content-'+id).html());
    });
  });
</script>

</html>