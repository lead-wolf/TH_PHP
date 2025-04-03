<footer class="bg-warning text-center py-3 mt-5">
    <p class="text-white mb-0">&copy; 2025 SEA FRUITS - Tươi ngon mỗi ngày</p>
</footer>


<li class="nav-item">
<?php
    if (SessionHelper::isLoggedIn()) {
        echo "<a class='navlink'>" . $_SESSION['username'] . "</a>";
    } else {
        echo "<a class='nav-link' href='/webbanhang/account/login'>Login</a>";
    }
    ?>
</li>
<li class="nav-item">
    </a>
    <?php
    if (SessionHelper::isLoggedIn()) {
        echo "<a class='nav-link' href='/webbanhang/account/logout'>Logout</a>";
    }
    ?>
</li>
</ul>
</div>
</nav>
<div class="container mt-4"></div>