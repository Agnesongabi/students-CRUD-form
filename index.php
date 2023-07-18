<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KWTRP Service Desk | User Registration Form</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <style>

    </style>

    <!--bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
        PHP COMPLETE CRUD APPLICATION
    </nav>
    <!--bootsrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <?php
    require_once './config/db.php';
    require_once './Models/Student.php';
    require('./config/helpers.php');
    
    // Initialize the database connection
    $db = new DB();
    $student = new Student($db);

    //define variables and set to empty values
    $firstnameErr = $lastnameErr = $emailErr = $genderErr = $websiteErr  = "";
    $firstname = $lastname = $email = $gender = $comments = $website = $id = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = test_input($_POST["firstname"]);
        $lname = test_input($_POST["lastname"]);
        $gender = test_input($_POST["gender"]);
        $email = test_input($_POST["email"]);
        $comment = test_input($_POST["comment"]);
        $website = test_input($_POST["website"]);
        $id = $_POST["id"];

        // validations
        $firstnameErr = isFieldEmpty($fname) != 1 ? isFieldEmpty($fname) : validateField($fname, 'fname');
        $lastnameErr = isFieldEmpty($lname) != 1 ? isFieldEmpty($lname) : validateField($lname, 'lname');
        $emailErr = isFieldEmpty($email) != 1 ? isFieldEmpty($email) : validateField($email, 'email');
        $genderErr = isFieldEmpty($gender)  != 1 ? isFieldEmpty($email) : '';
        $websiteErr = isFieldEmpty($website) != 1 ? isFieldEmpty($website) : validateField($website, 'website');

        // post to db
        if (empty($emailErr) && empty($firstnameErr) && !empty($fname)) {
            $entry_time = date('Y-m-d H:i:s');

            if(isset($id) && !empty($id)){
                // Edit record
                $student->upsertStudent($fname,$lname,$gender,$email,$comment,$website,$entry_time, $id);
            }else{
                // Add a new student
                $student->upsertStudent($fname,$lname,$gender,$email,$comment,$website,$entry_time); 

            }
            header("Location: index.php");
            exit();
        }
    } else {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $res = $student->getStudentById($id);
            // $record = mysqli_query($conn, "SELECT * FROM users WHERE id=$id;") or die(mysqli_error($conn));
            // $res = mysqli_fetch_array($record, MYSQLI_BOTH);
            $email = $res['email'] .
                $firstname = $res['fname'];
        }

        // Handle delete request
        if (isset($_GET['d'])) {
            $id = $_GET['d'];
            $student->deleteStudent($id);
            header("Location: index.php");
            exit();
        }
    }



    $records = $student->getAllStudents();

    ?>


    <main>

        <section class="students-section">

            <article class="card">
                <div class="card-header">

                    <h2 class="title">User Entry Form</h2>
                    <p>All fields with * mark are required</p>
                </div>

                <form method="POST" class="card-body" action="index.php">
                    <input type="hidden" name="id" value="<?= $id; ?>" />
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Firstname:</label>
                                <input class="form-control" type="text" placeholder="Enter your firstname" name="firstname" value="<?= $firstname; ?>" />
                                <span class="error">* <?= $firstnameErr; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Lastname:</label>
                                <input class="form-control" type="text" placeholder="Enter your lastname" name="lastname" value="<?= $lastname; ?>" />
                                <span class="error">* <?= $lastnameErr; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input class="form-control" type="text" placeholder="Enter your email" id="email" name="email" value="<?= $email; ?>">
                                <span class="error">*<?= $emailErr; ?></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="website">Website:</label>
                                <input class="form-control" type="text" id="website" name="website" value="<?= $website; ?>">
                                <span class="error"><?= $websiteErr; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea class="form-control" name="comment" id="comment" rows="5" cols="40"><?= isset($comment) ? $comment : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="M" <?= isset($gender) && $gender == "Male" ? "selected" : ''; ?>>Male</option>
                                    <option value="F" <?= isset($gender) && $gender == "Female" ? "selected" : ''; ?>>Female</option>
                                    <option value="T" <?= isset($gender) && $gender == "Other" ? "selected" : ""; ?>>Other</option>
                                </select>
                                <span class="error">*<?= $genderErr; ?></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <hr>
                        <input class=" btn btn-info btn-block form-control" type="submit" name="submit" value="submit" />
                    </div>
                </form>

            </article>




            <div class="article-header">
                <h4 class="title">Students Entries</h4>
                <p>All responses from the form</p>
            </div>
            <article id="form-results">
                <table class="table table-striped">
                    <thead>
                        <td>#</td>
                        <td>firstname</td>
                        <td>lastname</td>
                        <td>Gender</td>
                        <td>email</td>
                        <td>comment</td>
                        <td>website</td>
                        <td>entry_time</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <!-- //loop -->
                        <?php foreach ($records as $rows) { ?>
                            <tr>
                                <td><?= $rows['id']; ?></td>
                                <td><?= $rows['fname']; ?></td>
                                <td>ongabi</td>
                                <td>female</td>
                                <td><?= $rows['email']; ?></td>
                                <td>test</td>
                                <td>w3school</td>
                                <td><?= $rows['entry_time']; ?></td>
                                <td>
                                    <a href="./index.php?id=<?= $rows['id'] ?>">Edit</a>
                                    <a href="./index.php?d=<?= $rows['id'] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <!-- .endloop -->
                    </tbody>
                </table>
            </article>
        </section>
    </main>
</body>

</html>