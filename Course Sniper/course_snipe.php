<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$subjectCode = htmlspecialchars($_POST['subject_code']);
$courseNumber = htmlspecialchars($_POST['course_number']);
$courseIndex = htmlspecialchars($_POST['course_index']);
$email = htmlspecialchars($_POST['email']);
$sectionStatus = "Error: incorrect input";

$refreshInterval = 20;

$courseJSON = file_get_contents("http://sis.rutgers.edu/oldsoc/courses.json?subject=$subjectCode&semester=92019&campus=NB&level=UG");
$courses = json_decode($courseJSON, true);
foreach($courses as $course){
    if($course['courseNumber'] == $courseNumber){
        foreach($course['sections'] as $section){
            if($section['index'] == $courseIndex){
                $sectionStatus = $section['openStatus'];
            }
        }
    }
}

if($sectionStatus == null){
    while(!$sectionStatus){
        $courseJSON = file_get_contents("http://sis.rutgers.edu/oldsoc/courses.json?subject=$subjectCode&semester=92019&campus=NB&level=UG");
        $courses = json_decode($courseJSON, true);
        foreach($courses as $course){
            if($course['courseNumber'] == $courseNumber){
                foreach($course['sections'] as $section){
                    if($section['index'] == $courseIndex){
                        $sectionStatus = $section['openStatus'];
                    }
                }
            }
        }
        sleep($refreshInterval);
    }
}

if($sectionStatus == 1){
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        
        // TODO: Enter your gmail and password
        $mail->Username   = 'zkid2o2@gmail.com';                    // SMTP username
        $mail->Password   = 'zonair12';                             // SMTP password
        
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        // TODO: Set who the email is from and reply address
        $mail->setFrom('zkid2o2@gmail.com', 'Muhmmad Choudhary');
        $mail->addAddress($email);                                  // Add a recipient
        $mail->addReplyTo('zkid2o2@gmail.com', 'Muhmmad Choudhary');

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Course Open';
        $mail->Body    = "$subjectCode:$courseNumber [$courseIndex] is open";
        $mail->AltBody = "$subjectCode:$courseNumber [$courseIndex] is open";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}else{
    echo $sectionStatus;
}