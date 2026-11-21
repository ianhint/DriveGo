
<?php

// Get Current Page Name
$current_page = basename($_SERVER['PHP_SELF']);


// Car Management Pages
$car_pages = [
    "cars.php",
    "add_car.php",
    "categories.php",
    "add_category.php",
    "brands.php",
    "add_brand.php"
];


// Check Car Management Page
$car_menu_open = in_array($current_page, $car_pages);

?>


<!-- Sidebar Start -->

<div class="sidebar-wrapper">

    <div class="sidebar-header">
        <h4>DriveGo</h4>
        <small>Car Rental System</small>
    </div>


    <ul class="metismenu" id="menu">


        <!-- Dashboard -->
        <li>

            <a href="dashboard.php"
               class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-home-circle"></i>
                </div>

                <div class="menu-title">Dashboard</div>

            </a>

        </li>


        <!-- Car Management -->
        <li class="<?php echo $car_menu_open ? 'open' : ''; ?>">

            <a href="javascript:;"
               class="has-arrow <?php echo $car_menu_open ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-car"></i>
                </div>

                <div class="menu-title">Car Management</div>

            </a>


            <ul>

                <!-- All Cars -->
                <li>
                    <a href="cars.php"
                       class="<?php echo ($current_page == 'cars.php') ? 'active' : ''; ?>">
                        All Cars
                    </a>
                </li>


                <!-- Add New Car -->
                <li>
                    <a href="add_car.php"
                       class="<?php echo ($current_page == 'add_car.php') ? 'active' : ''; ?>">
                        Add New Car
                    </a>
                </li>


                <!-- Categories -->
                <li>
                    <a href="categories.php"
                       class="<?php echo ($current_page == 'categories.php') ? 'active' : ''; ?>">
                        Categories
                    </a>
                </li>


                <!-- Add Category -->
                <li>
                    <a href="add_category.php"
                       class="<?php echo ($current_page == 'add_category.php') ? 'active' : ''; ?>">
                        Add Category
                    </a>
                </li>


                <!-- Brands -->
                <li>
                    <a href="brands.php"
                       class="<?php echo ($current_page == 'brands.php') ? 'active' : ''; ?>">
                        Brands
                    </a>
                </li>


                <!-- Add Brand -->
                <li>
                    <a href="add_brand.php"
                       class="<?php echo ($current_page == 'add_brand.php') ? 'active' : ''; ?>">
                        Add Brand
                    </a>
                </li>

            </ul>

        </li>


        <!-- Bookings -->
        <li>
            <a href="bookings.php"
               class="<?php echo ($current_page == 'bookings.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-calendar-check"></i>
                </div>

                <div class="menu-title">Bookings</div>

            </a>
        </li>


        <!-- Customers -->
        <li>
            <a href="customers.php"
               class="<?php echo ($current_page == 'customers.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-user"></i>
                </div>

                <div class="menu-title">Customers</div>

            </a>
        </li>


        <!-- Staff -->
        <li>
            <a href="staff.php"
               class="<?php echo ($current_page == 'staff.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-group"></i>
                </div>

                <div class="menu-title">Staff</div>

            </a>
        </li>


        <!-- Payments -->
        <li>
            <a href="payments.php"
               class="<?php echo ($current_page == 'payments.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-wallet"></i>
                </div>

                <div class="menu-title">Payments</div>

            </a>
        </li>


        <!-- Reports -->
        <li>
            <a href="reports.php"
               class="<?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-bar-chart-alt-2"></i>
                </div>

                <div class="menu-title">Reports</div>

            </a>
        </li>


        <!-- Settings -->
        <li>
            <a href="settings.php"
               class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">

                <div class="parent-icon">
                    <i class="bx bx-cog"></i>
                </div>

                <div class="menu-title">Settings</div>

            </a>
        </li>


        <!-- Logout -->
        <li>
            <a href="../auth/logout.php">

                <div class="parent-icon">
                    <i class="bx bx-log-out"></i>
                </div>

                <div class="menu-title">Logout</div>

            </a>
        </li>


    </ul>

</div>

<!-- Sidebar End -->


<!-- Submenu Toggle JavaScript -->

<script>

let submenuButtons = document.querySelectorAll(".has-arrow");


submenuButtons.forEach(function(button) {

    button.addEventListener("click", function(event) {

        event.preventDefault();

        let parentMenu = this.parentElement;

        parentMenu.classList.toggle("open");

        this.classList.toggle("active");

    });

});

</script>
