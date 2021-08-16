@extends('layouts/contentLayoutMaster')

@section('title', 'Advance')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
@endsection

@section('content')
<!-- users edit start -->
<section class="app-user-edit">
  <div class="card">
    <div class="card-body">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link d-flex align-items-center active"
            id="account-tab"
            data-toggle="tab"
            href="#account"
            aria-controls="account"
            role="tab"
            aria-selected="true"
          >
            <i data-feather="user"></i><span class="d-none d-sm-block">Information</span>
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link d-flex align-items-center"
            id="information-tab"
            data-toggle="tab"
            href="#information"
            aria-controls="information"
            role="tab"
            aria-selected="false"
          >
            <i data-feather="info"></i><span class="d-none d-sm-block">Payment details</span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <!-- Information Tab starts -->
        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">

            <!-- Description list alignment -->
            <section id="description-list-alignment">
              <div class="row match-height">
                <!-- Description lists horizontal -->
                <div class="card col-12">
                  <div class="card-header">
                    <h4 class="card-title">{{$advance['business_name']}} <small class="text-muted">Id: {{$advance['id']}}</small></h4>
                  </div>
                  <div class="card-body">
                    <div class="row col-12">
                      <?php 
                      $length = count($advance);
                      $count = 0;
                      foreach ($advance as $index => $value) { 
                        if ($index!="business_name" && $index!="id") {
                            $indexName = ucfirst(substr(str_replace("_", " ", $index),0,14));
                            if ($index=='updated_at' || $index=='created_at') {
                              $date = date_create($value);
                              $value = date_format($date,"Y-m-d H:i:s");;
                            }
                      ?>
                        <div class="col-sm-12 col-md-4" style="height:27px">
                          <dl class="row">
                            <dt class="col-sm-5">{{$indexName}}</dt>
                            <dd class="col-sm-7">{{$value}}</dd>
                          </dl>
                        </div>
                      <?php  
                          if ($count == ($length/3)) {
                            echo '</div><div class="row col-12">';
                            $count = 0;
                          } else {
                            $count++;
                          }
                        }
                      } 
                      ?>
                    </div>
                  </div>
                </div>
                <!--/ Description lists horizontal-->
              </div>
            </section>
        </div>
        <!-- Information Tab ends -->

        <!-- Payment details Tab starts -->
        <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
          <div class="card">
            <div class="card-body">
            <?php 
            foreach ($payments as $payment) { 
                $paymentReport = $payment->attributesToArray();
                if ($paymentReport['trans_type']=="ACH Client Debit") {
                  $uiFeather = "layers";
                } elseif ($paymentReport['trans_type']=="Client Refund") {
                  $uiFeather = "pocket";
                } elseif ($paymentReport['trans_type']=="Credit Card Payment") {
                  $uiFeather = "credit-card";
                } elseif ($paymentReport['trans_type']=="Adjustment") {
                  $uiFeather = "crosshair";
                } else {
                  $uiFeather = "loader";
                }
            ?>
                <div class="col-12">
                  <h4 class="mb-1">
                    <i data-feather="{{$uiFeather}}" class="font-medium-4 mr-25"></i>
                    <span class="align-middle">{{$paymentReport['trans_type']}}</span>
                  </h4>
                </div>
                <div class="row col-12" style="left:30px">
                <?php $count = 0; ?>
                <?php foreach ($paymentReport as $index => $value) { ?>
                <?php   $indexName = ucfirst(substr(str_replace("_", " ", $index),0,14)); 
                        if ($index=='updated_at' || $index=='created_at') {
                          $date = date_create($value);
                          $value = date_format($date,"Y-m-d H:i:s");;
                        }
                ?>
                    <div class="col-sm-12 col-md-4" style="height:24px">
                      <dl class="row">
                        <dt class="col-sm-5">{{$indexName}}</dt>
                        <dd class="col-sm-7">{{$value}}</dd>
                      </dl>
                    </div>
                <?php  if($count==2) {
                          echo '</div><div class="row col-12" style="left:30px">';
                          $count = 0;
                        } else {
                          $count++;
                        }
                    } ?>
                </div>
                <br />
            <?php } ?>
            </div>  
          </div>
        </div>
        <!-- Payment details Tab ends -->

      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user-edit.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection
