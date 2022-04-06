@extends('layouts.app')
  <!-- jQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('content')

    <!-- Content Header (Page header) -->
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Companies</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Companies</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->  
    
    
      <!-- Main content -->
      <section class="content">
        
        <div class="container-fluid">
            <div class="row">
              <div class="col-12">
    
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Companies</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="comnpaniesData" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th></th>
                      </tr>
                      </tfoot>
                    </table>
                    <!-- Script -->
                    <script type="text/javascript">
                      $(document).ready(function(){

                        // DataTable
                        $('#comnpaniesData').DataTable({
                          'aoColumnDefs': [{
                              'bSortable': false,
                              'aTargets': [-1] /* 1st one, start by the right */
                          }],
                          "order": [[ 3, "desc" ]],    
                          processing: true,
                          serverSide: true,
                          ajax: "{{route('companies.getCompanies')}}",
                          columns: [
                              { data: 'id' },
                              { data: 'name' },
                              { data: 'status' },
                              { data: 'created_at' },
                              { data: 'updated_at' },
                              { data: 'action' },
                          ]
                        });

                      });
                      </script>                    
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

@endsection




