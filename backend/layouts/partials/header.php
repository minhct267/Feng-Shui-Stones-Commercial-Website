<div class="container-head">
  <div class="navbar-head ">
    <button class="navbar-toggler position-absolute d-md-none collapsed navbar-light" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <nav class="functions">
      <ul>
        <li>
          <a href="#"><i class="fa fa-github"></i></a>
        </li>
        <li>
          <a  href="/web_thuongmai/backend/functions/shopping_cart.php"><i class="fa fa-shopping-cart"></i></a>
        </li>
        <?php if(isset($_SESSION['kh_tendangnhap_logged']) && !empty($_SESSION['kh_tendangnhap_logged'])) : ?>
            <li>
                <a href="/web_thuongmai/backend/pages/login/sign_up.php"><i class="fa fa-sign-out"></i></a>
            </li>
            <li>
                <a href="#" style="font-size:small">Xin chào, <?= $_SESSION['kh_tendangnhap_logged'] ?></a>
            </li>
        <?php else: ?>
            <li>
              <a href="/web_thuongmai/backend/pages/login/sign_in.php"><i class="fa fa-sign-in"></i></a>
            </li>
        <?php endif;?>
      </ul>
    </nav>
  </div>
</div>




