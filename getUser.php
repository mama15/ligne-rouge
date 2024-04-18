<?php
include "db.php";
$id = $_GET["id"];

if (isset($_POST["submit"])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];

  $sql = "UPDATE crud SET first_name='$first_name',last_name='$last_name',email='$email',gender='$gender' WHERE id = $id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: index.php?msg=user modifier");
  } else {
    echo "Failed: " . mysqli_error($conn);
  }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>updateUser</title>
</head>

<body>
<?php
    $sql = "SELECT * FROM crud WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>



    <div class="container d-flex justify-content-center">
      <div style="display: flex; flex-direction: row; gap: 5px;">
      <div class="mb-3">
            <?php
            if (!empty($row['picture'])) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '" class="img-thumbnail" width="150" height="150" />';
            } else {
                echo 'Aucune photo de fournie.';
            }
            ?>
        </div>
      <div>
      <div>
    <h5>Nom: <?php echo $row["first_name"] ?></h5>
    <h5>Prenom: <?php echo $row["last_name"] ?></h5>
    <h5>Email: <?php echo $row["email"] ?></h5>
    <h5>Genre: <?php echo $row["gender"] ?></h5>
</div>

      </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>