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
                <a href="{{ route('admin.article') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                    <span class="pc-mtext">Articles</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('admin.categoryarticles') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-files"></i></span>
                    <span class="pc-mtext">Category Articles</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('admin.slides') }}" class="pc-link">
                    <span class="pc-micon"><i class="ti ti-picture-in-picture"></i></span>
                    <span class="pc-mtext">Carousel</span>
                </a>
            </li>
        </ul>
    </div>
</div>
