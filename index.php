
<!-- ---------------database connection-------------------------------- -->
<?php
$INSERT=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";

$conn=mysqli_connect($servername,$username,$password,$database);
if (!$conn){
  die("Could not connect to the databased server.");
}
// -----------------delete query--------------
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `Sno.` = $sno";
  $result=mysqli_query($conn,$sql);
}
if ($_SERVER['REQUEST_METHOD']=='POST'){
  // ------update query-----------------
  if(isset($_POST['snoedit'])){
    $sno=$_POST["snoedit"];
    $title=$_POST["textedit"];
  $description=$_POST["descriptionedit"];
    $sql="UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`Sno.` = $sno;";
    $result=mysqli_query($conn,$sql);
    if($result){
      $update=true;
    }else{
      echo"we could not update your record";
    }
  }
  // -------Insertion query--------------------
  else{
  $title=$_POST["text"];
  $description=$_POST["description"];

  $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
  $result=mysqli_query($conn,$sql);
  if($result){
    $INSERT=true;
  }else{
    echo"your nots is not added";
  }
}
}
?>

<!-- ------------frontend page -->
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"/>
    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>iNOTES Notes taking made easy</title>
  </head>
  <body>


<!-- ---------edit  Modal------- -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Records</h5>
        <button type="button" class="close" data-bs-dismiss="modal" area-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
 <!-- -----------------edit modal form---------   -->
        <form action="/ADDNOTES/index.php" method="POST">
        <div class="modal-body">
          <input type="hidden" name="snoedit" id="snoedit">
        <div class="mb-3">
          <label for="text" class="form-label mt-2">Note Title</label>
          <input type="text" class="form-control mb-4" id="textedit" name="textedit" >
         <div class="mb-3">
          <label for="description" class="form-label">Note Description</label>
          <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="descriptionedit" name="descriptionedit"></textarea>
            <label for="desc">DESCRIPTION</label>
          </div> 
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Records</button>
      </form>  
      </div>
      </form>  
    </div>
  </div>
</div>


<!-- --------------navbar------------------------ -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="./notes.png" height="40px"></img> </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">ABOUT</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">CONTACTUS</a>
            </li>     
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
<!-- -----------------dismissing message of insertion,update,delete------------ -->
    <?php
    if($INSERT){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You Notes has added successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

<?php
    if($update){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You Notes has update successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

<?php
    if($delete){
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You Notes has delete successfully.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
<!-- --------------frontend form design ------------- -->
    <div class="container my-3">
      <form action="/ADDNOTES/index.php" method="post">
        <h1 class="addnotes">ADD NOTES</h1>
        <div class="mb-3">
          <label for="text" class="form-label mt-2">Note Title</label>
          <input type="text" class="form-control mb-4" id="text" name="text" aria-describedby="text">
        <div class="mb-3">
          <label for="description" class="form-label">Note Description</label>
          <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description"></textarea>
            <label for="desc">DESCRIPTION</label>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
 <!-- -------------------table      -->
<div class="container my-3">
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sno.</th>
      <th scope="col">TITLE</th>
      <th scope="col">DESC</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
<!-- --------------------display database data in table form     -->
  <?php
$sql="SELECT * FROM `notes`";
$result = mysqli_query($conn,$sql);
$sno=0;
while($row=mysqli_fetch_assoc($result)){
  $sno=$sno+1;
  echo"<tr>
  <th scope='row'>". $sno ."</th>
  <td>".$row['title']."</td>
  <td>".$row['description']."</td>
  <td><button class='edit btn-btn-sm btn-primary' id=".$row['Sno.'].">EDIT</button><button class='delete btn-btn-sm btn-primary' id=d".$row['Sno.'].">DELETE</button></td>
</tr>";
}
?>
</tbody>
</table>
</div> 
<hr>     
<!-- --------------------scripts------------ -->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <!-- -----------------data tabel function -->
    <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

<!-- -----------modal edit script using javascript--------------------- -->
<script>
  edit = document.getElementsByClassName('edit');
  Array.from(edit).forEach((element)=>{
    element.addEventListener("click" , (e)=>{
      console.log("edit ", );
      tr=e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      console.log(title,description);
      textedit.value=title;
      descriptionedit.value=description;
      snoedit.value=e.target.id;
      $('#editModal').modal('toggle');    
})
})
// -----------delete modal---------------------
      deletes = document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click" , (e)=>{
      console.log("edit ", );
    sno = e.target.id.substr(1, );
      if(confirm("Are you sure you want to delete")){
        console.log("YES")
        window.location= `/ADDNOTES/index.php?delete=${sno}`;
      }else{
        console.log("NO")

      }     

    })
  })
</script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>


