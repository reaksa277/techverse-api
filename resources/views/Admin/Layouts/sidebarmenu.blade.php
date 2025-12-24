<div class="navbar-wrapper">
    <div class="m-header">
        <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
            <!-- ========   Change your logo from here   ============ -->
            <img src="{{ asset('storage/images/logo.png') }}" class="img-fluid logo-lg" alt="logo">
        </a>
    </div>
    <div class="navbar-content">
        <ul class="pc-navbar">
            <li class="pc-item">
                <a href="{{ route('admin.dashboard') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                    <span class="pc-mtext">Dashboard</span>
                </a>
            </li>

            <li class="pc-item pc-caption">
                <label>Menu</label>
                <i class="ti ti-dashboard"></i>
            </li>
            <li class="pc-item">
                <a href="{{ route('admin.slides') }}" class="pc-link" onclick="viewCarousel()">
                    <span class="pc-micon"><i class="ti ti-picture-in-picture"></i></span>
                    <span class="pc-mtext">Carousel</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    // Article
    function viewCarousel() {
        $.ajax({
            url: "{{ route('admin.slides') }}",
            type: "GET",
            success: function(response) {
                $('#containerDiv').html(response);
                unblockagePage();
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
                unblockagePage();
            }
        });
    }
</script>
