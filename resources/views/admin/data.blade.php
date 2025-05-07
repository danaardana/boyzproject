
<?php
// include language configuration file based on selected language
$lang = "us";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "us";
}
require_once ("./admin/lang/" . $lang . ".php");

use Illuminate\Support\Str;
?>

@extends('layouts.admin')

@include('admin.partials.navbar')  

@section("title", "| $type data ")

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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $language["Website_Content"] }}</a></li>
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
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h4 class="card-title">Data {{ ucwords($type) }}</h4>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                        <div>
                                            <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                                        data-bs-target=".modal-add">{{ $language["Add"] }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="">
                            </div>
                            <div class="card-body">
                                @if ($type === 'categories')
                                    <!-- Modal for adding item -->
                                    <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="#">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">{{ $language["Edit"] }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">   
                                                        <div class="card">      
                                                            <div class="card-body">                               
                                                                <div class="mb-3">
                                                                    <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                    <input class="form-control"  type="number" name="show_Order" id="show_Order">
                                                                </div>                                                         
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                    <input class="form-control" type="text" name="Title" id="Title" required>
                                                                </div>                                             
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                    <input class="form-control" type="url" name="link" id="link">
                                                                </div>                                                                        
                                                                <div class="mb-3">     
                                                                    <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                    <input id="image" name="image" type="file" accept="image/*" required/>                               
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    
                                    <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ $language["Show_Order"] }}</th>
                                                <th>{{ $language["Title"] }}</th>
                                                <th>{{ $language["Image"] }}</th>
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
                                                    <td>    
                                                        @if ($extraData && isset($extraData->image))
                                                        <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                        src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                        @else
                                                        Image Not Set
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($extraData && isset($extraData->link))
                                                        {{ $extraData->link }}
                                                        @else
                                                        Link Not Set
                                                        @endif</td>
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
                                                                                <img class="card-img-top img-fluid" alt="{{ ($extraData->image) ?? 'Not Set' }}" 
                                                                                src="{{ asset(($extraData->image) ?? '') }}" data-holder-rendered="true">
                                                                        </div>         
                                                                        <div class="card-body">                                 
                                                                            <div class="mb-3">
                                                                                <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                                <input class="form-control"  type="number" value="{{ $subsection->show_order }}" name="show_Order" id="show_Order">
                                                                            </div>                                                         
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                                <input class="form-control" type="text" value="{{ $subsection->content_key }}" name="Title" id="Title">
                                                                            </div>                                             
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                                <input class="form-control" type="url" value="{{ ($extraData->link) ?? 'Not Set' }}" name="link" id="link">
                                                                            </div>                                                                        
                                                                            <div class="mb-3">     
                                                                                <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                                <input id="image" name="image" type="file" accept="image/*" />                               
                                                                            </div>
                                                                        </div>
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
                                                            <input class="form-control" type="number" value="0" name="Show_Order" id="Show_Order">
                                                        </div>                                                         
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                            <input class="form-control" type="text" value="	Instagram Post " name="content_key" id="content_key" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                            <input class="form-control" type="url" value="https://www.instagram.com/p/XXXXX/" name="embed_url" id="embed_url" required>
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
                                                <th>Status</th>
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
                                                            <form action="#" method="POST">
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
                                                                        <input class="form-control" type="number" value="0" name="Show_Order" id="Show_Order">
                                                                    </div>                                                         
                                                                    <div class="mb-3">
                                                                        <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                                        <input class="form-control" type="text" value="	Instagram Post " name="content_key" id="content_key">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                        <input class="form-control" type="url" value="https://www.instagram.com/p/XXXXX/" name="embed_url" id="embed_url">
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

                                @elseif ($type === 'portofolio')           
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
                                                            <input class="form-control" type="number" name="show_order" id="show_order">
                                                        </div>                                                         
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                            <input class="form-control" type="text" name="content_key" id="content_key" required>
                                                        </div>                                                   
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                            <input class="form-control" type="text" name="content_value" id="content_value" required>
                                                        </div>                                     
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Categories"] }}</label>                        
                                                            <select class="form-control" data-trigger name="categories" id="categories" placeholder="{{ $language['Categories'] }}" multiple required>
                                                                @foreach ($allCategories as $category)
                                                                    <option value="{{ $category }}">{{ $category }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>        
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Hyperlink</label>
                                                            <input class="form-control" type="url" value="" name="link" id="example-text-input">
                                                        </div>          
                                                        <div class="mb-3">
                                                            <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                            <input id="image" name="image" type="file" accept="image/*" required/> 
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

                                    <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ $language["Show_Order"] }}</th>
                                                <th>{{ $language["Title"] }}</th>
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
                                                $categories = explode(", ", $extraData->categories);
                                            @endphp
                                                <tr>
                                                    <td>{{ $subsection->show_order }}</td>
                                                    <td>{{ $subsection->content_key }}</td>
                                                    <td>{{ $subsection->content_value }}</td>
                                                    <td>
                                                        <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                        src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            @foreach ($categories as $category)
                                                            <a href="#" class="badge bg-primary-subtle text-primary">{{ $category }}</a>
                                                            @endforeach
                                                        </div>
                                                    </td>
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
                                                                                <input class="form-control" type="number" value="{{ $subsection->show_order }}" name="show_order" id="show_order">
                                                                            </div>                                                         
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                                <input class="form-control" type="text" value="{{ $subsection->content_key }}" name="content_key" id="content_key">
                                                                            </div>                                                   
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                                <input class="form-control" type="text" value="{{ $subsection->content_value }}" name="content_value" id="content_value">
                                                                            </div>                                   
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Categories"] }}</label>                   
                                                                                <select class="form-control" data-trigger name="categories" id="categories" placeholder="{{ $language['Categories'] }}" multiple>
                                                                                @foreach ($allCategories as $category)
                                                                                    <option value="{{ $category }}" {{ in_array($category, $categories) ? 'selected' : '' }}>
                                                                                        {{ $category }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </div>                                     
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                                <input class="form-control" type="url" value="{{ $extraData->link }}" name="link" id="link">
                                                                            </div>                                                                        
                                                                            <div class="mb-3">     
                                                                                <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                                <input id="image" name="image" type="file" accept="image/*" required/>                                              
                                                                            </div>
                                                                        </div>
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
                            
                                
                                @elseif ($type === 'promotion')
                                    
                                    <!-- Modal for adding item -->
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
                                                        <div class="card">       
                                                            <div class="card-body">                       
                                                                <div class="mb-3">
                                                                    <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                    <input class="form-control" type="number" name="show_order" id="show_order">
                                                                </div>                                                         
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                    <input class="form-control" type="text" name="content_key" id="content_key" required>
                                                                </div>                                                   
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                    <input class="form-control" type="text"  name="content_value" id="content_value" required>
                                                                </div>                                        
                                                                <div class="mb-3">
                                                                    <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                    <input class="form-control" type="url"  name="link" id="link">
                                                                </div>    
                                                                <div class="mb-3">
                                                                    <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                    <input id="image" name="image" type="file" accept="image/*" required/> 
                                                                </div>
                                                            </div>
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

                                    <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ $language["Show_Order"] }}</th>
                                                <th>{{ $language["Title"] }}</th>
                                                <th>{{ $language["Description"] }}</th>
                                                <th>{{ $language["Image"] }}</th>
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
                                                        @if ($extraData && isset($extraData->image))
                                                        <img class="avatar-md" alt="{{ $extraData->image }}" 
                                                        src="{{ asset($extraData->image) }}" data-holder-rendered="true">
                                                        @else
                                                        Image Not Set
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($extraData && isset($extraData->link))
                                                        {{ $extraData->link }}
                                                        @else
                                                        Link Not Set
                                                        @endif</td>
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
                                                                                <img class="card-img-top img-fluid" alt="{{ ($extraData->image) ?? 'Not Set' }}" 
                                                                                src="{{ asset(($extraData->image) ?? '') }}" data-holder-rendered="true">
                                                                        </div>         
                                                                        <div class="card-body">                       
                                                                            <div class="mb-3">
                                                                                <label for="example-number-input" class="form-label">{{ $language["Show_Order"] }}</label>
                                                                                <input class="form-control" type="number" value="{{ $subsection->show_order }}" name="show_order" id="show_order">
                                                                            </div>                                                         
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Title"] }}</label>
                                                                                <input class="form-control" type="text" value="{{ $subsection->content_key }}" name="content_key" id="content_key">
                                                                            </div>                                                   
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">{{ $language["Description"] }}</label>
                                                                                <input class="form-control" type="text" value="{{ $subsection->content_value }}" name="content_value" id="content_value">
                                                                            </div>                                        
                                                                            <div class="mb-3">
                                                                                <label for="example-text-input" class="form-label">Hyperlink</label>
                                                                                <input class="form-control" type="url" value="{{ ($extraData->link) ?? 'Not Set' }}" name="link" id="link">
                                                                            </div>    
                                                                            <div class="mb-3">
                                                                                <label for="example-url-input" class="form-label">{{ $language["Image"] }}</label>
                                                                                <input id="image" name="image" type="file" accept="image/*"/> 
                                                                            </div>
                                                                        </div>
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
                                                            <input class="form-control" type="text" name="content_key" id="content_key" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                            <input class="form-control" type="text" name="content_value" id="content_value" required>
                                                        </div>                           
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Variations"] }}</label>
                                                            <input class="form-control" type="text" name="variation" id="variation">
                                                        </div>                                                             
                                                        <div class="mb-3 row align-items-start" style="min-height: 6rem;">                      
                                                            @for ($i = 1; $i <= 15; $i++)
                                                                <div class="col-sm-4">
                                                                    <div class="grid-example">
                                                                        <img class="rounded-circle avatar-md" alt="" 
                                                                            src="{{ asset('landing/images/team/team-' . $i . '.jpg') }}" data-holder-rendered="true">
                                                                        <code style="color:black">Avatar {{ $i }}</code>
                                                                    </div>
                                                                </div>
                                                            @endfor
                                                        </div>            
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Avatar</label>
                                                            <select required class="form-control form-select">
                                                            <option value="">{{ $language["Choose_an_Avatar"] }}</option>    
                                                                @for ($i = 1; $i <= 15; $i++)
                                                                <option value="{{ 'team-' . $i . '.jpg' }}">Avatar {{ $i }}</option>
                                                                @endfor
                                                            </select>
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
                                                    <td>{{ Str::limit($subsection->content_key, 10) }}</td>
                                                    <td>{{ Str::limit($subsection->content_value, 10)  }} </td>
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
                                                                        <input class="form-control" type="text" value="{{ $subsection->content_key }}" name="content_key" id="content_key">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                        <input class="form-control" type="text" value="{{ $subsection->content_value}}" name="content_value" id="content_value">
                                                                    </div>                           
                                                                    <div class="mb-3">
                                                                        <label for="example-text-input" class="form-label">{{ $language["Variations"] }}</label>
                                                                        <input class="form-control" type="text" value="{{ $extraData->variation }}" name="variation" id="variation">
                                                                    </div>                                                        
                                                                    <div class="mb-3 row align-items-start" style="min-height: 6rem;">                      
                                                                        @for ($i = 1; $i <= 15; $i++)
                                                                            <div class="col-sm-4">
                                                                                <div class="grid-example">
                                                                                    <img class="rounded-circle avatar-md" alt="" 
                                                                                        src="{{ asset('landing/images/team/team-' . $i . '.jpg') }}" data-holder-rendered="true">

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
                                                                            @for ($i = 1; $i <= 15; $i++)
                                                                                @php
                                                                                    $avatarPath = "landing/images/team/team-$i.jpg";
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
                                                            <input class="form-control" type="number" name="show_order" id="show_order">
                                                        </div>                                                         
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">{{ $language["Name"] }}</label>
                                                            <input class="form-control" type="text" value="TikTok Video " name="content_key" id="content_key">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                            <input class="form-control" type="url" value="https://www.tiktok.com/@boyprojects/video/123456789" name="link" id="url">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-number-input" class="form-label">{{ $language["Video_ID"] }}</label>
                                                            <input class="form-control" type="number" value="123456789" id="video_id">
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
                                                                        <input class="form-control" type="text" value="{{ $subsection->content_key }}"  name="content_key" id="content_key">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="example-url-input" class="form-label">{{ $language["Content"] }}</label>
                                                                        <input class="form-control" type="url" value="{{ $extraData->embed_url }}" name="embed_url" id="embed_url">
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
                                    
                                @else
                                    <table  id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                                <tr>
                                                    <td>No Data</td>
                                                </tr>                                    
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
<!-- choices js -->
<script src="{{ asset('admin/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

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
<!-- init js -->
<script src="{{ asset('admin/js/pages/form-advanced.init.js') }}"></script>

<script src="{{ asset('admin/js/app.js') }}"></script>

@endpush