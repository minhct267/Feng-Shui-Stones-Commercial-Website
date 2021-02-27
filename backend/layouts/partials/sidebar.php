<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="logo">
        <img src="/web_thuongmai/assets/shared/img/print_icon.jpg">
    </div>
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/web_thuongmai/backend/pages/trangchu.php">
                <span data-feather="home"></span>
                Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/web_thuongmai/backend/functions/donhang/index.php">
                <span data-feather="file"></span>
                Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle"  data-toggle="collapse" aria-expanded="false" href="#productMenu">
                <span data-feather="shopping-cart"></span>
                Products
                </a>
                <ul class="collapse" id="productMenu">
                    <li>
                        <a href="/web_thuongmai/backend/functions/loaisanpham/index.php" id="menuItem">Loại sản phẩm</a>
                    </li>
                    <li>
                        <a href="/web_thuongmai/backend/functions/sanpham/index.php" id="menuItem">Sản phẩm</a>
                    </li>
                    <li>
                        <a href="/web_thuongmai/backend/functions/hinhsanpham/index.php" id="menuItem">Hình sản phẩm</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/web_thuongmai/backend/pages/dashboard.php">
                <span data-feather="bar-chart-2"></span>
                Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="users"></span>
                Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="truck"></span>
                Shipping
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="star"></span>
                Feedback
                </a>
            </li>
        </ul>
    </div>
</nav>