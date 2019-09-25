<?php
// ini_set('display_errors', 1);
error_reporting(0);
require "db.php";
$received_data = json_decode(file_get_contents('php://input'), true);
$button_value = $received_data['button'];
// $button_value = 'get_exercises';

//POST Method

/*Login API*/
if ($button_value == 'login') {

    $username = $received_data['username'];
    $password = $received_data['password'];

    $query = mysqli_query($con, "SELECT * FROM login_details where username = $username and password = '$password'");

    if ($query) {
        $num_query = mysqli_num_rows($query);
        $fetch = mysqli_fetch_array($query);

        if ($num_query > 0) {

            if ($fetch[2] == 'false') {

                $update = mysqli_query($con, "UPDATE login_details SET status = 'true' where username = $username");

                if ($update) {

                    $query = mysqli_query($con, "SELECT * FROM login_details where username = $username and password = '$password'");
                    $db_data = array("status" => "true", "message" => "Login Success");

                    while ($row = mysqli_fetch_assoc($query)) {

                        $data[] = $row;
                    }

                    $db_data['data'] = $data;
                    echo json_encode($db_data);
                } else {
                    $response = array("status" => "false", "data" => array(), "message" => "Error in Update Query");
                    echo json_encode($response);
                }
            } else {
                $response = array("status" => "true", "data" => array(), "message" => "Already logged in");
                echo json_encode($response);
            }
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "Error in Login Status Query");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "true", "data" => array(), "message" => "Invalid Credentials");
        echo json_encode($response);
    }
}

/*API for Code and Images*/
if ($button_value == 'get_code_images') {
    $code = $received_data['code'];
    $query = mysqli_query($con, "SELECT code,code_url FROM titles_details WHERE code_url IS NOT NULL AND code = '$code' ");
    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }
}

/*API for Chapters and Exercise*/
if ($button_value == 'get_chap_exe') {
    $module = $received_data['module'];
    $class = $received_data['class'];
    $subject = $received_data['subject'];
    // $module = "achievers";
    // $class = "6th";
    // $subject = "maths";
    $query = mysqli_query($con, "SELECT DISTINCT(chapter) as chapter FROM data_details where module = '$module' and class = '$class' and subject = '$subject'");

    if ($query) {
        $num_chapter = mysqli_num_rows($query);
        if ($num_chapter > 0) {

            $db_data = array("status" => "true", "message" => "Query Success");
            $i = 0;
            while ($row = mysqli_fetch_assoc($query)) {

                $data[] = $row;
                $chapter = $data[$i]['chapter'];
                $chapter_query = mysqli_query($con, "SELECT exercise FROM data_details WHERE chapter = '$chapter' and class = '$class'");
                $num_exercise = mysqli_num_rows($chapter_query);

                while ($fetch_chapter = mysqli_fetch_assoc($chapter_query)) {

                    foreach ($fetch_chapter as $value) {
                        $exercise[] = $value;

                    }
                }

                $data[$i]['exercise'] = $exercise;
                //echo json_encode($exercise). "<br>";
                unset($exercise);
                $i++;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);

        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }

}

/*API for Video URL*/
if ($button_value == 'get_video_url') {
    $module = $received_data['module'];
    $class = $received_data['class'];
    $subject = $received_data['subject'];
    $chapter = $received_data['chapter'];
    $exercise = $received_data['exercise'];
    // $module = "achievers";
    // $class = "6th";
    // $subject = "maths";
    // $chapter = "chapter_1";
    // $exercise = "exercise_1_3";

    $query = mysqli_query($con, "SELECT url_video FROM data_details where module = '$module' and class = '$class' and subject = '$subject' and chapter = '$chapter' and exercise = '$exercise'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {

            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }

}

/*API for PDF URL*/
if ($button_value == 'get_pdf_url') {
    $module = $received_data['module'];
    $class = $received_data['class'];
    $subject = $received_data['subject'];
    $chapter = $received_data['chapter'];
    $exercise = $received_data['exercise'];
    // $module = "achievers";
    // $class = "6th";
    // $subject = "maths";
    // $chapter = "chapter_1";
    // $exercise = "exercise_1_3";
    $query = mysqli_query($con, "SELECT url_pdf FROM data_details where module = '$module' and class = '$class' and subject = '$subject' and chapter = '$chapter' and exercise = '$exercise'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {

            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }

    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }

}

// GET Method
/*API for Modules and Icons*/
if ($button_value == 'get_modules') {
    $query = mysqli_query($con, "SELECT module,module_url FROM titles_details where module != 'null' and module_url != 'null'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }

}

/*API for Classes and Icons*/
if ($button_value == 'get_classes') {
    $query = mysqli_query($con, "SELECT class,class_url FROM titles_details where class != 'null' and class_url != 'null'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }
}

/*API For Subjects and Icons*/
if ($button_value == 'get_subjects') {
    $query = mysqli_query($con, "SELECT subject,subject_url FROM titles_details where subject != 'null' and subject_url != 'null'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }
}

/*API For Chapters and Icons*/
if ($button_value == 'get_chapters') {
    $query = mysqli_query($con, "SELECT chapter,chapter_url FROM titles_details where chapter != 'null' and chapter_url != 'null'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }
}

/*API For Exercises and Icons*/
if ($button_value == 'get_exercises') {
    $query = mysqli_query($con, "SELECT exercise,exercise_url FROM titles_details where exercise != 'null' and exercise_url != 'null'");

    if ($query) {
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $db_data = array("status" => "true", "message" => "Query Success");
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            $db_data['data'] = $data;
            echo json_encode($db_data);
        } else {
            $response = array("status" => "false", "data" => array(), "message" => "No Records found");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "false", "data" => array(), "message" => "Error in Query");
        echo json_encode($response);
    }
}
