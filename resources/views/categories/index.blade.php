@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
          <!-- Default box -->
        <div class="card">
        <div class="card-header">
          <h3 class="card-title">Categories</h3>

          <!--div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div-->
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 15%">
                      @sortablelink('name', 'Name')
                      </th>
                      <th>
                      @sortablelink('parent.name', 'Parent Category')
                      </th>
                      <th style="width: 15%" class="text-center">
                      @sortablelink('status', 'Status')
                      </th>
                      <th style="width: 15%" class="text-center">
                      @sortablelink('created_at', 'Created On')
                      </th>
                      <th style="width: 15%" class="text-center">
                      @sortablelink('updated_at', 'Updated On')
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>
              @if (!empty($categories->count()))
                @foreach ($categories as $category)
                  <tr>
                      <td>
                      {{ $loop->index + 1 }}
                      </td>
                      <td>
                          {{ $category->name}}
                      </td>
                      <td class="project_progress">
                            @if ($category->parent)
                                {{ $category->parent->name}}
                            @else
                                -
                            @endif   
                      </td>
                      <td class="project-state">{{ $category->status ? 'Active' : 'Inactive' }}</td>
                      <td class="project-state">{{ $category->created_at ? date(config('app.date_format'),strtotime($category->created_at)) : null }}</td>
                      <td class="project-state">{{ $category->updated_at ? date(config('app.date_format'),strtotime($category->updated_at)) : null }}</td>
                      <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="{{route('categories.edit',$category->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form id="delete-form-{{$category->id}}" method="post" action="{{route('categories.destroy',$category->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$category->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i>Delete</a>
                      </td>
                  </tr>
                  @endforeach
                  @else
                    <td colspan="7"><center><b>No Record Found</b></center></td>
                    @endif
              </tbody>
             
          </table>
                                
          <div class="pagination pull-right mt-3"> {!! $categories->links() !!} </div>   
        <!-- /.card-body -->
      </div>
     
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
