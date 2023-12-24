    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">FiveBooks</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <?php if (isset($_SESSION['role'])) {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="pesanan.php">Pesanan</span></a>
                    </li>

                <?php } else { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</span></a>
                    </li>
                <?php } ?>

            </ul>
            <div class="form-inline my-2 my-lg-0">
                <?php
                if (isset($_SESSION['role'])) {
                    if ($_SESSION['role'] == 'admin') {
                        echo '<span style="color: green; font-size: 18px;">Halo ' . $_SESSION['nama'] . '</span>';
                        echo '<a href="logout.php" class = "nav-link" >Logout</a>';
                    } else {
                        echo '<span style="color: green; font-size: 18px;">Halo ' . $_SESSION['nama'] . '</span>';
                        echo '<a href="logout.php" class = "nav-link" >Logout</a>';
                    }
                } else {
                    echo '<a href="login.php" class="nav-link">Login</a><a href="regis.php" class="nav-link">Register</a>';
                } ?>
            </div>
        </div>
    </nav>