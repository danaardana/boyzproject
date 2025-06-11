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

@section("title", "| Customers ")

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">

<div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Customers</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Customers</a></li>
                                    <li class="breadcrumb-item active">List</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">({{ $customers->total() ?? 0 }})</span></h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            <div>
                                <a href="#" class="btn btn-light" onclick="refreshCustomers()"><i class="bx bx-refresh me-1"></i> Refresh</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row" id="customers-container">
                    @forelse($customers ?? [] as $customer)
                    <div class="col-xl-3 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="dropdown text-end">
                                    <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                      <i class="bx bx-dots-horizontal-rounded"></i>
                                    </a>
                                  
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#" onclick="viewCustomer({{ $customer->id }})">View Details</a>
                                        <a class="dropdown-item" href="#" onclick="editCustomer({{ $customer->id }})">Edit</a>
                                        <a class="dropdown-item" href="#" onclick="sendEmailToCustomer({{ $customer->id }})">Send Email</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#" onclick="deleteCustomer({{ $customer->id }})">Remove</a>
                                    </div>
                                </div>
                                
                                <div class="avatar-xl mx-auto mb-4">
                                    <div class="avatar-title bg-light-subtle text-primary display-4 m-0 rounded-circle">
                                        <i class="bx bxs-user-circle"></i>
                                    </div>
                                </div>
                                <h5 class="font-size-16 mb-1">
                                    <a href="#" class="text-body" onclick="viewCustomer({{ $customer->id }})">
                                        {{ $customer->name ?? 'N/A' }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-2">
                                    @if($customer->email)
                                        {{ Str::limit($customer->email, 25) }}
                                    @else
                                        Customer
                                    @endif
                                </p>
                                <p class="text-muted mb-2 small">
                                    @if($customer->phone)
                                        <i class="bx bx-phone me-1"></i>{{ Str::limit($customer->phone, 15) }}
                                    @endif
                                </p>
                                <p class="text-muted mb-2 small">
                                    <i class="bx bx-calendar me-1"></i>{{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}
                                </p>
                                
                            </div>

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-light text-truncate" onclick="viewCustomer({{ $customer->id }})">
                                    <i class="uil uil-user me-1"></i> Profile
                                </button>
                                <button type="button" class="btn btn-outline-light text-truncate" onclick="sendEmailToCustomer({{ $customer->id }})">
                                    <i class="uil uil-envelope-alt me-1"></i> Message
                                </button>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    @empty
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="avatar-xl mx-auto mb-4">
                                    <div class="avatar-title bg-light-subtle text-muted display-4 m-0 rounded-circle">
                                        <i class="bx bx-user-x"></i>
                                    </div>
                                </div>
                                <h5 class="font-size-16 mb-1">No Customers Found</h5>
                                <p class="text-muted mb-4">There are currently no customers in the system.</p>
                                <a href="#" class="btn btn-primary" onclick="refreshCustomers()">
                                    <i class="bx bx-refresh me-1"></i> Refresh
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <!-- end row -->

                @if(isset($customers) && $customers->hasPages())
                <div class="row g-0 align-items-center mb-4">
                    <div class="col-sm-6">
                        <div>
                            <p class="mb-sm-0">
                                Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} 
                                of {{ $customers->total() ?? 0 }} entries
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-end">
                            {{ $customers->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                @endif
                <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

<!-- Customer Details Modal -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModalLabel">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="customerModalBody">
                <!-- Customer details will be loaded here -->
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" onsubmit="updateCustomer(event)">
                <div class="modal-body">
                    <input type="hidden" id="editCustomerId" name="customer_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCustomerName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="editCustomerName" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCustomerEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="editCustomerEmail" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCustomerPhone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="editCustomerPhone" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="editCustomerAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="editCustomerAddress" name="address">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm" onsubmit="sendCustomerEmail(event)">
                <div class="modal-body">
                    <input type="hidden" id="emailCustomerId" name="customer_id">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-send me-1"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Customer management functions
function viewCustomer(customerId) {
    console.log('viewCustomer called with ID:', customerId);
    const modal = new bootstrap.Modal(document.getElementById('customerModal'));
    
    // Show loading state
    document.getElementById('customerModalBody').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    modal.show();
    
    fetch(`/admin/customers/${customerId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const customer = data.customer;
            document.getElementById('customerModalBody').innerHTML = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="avatar-xl mx-auto mb-4">
                            <div class="avatar-title bg-light-subtle text-primary display-4 m-0 rounded-circle">
                                <i class="bx bxs-user-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5>${customer.name || 'N/A'}</h5>
                        <p class="text-muted mb-2">
                            <i class="bx bx-envelope me-2"></i>${customer.email || 'N/A'}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bx bx-phone me-2"></i>${customer.phone || 'N/A'}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bx bx-map me-2"></i>${customer.address || 'No address provided'}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bx bx-calendar me-2"></i>Joined: ${customer.created_at || 'N/A'}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bx bx-time me-2"></i>Last Updated: ${customer.updated_at || 'N/A'}
                        </p>
                    </div>
                </div>
            `;
        } else {
            document.getElementById('customerModalBody').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    ${data.message || 'Error loading customer details.'}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('customerModalBody').innerHTML = `
            <div class="alert alert-danger" role="alert">
                Error loading customer details: ${error.message}. Please try again.
            </div>
        `;
    });
}

function sendEmailToCustomer(customerId) {
    document.getElementById('emailCustomerId').value = customerId;
    const modal = new bootstrap.Modal(document.getElementById('emailModal'));
    modal.show();
}

function sendCustomerEmail(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    fetch('/admin/customers/send-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('emailModal')).hide();
            showAlert('success', 'Email sent successfully!');
            document.getElementById('emailForm').reset();
        } else {
            showAlert('danger', data.message || 'Error sending email');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Error sending email. Please try again.');
    });
}

function editCustomer(customerId) {
    console.log('editCustomer called with ID:', customerId);
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    
    // Fetch customer data to populate the form
    fetch(`/admin/customers/${customerId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Edit response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Edit response data:', data);
        if (data.success) {
            const customer = data.customer;
            
            // Populate the edit form
            document.getElementById('editCustomerId').value = customer.id;
            document.getElementById('editCustomerName').value = customer.name || '';
            document.getElementById('editCustomerEmail').value = customer.email || '';
            document.getElementById('editCustomerPhone').value = customer.phone || '';
            document.getElementById('editCustomerAddress').value = customer.address || '';
            
            modal.show();
        } else {
            showAlert('danger', data.message || 'Error loading customer data for editing');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', `Error loading customer data: ${error.message}. Please try again.`);
    });
}

function updateCustomer(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const customerId = formData.get('customer_id');
    const data = Object.fromEntries(formData.entries());
    
    // Remove customer_id from data as it's in the URL
    delete data.customer_id;
    
    fetch(`/admin/customers/${customerId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            showAlert('success', 'Customer updated successfully!');
            // Refresh the page to show updated data
            setTimeout(() => {
                refreshCustomers();
            }, 1500);
        } else {
            showAlert('danger', data.message || 'Error updating customer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Error updating customer. Please try again.');
    });
}

function deleteCustomer(customerId) {
    if (confirm('Are you sure you want to delete this customer?')) {
        fetch(`/admin/customers/${customerId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Customer deleted successfully!');
                refreshCustomers();
            } else {
                showAlert('danger', data.message || 'Error deleting customer');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Error deleting customer. Please try again.');
        });
    }
}

function refreshCustomers() {
    window.location.reload();
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Insert alert at the top of the page content
    const pageContent = document.querySelector('.page-content .container-fluid');
    pageContent.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = pageContent.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script>

<!-- End Page-content -->

    @include('admin.partials.footer')
    
</div>

@endsection
