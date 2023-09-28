<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>recover</title>

     <!-- css  -->
     <link rel="stylesheet" href="../css/login.css" />
    <link rel="stylesheet" href="../css/util.css" />
    <!-- google font link -->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Roboto+Condensed:wght@300;400&family=Roboto+Serif:opsz,wght@8..144,100;8..144,400&family=Smokum&display=swap');
    </style>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php require '../components/_header.php'?>

    <div class="l_con">
      <form action="" name="recover" method="post" class="mt-5">
        <h1 class="f_title recover">Recover Password</h1>
        <p>please eneter your e-mail</p>
        <div class="fg" id="email-group">
          <input class="in"
            type="email"
            name="email"
            placeholder="Email"
            autofocus
            required
          />
          <span class="message"> </span>
        </div>
          

        <button class="button mt-3" id="submit1" name="login">Recover</button>
        <div>
          <p class="mt-3">
            Remember Your password? <a href="login.php" class="link">Back to Login</a>
          </p>
        </div>
      </form>
    </div>

    

    <!-- Bootstrap core javascript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>