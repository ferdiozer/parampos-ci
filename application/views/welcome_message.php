<?php

?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<div class="page-content">
    <div class="checkout">
        <div class="container">
            <form action="#" method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="checkout-title">
                            Ödeme
                            <small>(Toplam Tutar: <?=$total_price?>TL)</small>
                        </h2><!-- End .checkout-title -->

                        <label>Kart Sahibinin Adı</label>
                        <input type="text" name="card_name" class="form-control" required="">

                        <label>Kart Numarası</label>
                        <input type="text" name="card_number" class="form-control" required="">


                        <div class="row">
                            <div class="col-sm-4">
                                <label>Son Kullanım Tarihi(Ay)</label>
                                <input type="text" name="card_expmonth" class="form-control" required="">
                            </div>

                            <div class="col-sm-4">
                                <label>Son Kullanım Tarihi(Yıl)</label>
                                <input type="text" name="card_expyear"  class="form-control" required="">
                            </div>

                            <div class="col-sm-4">
                                <label>CVV</label>
                                <input type="text" name="card_cvv"  class="form-control" required="">
                            </div>
                            <div class="col-sm-12">
                            <div class="custom-control custom-checkbox">
                                <input checked name="securitypayment" type="checkbox" class="custom-control-input" id="securitypayment-2">
                                <label class="custom-control-label" for="securitypayment-2">Güvenli ödeme (3D)</label>
                            </div><!-- End .custom-checkbox -->
                            </div>
                            <div class="col-sm-12">
                            <input type="hidden" id="pos_id" name="pos_id" >
                            <input type="submit" value="Onayla" class="btn btn-outline-primary-2">
                            </div>
                        </div><!-- End .row -->

                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </form>
        </div><!-- End .container -->
    </div><!-- End .checkout -->
</div>

