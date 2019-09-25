<!-- LAYOUT -->
@extends('layouts.app')

<!-- NAVBAR SECTION -->
@section('navbar')
	@include('page.superadmin.nav')
@endsection

<!-- CONTENT SECTION -->
@section('content')

        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Upload License | GIS TMAPS</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputFile">Base License</label>
                  <input type="file" id="exampleInputFile">
               </div>
                <div class="form-group">
                  <label for="exampleInputFile">Chatting License</label>
                  <input type="file" id="exampleInputFile">
              </div>
              <div class="form-group">
                  <label for="exampleInputFile">Geolocation License</label>
                  <input type="file" id="exampleInputFile">
              </div>
               <div class="form-group">
                  <label for="exampleInputFile">Traffic Flow Map License</label>
                  <input type="file" id="exampleInputFile">
              </div>
               <div class="form-group">
                  <label for="exampleInputFile">CCTV Player License</label>
                  <input type="file" id="exampleInputFile">
              </div>
                

                 <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>


                
              </div>
              <!-- /.box-body -->

              
            </form>
          </div>
          <!-- /.box -->

          <!-- Form Element sizes -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">License Table | GIS Tmaps</h3>
            </div>
            <div class="box-body">
              
              
           <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>License</th>
                  <th>Description</th>
                  <th style="width: 40px">Status</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Base License</td>
                  <td>
                    GIS Map
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Chatting License</td>
                  <td>
                    50 Users
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>GeoLocation License</td>
                  <td>
                    50 Cameras
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Traffic Flow License</td>
                  <td>
                    10 Areas
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td>CCTV Player</td>
                  <td>
                    50 Cameras
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>

              </table>
          



            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
          <!-- /.box -->

          
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          
            
            <!-- /.box-header -->
            <!-- form start -->
            
             <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Upload License | VCA Pro</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputFile">Base License</label>
                  <input type="file" id="exampleInputFile">
               </div>
                <div class="form-group">
                  <label for="exampleInputFile">Chatting License</label>
                  <input type="file" id="exampleInputFile">
              </div>
              <div class="form-group">
                  <label for="exampleInputFile">Geolocation License</label>
                  <input type="file" id="exampleInputFile">
              </div>
            
                

                 <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>   
              </div>
              <!-- /.box-body --> 
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">License Table | TLAPro</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
<table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>License</th>
                  <th>Description</th>
                  <th style="width: 40px">Status</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Base License</td>
                  <td>
                    VCA Pro
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Camera Events</td>
                  <td>
                    20 Cameras
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>LPR</td>
                  <td>
                    20 Cameras
                  </td>
                  <td><span class="badge bg-green">Acctivated</span></td>
                </tr>
                

              </table>
@endsection


<!-- HEADER SECTION -->
@section('header')

@endsection

<!-- FOOTER SECTION -->
@section('footer')

@endsection