@extends('layouts.app')
  <!-- jQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users <input type="hidden" name="role" id="role" value="{{request('role')}}" /></li>
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
                <h3 class="card-title">Users</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="usersData" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <!--th>Updated On</th-->
                    <th class="nowrap" width="20%"></th>
                  </tr>
                  </thead>
                  <tfoot>
				          <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <!--th>Updated On</th-->
                    <th></th>
                  </tr>
                  </tfoot>
                </table>
                <!-- Script -->
                <script type="text/javascript">
                  $(document).ready(function(){

                    // DataTable
                    $('#usersData').DataTable({
                      'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1] /* 1st one, start by the right */
                    }],
                    "order": [[ 5, "desc" ]],
                      processing: true,
                      serverSide: true,
                      //ajax: "{{route('users.getUsers')}}",
                      ajax: {
                          url: "{{ route('users.getUsers') }}",
                          data: function (d) {
                                d.role = $('#role').val()
                            }
                        },
                      columns: [
                          { data: 'id' },
                          { data: 'name' },
                          { data: 'email' },
                          { data: 'role_id' },
                          { data: 'is_active' },
                          { data: 'created_at' },
                          //{ data: 'updated_at' },
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