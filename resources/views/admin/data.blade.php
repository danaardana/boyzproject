
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
                                                <form id="add-category-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                                                        <div class="modal-body">
                                        <div class="row">
                                            <!-- Basic Information -->
                                            <div class="col-lg-6">
                                                <div class="card border">
                                                    <div class="card-header bg-light">
                                                        <h6 class="card-title mb-0">
                                                            <i class="mdi mdi-information-outline me-1"></i>Category Information
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="category-title" class="form-label">{{ $language["Title"] }} <span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" name="Title" id="category-title" placeholder="Enter category title" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="category-link" class="form-label">Hyperlink</label>
                                                            <input class="form-control" type="url" name="link" id="category-link" placeholder="https://example.com">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="category-order" class="form-label">{{ $language["Show_Order"] }}</label>
                                                            <input class="form-control" type="number" name="show_Order" id="category-order" min="0" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Image Upload -->
                                            <div class="col-lg-6">
                                                <div class="card border">
                                                    <div class="card-header bg-light">
                                                        <h6 class="card-title mb-0">
                                                            <i class="mdi mdi-image-outline me-1"></i>{{ $language["Image"] }}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="category-image" class="form-label">{{ $language["Image"] }} <span class="text-danger">*</span></label>
                                                            <input id="category-image" name="image" type="file" accept="image/*" class="form-control" required>
                                                            <small class="text-muted">Recommended size: 300x300px, Max: 2MB</small>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="border rounded p-4 bg-light">
                                                                <i class="mdi mdi-cloud-upload display-4 text-muted"></i>
                                                                <p class="text-muted mb-0 mt-2">Upload category image</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bx-save me-1"></i>Save {{ ucfirst($type) }}
                                                        </button>
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
                                                <th>Actions</th>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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
                                                <form id="add-instagram-form">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
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
                                                <th>Actions</th>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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
                                                <form id="add-portofolio-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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
                                                <form id="add-promotion-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
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
                                                <th>Actions</th>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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
                                                <form id="add-testimonials-form">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
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
                                                <form id="add-tiktok-form">
                                                    @csrf
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myLargeModalLabel">Add {{ ucfirst($type) }}</h5>
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
                                                <th>Actions</th>
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
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm edit-item" 
                                                                    data-id="{{ $subsection->id }}" title="Edit">
                                                                <i class="bx bx-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm delete-item" 
                                                                    data-id="{{ $subsection->id }}" title="Delete">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                        
                                                <!-- Static modals removed - using dynamic AJAX modals -->
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

<style>
.badge-soft-primary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }
.badge-soft-success { background-color: rgba(52, 168, 83, 0.1); color: #34a853; }
.badge-soft-danger { background-color: rgba(234, 67, 53, 0.1); color: #ea4335; }
.badge-soft-warning { background-color: rgba(251, 188, 52, 0.1); color: #fbbc34; }
.badge-soft-info { background-color: rgba(52, 168, 226, 0.1); color: #34a8e2; }
.badge-soft-secondary { background-color: rgba(116, 120, 141, 0.1); color: #74788d; }

.card-title-desc { 
    font-size: 0.875rem; 
    color: #6c757d; 
}
</style>
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

<script>
$(document).ready(function() {
    const currentType = "{{ $type }}";
    let currentEditId = null;

    // DataTable is already initialized by datatables.init.js

    // Form submission handlers for adding new items
    $('[id^="add-"]').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        formData.append('type', currentType);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Show loading state
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.html();
        submitBtn.html('<i class="bx bx-loader bx-spin"></i> Saving...').prop('disabled', true);

        $.ajax({
            url: "{{ route('admin.section-content.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Close modal and reset form
                    $('.modal-add').modal('hide');
                    $(e.target)[0].reset();
                    
                    // Reload page to show new data
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showAlert('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Edit button handler
    $('.edit-item').on('click', function() {
        let itemId = $(this).data('id');
        currentEditId = itemId;
        
        // Show edit modal based on type
        showEditModal(itemId);
    });

    // Delete button handler
    $('.delete-item').on('click', function() {
        let itemId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this item?')) {
            deleteItem(itemId);
        }
    });

    // Function to show edit modal
    function showEditModal(itemId) {
        $.ajax({
            url: "{{ route('admin.section-content.edit', ':id') }}".replace(':id', itemId),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    let data = response.data;
                    let extraData = data.extra_data || {};
                    
                    // Create and show edit modal
                    let modalHtml = generateEditModal(data, extraData);
                    
                    // Remove existing edit modal if any
                    $('#edit-modal').remove();
                    
                    // Add modal to body
                    $('body').append(modalHtml);
                    
                    // Show modal
                    $('#edit-modal').modal('show');
                    
                    // Initialize form submission
                    initEditFormSubmission();
                } else {
                    showAlert('error', 'Failed to load item data');
                }
            },
            error: function() {
                showAlert('error', 'Failed to load item data');
            }
        });
    }

    // Function to generate edit modal HTML
    function generateEditModal(data, extraData) {
        let formFields = '';
        
        // Common fields
        formFields += `
            <div class="mb-3">
                <label class="form-label">Show Order</label>
                <input class="form-control" type="number" name="show_order" value="${data.show_order || 0}">
            </div>
        `;

        // Type-specific fields
        switch (currentType) {
            case 'categories':
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="Title" value="${data.content_key}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hyperlink</label>
                        <input class="form-control" type="url" name="link" value="${extraData.link || ''}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                        ${extraData.image ? `<small class="text-muted">Current: ${extraData.image}</small>` : ''}
                    </div>
                `;
                break;

            case 'instagram':
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="content_key" value="${data.content_key}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instagram URL <span class="text-danger">*</span></label>
                        <input class="form-control" type="url" name="embed_url" value="${extraData.embed_url || ''}" required>
                    </div>
                `;
                break;

            case 'portofolio':
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="content_key" value="${data.content_key}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content_value" required>${data.content_value}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categories</label>
                        <input class="form-control" type="text" name="categories" value="${extraData.categories || ''}" placeholder="Category1, Category2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hyperlink</label>
                        <input class="form-control" type="url" name="link" value="${extraData.link || ''}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                        ${extraData.image ? `<small class="text-muted">Current: ${extraData.image}</small>` : ''}
                    </div>
                `;
                break;

            case 'tiktok':
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="content_key" value="${data.content_key}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">TikTok URL <span class="text-danger">*</span></label>
                        <input class="form-control" type="url" name="embed_url" value="${extraData.embed_url || ''}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video ID</label>
                        <input class="form-control" type="text" name="video_id" value="${extraData.video_id || ''}">
                    </div>
                `;
                break;

            default:
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input class="form-control" type="text" name="content_key" value="${data.content_key}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content_value">${data.content_value}</textarea>
                    </div>
                `;
                break;
        }

        return `
            <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form id="edit-form" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="${currentType}">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit ${currentType.charAt(0).toUpperCase() + currentType.slice(1)}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${formFields}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i>Update Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to initialize edit form submission
    function initEditFormSubmission() {
        $('#edit-form').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Show loading state
            let submitBtn = $(this).find('button[type="submit"]');
            let originalText = submitBtn.html();
            submitBtn.html('<i class="bx bx-loader bx-spin"></i> Updating...').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.section-content.update', ':id') }}".replace(':id', currentEditId),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        
                        // Close modal
                        $('#edit-modal').modal('hide');
                        
                        // Reload page to show updated data
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('error', response.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    // Reset button state
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    }

    // Function to delete item
    function deleteItem(itemId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('admin.section-content.destroy', ':id') }}".replace(':id', itemId),
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    
                    // Reload page to show updated data
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', response.message || 'Failed to delete item');
                }
            },
            error: function() {
                showAlert('error', 'Failed to delete item');
            }
        });
    }

    // Function to show alerts
    function showAlert(type, message) {
        let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        let alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top of the page content
        $('.page-content .container-fluid').prepend(alertHtml);
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>

@endpush