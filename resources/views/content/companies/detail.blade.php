@extends('layouts/contentLayoutMaster')

@section('title', 'Companies')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/ui/prism.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
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

  <div class="row match-height">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> {{$company['business_name']}} <small class="text-muted"> &nbsp; ID: {{$company['id']}}</small></h4>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3"> Contact ID </dt>
            <dd class="col-sm-9"> {{$company['contact_id']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> First name </dt>
            <dd class="col-sm-9"> {{$company['first_name']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> Last name </dt>
            <dd class="col-sm-9"> {{$company['last_name']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> Email </dt>
            <dd class="col-sm-9"> {{$company['email']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> Cell phone </dt>
            <dd class="col-sm-9"> {{$company['cell_phone']}} </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">&nbsp;</h4>
          <dl class="row">
            <dt class="col-sm-3"> State </dt>
            <dd class="col-sm-9"> {{$company['state']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> City </dt>
            <dd class="col-sm-9"> {{$company['city']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> Zip code </dt>
            <dd class="col-sm-9"> {{$company['zip_code']}} </dd>
          </dl>
          <dl class="row">
            <dt class="col-sm-3"> Address </dt>
            <dd class="col-sm-9"> {{$company['address']}} </dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

  <div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="col-12">
        <h4 class="float-left mb-0">Advances</h4>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <table class="datatables-companies-advance table">
          <thead>
            <tr>
              <th>ID</th>
              <th></th>
              <th>Contact ID</th>
              <th>Advance ID</th>
              <th>Business name</th>
              <th>Full name</th>
              <th>Payment</th>
              <th>Advance status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <input type="hidden" name="contactId" id="contactId" value="{{$company['contact_id']}}" />

  <!-- Modal to show detail -->
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

</section>
<!-- users edit ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-user-edit.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection
