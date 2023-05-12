@extends('dashboard.layouts.main')

@section('contents')

    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        {{ $title }}
                    </h2>
                </div>                
            </div>
        </div>

        <div class="page-body">          
            <div class="row row-cards">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Standard Buttons</h3>
                  </div>
                  <div class="card-body">                    
                    <div class='tableauPlaceholder' style='width: 1680px; height: 808px;'><object class='tableauViz' width='1680' height='808' style='display:none;'><param name='host_url' value='http%3A%2F%2F172.19.2.189%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='MetadataStation&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='showAppBanner' value='false' /><param name='filter' value='iframeSizedToWindow=true' /></object></div>
                  </div>
                </div>
              </div>
            </div>          
        </div>
    </div>

    

    <script>
        
    </script>

    <script type='text/javascript' src='http://172.19.2.189/javascripts/api/viz_v1.js'></script>

@endsection
