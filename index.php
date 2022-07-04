<?php

session_start();
include_once 'header.php';
include_once 'classes/File.php';

$userFile = new File();

if(isset($_POST['checkValidBtn'])){

    $sessionCaptcha = $_SESSION['captcha'];
    $formCaptcha = $_POST['txtCaptchString'];

    // Captcha validation
    if ( empty($formCaptcha)){
      $captchaMsg = "Enter Captcha ";
    }elseif ($sessionCaptcha != $formCaptcha) {
      $captchaMsg = "Captcha entered is incorrect.";
    }else{
      $txtNationalId    = $_POST['txtNationalId'];
      $txtDocumentRefNo = $_POST['txtDocumentRefNo'];
    
      // Primary field validation
      if( empty($txtNationalId) )
      {
        $nIdErrMsg = "Required";
      }elseif(empty($txtDocumentRefNo))
      {
        $rIdErrMsg = "Required";
      } elseif (!filter_var($txtNationalId, FILTER_VALIDATE_INT)) 
      {
        $nIdErrMsg = 'Not Integer';
      } elseif (!filter_var($txtDocumentRefNo, FILTER_VALIDATE_INT)) 
      {
        $rIdErrMsg = 'Not Integer';
      }else
      {
        $userData = $userFile->displayUserDocument($txtNationalId, $txtDocumentRefNo);     
          // final data valodation
          if( !isset($userData[0]['nId']) || $userData[0]['nId'] != $txtNationalId )
          {
            $nIdErrMsg = "Please enter a valid National Id"; 
          }elseif( !isset($userData[0]['rId']) || $userData[0]['rId'] != $txtDocumentRefNo )
          {          
            $rIdErrMsg = "Please enter a valid Reference No.";
          }else
          {           
            $downloadMsg = "Your document is ready to download.";
            $filename = $userData[0]['fname'];
            $downloadBtn = '<a class="btn btn-primary btn-sm px-4 py-2" href="assets/upload/pdf/' .$filename .'" download> Download Now </a>'. ' ' . $filename;
          }         
      }
    }
}

?>

<section class="mt-5 py-5">
  <div class="container">

    <h5 class="title py-2 mb-5 text-center">
      Enter your National ID and Reference No. 
    </h5>

    <form action="" method="POST">
      <div class="d-flex justify-content-between align-items-center px-5 pb-3">
        <div class="d-flex justify-content-between align-items-center">
          <label  for="txtNationalId">National ID / <br>Iqama No</label>
          <span class="required ms-4 me-2">*</span>

          <div class="nId">
            <input type="text" id="txtNationalId" name="txtNationalId" class="input-token-openlegalaccount" />
            <div id="rgNationalId" class="errormsg hidesection">
              <small class="text-danger">
                  <?php if (isset($nIdErrMsg)) {echo $nIdErrMsg;} ?>
              </small>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <label class="openlegalaccountlbl" for="txtDocumentRefNo">Reference No.</label>
          <span class="required ms-4 me-2">*</span>
          <div class="rId">
            <input type="text" id="txtDocumentRefNo" name="txtDocumentRefNo" class="input-token-openlegalaccount" />
            <div id="rgDocumentRefNo" class="errormsg hidesection text-center" style="padding-top: 0px">
              <small class="text-danger">
                  <?php if (isset($rIdErrMsg)) {echo $rIdErrMsg;} ?>    
              </small>
            </div>
          </div>
        </div>
      </div>

      <div class="row captch-content text-center"></div>

      <div class="row captch-content text-center">
        <div class="capbox">
          <a id="captcha-container">   
            <img src="captcha.php" alt="CAPTCHA" class="captcha-image" />
          </a>
          <div class="capbox-inner">
            Type the characters you see in the image *<br />
            <div class="captch-input">
              <input type="text" id="txtCaptchString" name="txtCaptchString" class="input-token-openlegalaccount" />           
              <a title="Change Image" href="#">
                <img src="assets/images/captcha/reload.jpg" class="img-refresh" />
              </a>
            </div>
          </div>
        </div>

        <div class=" text-danger ">
          <span>  <?php if (isset($captchaMsg)) {echo $captchaMsg;} ?>  </span>
        </div>
      </div>

      <div class="text-center pt-4">     
        <input type="submit" class="btnsubmit" name="checkValidBtn" value="Check documents validity" />

        <div class="row pt-4">
          <div class="col-md-12 mx-auto">  
            <span>  <?php if (isset($downloadMsg)) {echo $downloadMsg;} ?>  </span>
          </div>
        </div>

        <div class="row pt-2">
          <div class="col-md-12 mx-auto">    
            <span>  <?php if (isset($downloadBtn)) {echo $downloadBtn;} ?> </span>
          </div>
        </div>

      </div>
    </form>
  </div>
</section>



<?php include_once 'footer.php';?>