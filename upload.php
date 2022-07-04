<?php

include_once 'header.php';
include "classes/File.php";

$userFile = new File();

//GET FORM DATA
if (isset($_POST['uploadBtn'])) {
  $txtNationalId = $_POST['txtNationalId'];
  $txtDocumentRefNo = $_POST['txtDocumentRefNo'];
  if (isset($_FILES['pdfFile'])) {
    $pdfFile = $_FILES['pdfFile'];
  }

  //FORM VALIDATION
  if (empty($txtNationalId)) {
    $nIdErrMsg = "required";
  } elseif (!filter_var($txtNationalId, FILTER_VALIDATE_INT)) {
    $nIdErrMsg = 'Not Integer';
  } elseif (strlen($txtNationalId) < 5 || strlen($txtNationalId) > 10) {
    $nIdErrMsg = 'More than 5 but less than 10';
  } elseif ($userFile->nIdCheck($txtNationalId)) {
    $nIdErrMsg = 'Already exits';
  } elseif (empty($txtDocumentRefNo)) {
    $rIdErrMsg = "required";
  } elseif (!filter_var($txtDocumentRefNo, FILTER_VALIDATE_INT)) {
    $rIdErrMsg = 'Not Integer';
  } elseif (strlen($txtDocumentRefNo) < 5 || strlen($txtDocumentRefNo) > 10) {
    $rIdErrMsg = 'More than 5 but less than 10';
  } elseif ($userFile->rIdCheck($txtDocumentRefNo)) {
    $rIdErrMsg = 'Already exits';
  } else {
    $fileData = $userFile->pdfFileCheck($pdfFile, 'assets/upload/pdf/');
      if (!empty($fileData['fileErrMsg'])){
        $fileErrMsg = $fileData['fileErrMsg'];
      }else{
        $userFile->addUserDocument($txtNationalId, $txtDocumentRefNo, $fileData['fileName']);
        header('location:upload.php'); 
      }   
  }
}

?>

<section class="mt-5 py-5">
  <div class="container">
    <h5 class="title py-2 mb-5 text-center">Upload your documents</h5>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="upload">
        <div class="row mb-3">
          <div class="col-md-3"></div>
          <label for="txtNationalId" class="col-sm-2 col-form-label">National ID / <br />Iqama No
            <span class="required">*</span>
          </label>
          <div class="col-sm-4 nId">
            <input type="text" id="txtNationalId" name="txtNationalId" placeholder="Enter your National ID" />
            <div id="nId" class="text-danger">
              <small>
                <?php if (isset($nIdErrMsg)) {echo $nIdErrMsg;} ?>
              </small>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-3"></div>
        <label for="txtDocumentRefNo" class="col-sm-2 col-form-label">Reference No. <span class="required">*</span>
        </label>
        <div class="col-sm-4 rId">
          <input type="text" id="txtDocumentRefNo" name="txtDocumentRefNo" placeholder="Enter your Reference No." />
          <div id="rId" class="text-danger">
            <small>
              <?php if (isset($rIdErrMsg)) { echo $rIdErrMsg;} ?>
            </small>
          </div>
        </div>
      </div>
      <div class="row mb-3 mt-5">
        <div class="col-md-3"></div>
        <label for="pdfFile" class="col-sm-2 col-form-label">Upload File
          <span class="required">*</span><br />( pdf )
        </label>
        <div class="col-sm-4">
          <input type="file" id="pdfFile" name="pdfFile" />
          <div id="pdf" class="text-danger">
            <small>
              <?php if (isset($fileErrMsg)) {echo $fileErrMsg;} ?>
            </small>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 mx-auto text-center ">
          <input class="btnsubmit" type="submit" name="uploadBtn" value="Submit">
        </div>
      </div>
  </div>
  </div>
  </div>
  </form>
  </div>
</section>

<?php include_once 'footer.php';?>