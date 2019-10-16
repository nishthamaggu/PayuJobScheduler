@extends('layouts.app')

@section('title', 'Jobs')
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card table-with-switches">
            <div class="card-header ">
              <h4 class="card-title">Downloads</h4>
            </div>
            <div class="card-body table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Merchent Id</th>
                    <th>Reports</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($files->items() as $key => $file)
                    <tr>
                      <td>{{ $file->created_at }}</td>
                      <td>{{ $file->job_id }}</td>
                      <td>{{ $file->file_path }}</td>
                      <td>
                        <form action="{{route('download', ['file_path' => $file->file_path])}}" method="get">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-warning ">
                              Download
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            {{ $files->links() }}
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection