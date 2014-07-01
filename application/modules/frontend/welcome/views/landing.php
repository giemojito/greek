<style type="text/css">
.logo-header {
    font-family: 'Kaushan Script',cursive;
    text-align: center;
    color: #999;
}
</style>

<div class="container">
  <div class="logo-header">
    <h3>Login Page Applikasi</h3>
    <!-- <img src="assets/img/logo.png" alt="Logo Perusahaan"> -->
  </div>
  <div class="tab-content">
    <div id="login" class="tab-pane active">
      <form action="auth/login" class="form-signin" method="POST">
        <p class="text-muted text-center">
        Enter your username and password
        </p>
        <input type="text" placeholder="Username" class="form-control" name="username">
        <input type="password" placeholder="Password" class="form-control" name="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
    <div id="forgot" class="tab-pane">
      <form action="index.html" class="form-signin" method="POST">
        <p class="text-muted text-center">Enter your valid e-mail</p>
        <input type="email" placeholder="mail@domain.com" required="required" class="form-control" name="email">
        <br>
        <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
      </form>
    </div>
    <!-- No needed because the register with administrator -->
    <!-- <div id="signup" class="tab-pane">
      <form action="index.html" class="form-signin">
        <input type="text" placeholder="username" class="form-control">
        <input type="email" placeholder="mail@domain.com" class="form-control">
        <input type="password" placeholder="password" class="form-control">
        <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
      </form>
    </div> -->
  </div>
  <div class="text-center">
    <ul class="list-inline">
      <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a> </li>
      <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a> </li>
      <!-- <li> <a class="text-muted" href="#signup" data-toggle="tab">Signup</a> </li> -->
    </ul>
  </div>
</div>
<!-- /container -->
