<!-- Footer -->
<?php
    $has_prefix = isset($this->request->params['prefix']);
    $position = $has_prefix && $this->request->params['prefix'] !== "profile" || $this->request->params['action'] === "register" || $this->request->params['controller'] === "Feeds" ? "sticky" : "fixed";
    
?>
<footer style="bottom: 0 !important; position: <?= $position ?>; width: 100%">

  <!-- Footer Links -->

  <!-- Copyright -->
    <div class="footer-copyright text-center py-3 bg-light">
        <div class="row mx-0">
            <div class="col-sm-4 text-center">
                Like us on: 
                <a href="https://www.facebook.com/loukhaclothing/">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
            <div class="col-sm-4 text-center">
                Follow us on:
                <a href="https://www.instagram.com/loukhaclothing/?hl=en">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <div class="col-sm-4 text-center">
                Follow us on:<a href="">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="/"> loukhaclothing.store</a>
        </div>
    </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->