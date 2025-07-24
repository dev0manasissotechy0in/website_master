<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link active" href="{{url('admin/dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#blogs-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Blogs</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blogs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{url('admin/blogs')}}">
            <i class="bi bi-circle"></i><span>All Blogs</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/blog-category')}}">
            <i class="bi bi-circle"></i><span>Blog Category</span>
            </a>
        </li>
        </ul>
    </li><!-- End Tables Nav -->
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{url('admin/products')}}">
            <i class="bi bi-circle"></i><span>All Products</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/author-products')}}">
            <i class="bi bi-circle"></i><span>Author Products</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/product-category')}}">
            <i class="bi bi-circle"></i><span>Categories</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/product-sub-category')}}">
            <i class="bi bi-circle"></i><span>Sub Categories</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/product-tags')}}">
            <i class="bi bi-circle"></i><span>Tags</span>
            </a>
        </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/users')}}">
        <i class="bi bi-people"></i>
        <span>Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/sellers')}}">
        <i class="bi bi-people"></i>
        <span>Sellers</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/newsletter-subscribers')}}">
        <i class="bi bi-newspaper"></i>
        <span>Newsletter Subscribers</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/product-reviews')}}">
        <i class="bi bi-star"></i>
        <span>Product Reviews</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/orders')}}">
        <i class="bi bi-list"></i>
        <span>Orders</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#withdraw-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-card-heading"></i><span>Withdrawals</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="withdraw-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{url('admin/withdraw-requests')}}">
            <i class="bi bi-circle"></i><span>Withdraw Request</span>
            </a>
        </li>
        <li>
            <a href="{{url('admin/withdraw-methods')}}">
            <i class="bi bi-circle"></i><span>Withdraw Methods</span>
            </a>
        </li>
        </ul>
    </li>
    <li class="nav-heading">Settings</li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/pages')}}">
        <i class="bi bi-stickies"></i>
        <span>Pages</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/testimonials')}}">
        <i class="bi bi-person-lines-fill"></i>
        <span>Testimonials</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/general-settings')}}">
        <i class="bi bi-gear"></i>
        <span>General Settings</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/homepage-settings')}}">
        <i class="bi bi-card-list"></i>
        <span>Homepage Settings</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/payment-gateways')}}">
        <i class="bi bi-compass"></i>
        <span>Payment Gateways</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/payment-settings')}}">
        <i class="bi bi-compass"></i>
        <span>Payment Settings</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/banner')}}">
        <i class="bi bi-compass"></i>
        <span>Banner</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/social-links')}}">
        <i class="bi bi-box"></i>
        <span>Social Links</span>
        </a>
    </li>
    </ul>

</aside><!-- End Sidebar-->