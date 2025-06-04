    <!-- Add session management and back button prevention script -->
    <script>
        // Session management and back button prevention
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent back button access after logout
            history.pushState(null, null, location.href);
            window.onpopstate = function () {
                // Check if user is still authenticated by making a simple AJAX call
                fetch('{{ route("admin.auth.check") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if (response.status === 401 || response.status === 419) {
                        // User is not authenticated, redirect to login
                        window.location.href = '{{ route("admin.login") }}';
                    } else {
                        // User is authenticated, allow normal behavior
                        history.pushState(null, null, location.href);
                    }
                }).catch(error => {
                    // On error, redirect to login for safety
                    window.location.href = '{{ route("admin.login") }}';
                });
            };

            // Additional check - verify session on page focus
            window.addEventListener('focus', function() {
                fetch('{{ route("admin.auth.check") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if (response.status === 401 || response.status === 419) {
                        alert('Your session has expired. Please login again.');
                        window.location.href = '{{ route("admin.login") }}';
                    }
                }).catch(error => {
                    console.log('Session check failed');
                });
            });

            // Periodic session check (every 5 minutes)
            setInterval(function() {
                fetch('{{ route("admin.auth.check") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if (response.status === 401 || response.status === 419) {
                        alert('Your session has expired. Please login again.');
                        window.location.href = '{{ route("admin.login") }}';
                    }
                }).catch(error => {
                    console.log('Session check failed');
                });
            }, 300000); // 5 minutes = 300000ms
        });
    </script>

</body>
</html> 