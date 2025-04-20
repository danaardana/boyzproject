
<?php
// include language configuration file based on selected language
$lang = "en";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "en";
}
require_once ("./admin/lang/" . $lang . ".php");

?>

@extends('layouts.admin')

@section("title", "Data ")

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                    <li class="breadcrumb-item active">{{ ucwords($type) }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="col-2">
                                        <h4 class="card-title">{{ ucwords($type) }}</h4>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-light waves-effect" data-bs-toggle="modal"
                                    data-bs-target=".modal-add">{{ $language["Add"] }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                            @if ($type === 'portofolio')                 
                                <!--  Modal to add a new item -->
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Add"] }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">   
                                                    <div class="mb-3">
                                                        <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                        <input class="form-control" type="number" value="0" id="example-number-input">
                                                    </div>                                                         
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Tittle"] }}</label>
                                                        <input class="form-control" type="text" value=" " id="example-text-input">
                                                    </div>                                                   
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                        <input class="form-control" type="text" value=" " id="example-text-input">
                                                    </div>                                   
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Categories"] }}</label>
                                                        <input class="form-control" type="text" value="{{ $language['Categories'] }},{{ $language['Categories'] }} " id="example-text-input">
                                                    </div>                         
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Hyperlink</label>
                                                        <input class="form-control" type="text" value=" " id="example-text-input">
                                                    </div>          
                                                    <div class="mb-3">
                                                        <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                        <input class="form-control" type="url" value=" " id="example-url-input">
                                                    </div>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Tittle"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Image"] }}</th>
                                            <th>{{ $language["Categories"] }}</th>
                                            <th>Hyperlink</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $subsection->content_value }}</td>
                                                <td>
                                                    <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                    src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                </td>
                                                <td>{{ $extraData->categories }}</td>
                                                <td>{{ $extraData->link }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $subsection->id }}"></button>
                                                </td>
                                            </tr>
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $subsection->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">   
                                                                <div class="card">
                                                                    <div class="">
                                                                            <img class="card-img-top img-fluid" alt="{{ $extraData->image }}" 
                                                                            src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                                    </div>         
                                                                    <div class="card-body">                       
                                                                        <div class="mb-3">
                                                                            <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                            <input class="form-control" type="number" value="{{ $subsection->show_order }}" id="example-number-input">
                                                                        </div>                                                         
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">{{ $language["Tittle"] }}</label>
                                                                            <input class="form-control" type="text" value="{{ $subsection->content_key }}" id="example-text-input">
                                                                        </div>                                                   
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                            <input class="form-control" type="text" value="{{ $subsection->content_value }}" id="example-text-input">
                                                                        </div>                                   
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">{{ $language["Categories"] }}</label>
                                                                            <input class="form-control" type="text" value="{{ $extraData->categories }}" id="example-text-input">
                                                                        </div>                                     
                                                                        <div class="mb-3">
                                                                            <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                            <input class="form-control" type="text" value="{{ $extraData->link }}" id="example-text-input">
                                                                        </div>                                                                        
                                                                        <div class="mb-3">     
                                                                            <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                            <input class="form-control" type="url" value="{{ $extraData->image }}" id="example-url-input">                                                
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>

                            @elseif ($type === 'instagram')                            
                                <!--  Modal to add a new item -->
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">   
                                                    <div class="mb-3">
                                                        <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                        <input class="form-control" type="number" value="0" id="Show_Order">
                                                    </div>                                                         
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                        <input class="form-control" type="text" value="	Instagram Post " id="content_key">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                        <input class="form-control" type="url" value="https://www.instagram.com/p/XXXXX/" id="embed_url">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Edit"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $extraData->embed_url }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $subsection->id }}"></button>
                                                </td>
                                            </tr>
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $subsection->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('section_content.update', ['id' => $subsection->id, 'type' => request()->query('type')]) }}" method="POST">
                                                            @csrf
                                                            
                                                            @if(isset($subsection))
                                                                @method("PUT")
                                                            @endif
                                                            
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">   
                                                                <div class="mb-3">
                                                                    <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                    <input class="form-control" type="number" value="{{ $subsection->show_order }}" id="Show_Order">
                                                                </div>                                                         
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $subsection->content_key }}" id="content_key">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                    <input class="form-control" type="url" value="{{ $extraData->embed_url }}" id="embed_url">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>

                            @elseif ($type === 'tiktok')
                                <!-- Modal to add a new item -->
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">   
                                                    <div class="mb-3">
                                                        <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                        <input class="form-control" type="number" value="0" id="show_order">
                                                    </div>                                                         
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                        <input class="form-control" type="text" value="TikTok Video " id="content_key">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                        <input class="form-control" type="url" value="https://www.tiktok.com/@boyprojects/video/123456789" id="embed_url">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-number-input" class="form-label">{{ $language["Video_ID"] }}</label>
                                                        <input class="form-control" type="number" value="123456789" id="video_id">
                                                    </div>     
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Show_Order"] }}</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Video_ID"] }}</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->show_order }}</td>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $extraData->embed_url }}</td>
                                                <td>{{ $extraData->video_id }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $subsection->id }}"></button>
                                                </td>
                                            </tr>
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $subsection->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('section_content.update', $subsection->id) }}" method="POST">
                                                            @csrf
                                                            
                                                            @if(isset($subsection))
                                                                @method("PUT")
                                                            @endif

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">   
                                                                <div class="mb-3">
                                                                    <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                    <input class="form-control" type="number" value="{{ $subsection->show_order }}" id="show_order">
                                                                </div>                                                         
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $subsection->content_key }}" id="content_value">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                    <input class="form-control" type="url" value="{{ $extraData->embed_url }}" id="embed_url">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="example-number-input" class="form-label">{{ $language["Video_ID"] }}</label>
                                                                    <input class="form-control" type="number" value="{{ $extraData->video_id }}" id="video_id">
                                                                </div>     
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            @elseif ($type === 'testimonials')
                                <!-- Modal to add a new item -->                             
                                <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form>
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">                                    
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                        <input class="form-control" type="text" value="Custumer Name/username" id="example-text-input">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                        <input class="form-control" type="url" value="Message" id="example-url-input">
                                                    </div>                           
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">{{ $language["Variations"] }}</label>
                                                        <input class="form-control" type="text" value=" " id="example-text-input">
                                                    </div>                                                        
                                                    <div class="mb-3 row align-items-start" style="min-height: 6rem;">                      
                                                        @for ($i = 1; $i <= 6; $i++)
                                                            <div class="col-sm-4">
                                                                <div class="grid-example">
                                                                    <img class="rounded-circle avatar-md" alt="" 
                                                                        src="{{ asset('landing/images/team/avatar-' . $i . '.jpg') }}" data-holder-rendered="true">
                                                                    <code style="color:black">Avatar {{ $i }}</code>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>            
                                                    <div class="mb-3">
                                                        <label for="example-text-input" class="form-label">Avatar</label>
                                                        <select required class="form-control form-select">
                                                        <option value="">{{ $language["Choose_an_Avatar"] }}</option>    
                                                            @for ($i = 1; $i <= 6; $i++)
                                                               <option value="{{ 'avatar-' . $i . '.jpg' }}">Avatar {{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->

                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>Avatar</th>
                                            <th>{{ $language["Variations"] }}</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($SectionContents as $subsection)
                                        @php
                                            $extraData = json_decode($subsection->extra_data);
                                        @endphp
                                            <tr>
                                                <td>{{ $subsection->content_key }}</td>
                                                <td>{{ $subsection->content_value }}</td>
                                                <td>
                                                    <img class="rounded-circle avatar-md" alt="{{ $extraData->image }}" 
                                                    src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                </td>
                                                <td>{{ $extraData->variation }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light waves-effect bx bx-pencil" data-bs-toggle="modal"
                                                    data-bs-target=".modal-{{ $subsection->id }}"></button>
                                                </td>
                                            </tr>                                            
                                    
                                            <!-- Modal for updating item -->
                                            <div class="modal fade modal-{{ $subsection->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form>
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">                                    
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $subsection->content_key }}" id="example-text-input">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                    <input class="form-control" type="url" value="{{ $subsection->content_value}}" id="example-url-input">
                                                                </div>                           
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Variations"] }}</label>
                                                                    <input class="form-control" type="text" value="{{ $extraData->variation }}" id="example-text-input">
                                                                </div>                                                        
                                                                <div class="mb-3 row align-items-start" style="min-height: 6rem;">                      
                                                                    @for ($i = 1; $i <= 6; $i++)
                                                                        <div class="col-sm-4">
                                                                            <div class="grid-example">
                                                                                <img class="rounded-circle avatar-md" alt="" 
                                                                                    src="{{ asset('landing/images/team/avatar-' . $i . '.jpg') }}" data-holder-rendered="true">

                                                                                @if ($extraData->image === 'landing/images/team/avatar-' . $i . '.jpg')
                                                                                    <code><b>Avatar {{ $i }} (Selected)</b></code>
                                                                                @else
                                                                                    <code style="color:black">Avatar {{ $i }}</code>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endfor
                                                                </div>            
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">Avatar</label>
                                                                    <select required class="form-control form-select">
                                                                    <option value="">Pilih Avatar</option>    
                                                                        @for ($i = 1; $i <= 6; $i++)
                                                                            @php
                                                                                $avatarPath = "landing/images/team/avatar-$i.jpg";
                                                                            @endphp
                                                                            <option value="{{ $avatarPath }}" 
                                                                                @if (isset($extraData->image) && $extraData->image === $avatarPath) selected @endif>
                                                                                Avatar {{ $i }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h2>All Sections</h2>
                                <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ $language["Name"] }}</th>
                                            <th>{{ $language["Tittle"] }}</th>
                                            <th>{{ $language["Description"] }}</th>
                                            <th>{{ $language["Content"] }}</th>
                                            <th>{{ $language["Btn_Text"] }}</th>
                                            <th>{{ $language["Btn_URL"] }}</th>
                                            <th>{{ $language["Active"] }}</th>
                                            <th>{{ $language["Show_Order"] }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sections as $section)
                                            <tr>
                                                <td>{{ $section->id }}</td>
                                                <td>{{ $section->name }}</td>
                                                <td>{{ $section->title }}</td>
                                                <td>{{ $section->description }}</td>
                                                <td>{{ $section->content }}</td>
                                                <td>{{ $section->butten_text }}</td>
                                                <td>{{ $section->butten_link }}</td>
                                                <td>{{ $section->is_active ? 'Active' : 'Non Active' }}</td>
                                                <td>{{ $section->show_order }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            </div>
                            
                        </div>
                        <!-- end cardaa -->
                    </div> <!-- end col -->
                </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection

@push("styles")
<!-- DataTables -->
<link href="{{ asset('admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push("scripts")

<!-- Required datatable js -->
<script src="{{ asset('admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ asset('admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ asset('admin/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

@endpush