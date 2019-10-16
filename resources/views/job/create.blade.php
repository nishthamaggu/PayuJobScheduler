@extends('layouts.app')

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card stacked-form">
          <div class="card-header ">
            <h4 class="card-title">Schedule Report</h4>
          </div>
          <div class="card-body ">
            <form method="POST" action={{route('job.store') }} enctype="multipart/form-data">
              @csrf
              <div class="form-group ">
                <label>Query*</label>          
                <input type="text" name="query"  class="form-control" placeholder="Enter query here..." 
                row="4" maxlength="1000" required="" id="" required >
              </div>
              <div class="form-group ">
                <label>Job time*</label>          
                <input type="time" name="start_time" class="form-control" required="" id="" required >
              </div>
              
              <label>Routine*</label><br>
              <div class="form-check">
                <div class="form-check form-check-inline">
                  <input class="form-check-input"  name="routine" type="radio" id="hourly" value="hourly">
                  <label class="form-check-label" for="hourly">Hourly</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" name="routine" type="radio" id="daily" value="daily">
                  <label class="form-check-label" for="daily">Daily</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" name="routine" type="radio" id="weekly" value="weekly">
                  <label class="form-check-label" for="weekly">Weekly</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" name="routine" type="radio" id="monthly" value="monthly">
                  <label class="form-check-label" for="monthly">Monthly</label>
                </div>
              </div><br>

              <label>Output File*</label> 
              <div class="form-check">
                <div class="form-check form-check-inline">
                  <input class="form-check-input"  name="type" type="radio" id="csv" value="csv">
                  <label class="form-check-label" for="csv">Csv</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" name="type" type="radio" id="xls" value="xls">
                  <label class="form-check-label" for="xls">Xls</label>
                </div>
              </div><br>

              <div class="card-footer ">
                <input type="submit" class="btn btn-fill btn-warning">
              </div>
            </form>
          </div>
        </div>
        <div class="card stacked-form">
        </div>
      </div>
    </div>
  </div>
</div>


@endsection