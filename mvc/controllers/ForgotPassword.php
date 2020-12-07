<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ForgotPassword extends Controller
{
    private $listField = ["userID", "userName", "userPassword", "name", "userEmail", "userAvatar", "userStatus", "roleName"];

    // Default Page
    public function DefaultPage(): void
    {
        $this->handleWrongUrl();
    }

    public function ResetPassword(): void
    {
        // Check method
        $this->handleWrongMethod("POST");

        // List table To Add
        $listTableField = [$this->listField[4]];

        // Read Data From BodyContent
        $bodyContent = $this->GetDataFromBody();

        // Validate Data
        $this->ValidDataFromRequest($listTableField, $bodyContent);

        // Check If Email Exist In DB
        if (!($this->LoadModel("ForgotPasswordModel")->CheckExistEmail($bodyContent['userEmail']))) {
            $this->response(400, ['code' => 400, 'message' => 'Email Invalid']);
        }

        $userID = $this->LoadModel("ForgotPasswordModel")->GetUserId($bodyContent['userEmail'])['userID'];

        // Temp Password And Message To Send
        $newPassword = $this->encodeBcryptString("1111");
        $dataEdit = ['userPassword' => $newPassword];
        $messageSend = "Your Temporary Password is <b>1111</b>. Please Change It <b>Immediately</b> After Log-In";

        // Call Obj
        $mail = new PHPMailer(true);

         //Server settings
        $mail->isSMTP();// gửi mail SMTP

        $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
        $mail->SMTPAuth = true;// Enable SMTP authentication
        $mail->Username = 'johhnysinstest@gmail.com';// SMTP username
        $mail->Password = '5154325a'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to
        //Recipients
        $mail->setFrom('RyderShop@gmail.com', 'Ryder Customer Services System');
        $mail->addAddress($bodyContent['userEmail'], 'Dear Our Customer'); // Add a recipient
        // Content
        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = 'Your Reset Password Request';
        $mail->Body = $messageSend;
        
        //Update Password And Send Mail
        if ($this->LoadModel("ForgotPasswordModel")->ResetPassword($userID, $dataEdit)) {
            $result = $mail->send();

            $result = true ? $this->response(200, ["code" => 200, "message" => "Completed"]) : $this->response(400, ["code" => 400, "message" => "Error, Can't Not Send Mail"]);
        }
        else
        {
            $this->response(400, ["code" => 400, "message" => "Error, Can't Not Send Mail"]);
        }

        $this->response(500, ["code" => 500, "message" => "500 Internal Server"]);
    }
}

?>