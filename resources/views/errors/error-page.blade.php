<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@if(isset($errorCode) && $errorCode === 'db_error')Database Error @else{{ $errorCode ?? '404' }} Error @endif - Page Error</title>
<link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('landing/css/master.css') }}">
<link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
</head>
<body>

<!--=== Loader Start ======-->
<div id="loader-overlay">
  <div class="loader-wrapper">
    <div class="scoda-pulse"></div>
  </div>
</div>
<!--=== Loader End ======-->

<!--=== Wrapper Start ======-->
<div class="wrapper white-bg">
  <!--=== page-title-section start ===-->
  <section class="vh-height page_404 white-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-10 centerize-col text-center">
            <div class="four-zero-four-bg">
              @if(isset($errorCode) && $errorCode === 'db_error')
                <h1 class="dark-color">DATABASE ERROR</h1>
              @else
                <h1 class="dark-color">{{ strtoupper($errorCode ?? '404') }} ERROR</h1>
              @endif
            </div>
            <div class="content-box">
              @if(isset($errorCode) && $errorCode === 'db_error')
                <h2 class="cardo-font">Database Connection Lost</h2>
                <p class="cardo-font dark-color lead">We're experiencing database connectivity issues. Please try again in a few minutes.</p>
                <p class="mt-30">
                  <a href="javascript:location.reload()" class="btn btn-color btn-square">TRY AGAIN</a>
                  <a href="/" class="btn btn-color btn-square">GO TO HOME</a>
                </p>
              @elseif(isset($errorCode) && $errorCode === '500')
                <h2 class="cardo-font">Internal Server Error</h2>
                <p class="cardo-font dark-color lead">Something went wrong on our servers. Please try again later.</p>
                <p class="mt-30"><a href="/" class="btn btn-color btn-square">GO TO HOME</a></p>
              @elseif(isset($errorCode) && $errorCode === '403')
                <h2 class="cardo-font">Access Forbidden</h2>
                <p class="cardo-font dark-color lead">You don't have permission to access this resource.</p>
                <p class="mt-30"><a href="/" class="btn btn-color btn-square">GO TO HOME</a></p>
              @else
                <h2 class="cardo-font">Look like you're lost</h2>
                <p class="cardo-font dark-color lead">the page you are looking for not available!</p>
                <p class="mt-30"><a href="/" class="btn btn-color btn-square">GO TO HOME</a></p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=== page-title-section end ===-->

</div>
<!--=== Wrapper End ======-->

<!--=== Javascript Plugins ======-->
<script src="{{ asset('landing/js/jquery.min.js') }}"></script>
<script src="{{ asset('landing/js/validator.js') }}"></script>
<script src="{{ asset('landing/js/plugins.js') }}"></script>
<script src="{{ asset('landing/js/master.js') }}"></script>
<script src="{{ asset('landing/js/bootsnav.js') }}"></script>

@if(isset($errorCode) && $errorCode === 'db_error')
<script>
// Auto-retry database connection every 30 seconds for database errors
let retryCount = 0;
const maxRetries = 10;

function autoRetryConnection() {
    if (retryCount < maxRetries) {
        retryCount++;
        console.log(`Auto-retry attempt ${retryCount}/${maxRetries}`);
        
        // Try to reload the page to check if database is back
        setTimeout(() => location.reload(), 30000);
    }
}

// Start auto-retry after 30 seconds
setTimeout(autoRetryConnection, 30000);
</script>
@endif

<!--=== Javascript Plugins End ======-->

</body>
</html> 