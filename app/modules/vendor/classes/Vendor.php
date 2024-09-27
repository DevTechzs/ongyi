<?php

namespace app\modules\vendor\classes;

use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;
use app\modules\vendor\classes\Session;
use app\modules\documents\classes\Documents;

class Vendor
{

    /* 
    Current Version: 2.0.0
    Created By: Devkanta,     dev1@techz.in
    Created On: 04/09/2024
    Modified By:
    Modified On: 

*/

    function saveVendor($data)
    {

        //check existence before 
        $checkparam = array(
            array(':AccountNo', strip_tags($data["AccountNo"])),
            array(':AccountHolderName', strip_tags($data["AccountHolder"])),
            array(':BankName',  $data['BankName']),
            array(':ContactNo', $data['ContactNo'])
        );
        //check query
        $checkVendorquery = ("SELECT COUNT(*) as count FROM Vendors WHERE AccountNo=:AccountNo AND AccountHolderName=:AccountHolderName AND BankName=:BankName AND ContactNo=:ContactNo");
        $checkVendor = DBController::sendData($checkVendorquery, $checkparam);
        if ($checkVendor['count'] > 0) {
            return array("return_code" => false, "return_data" => "Same Vendor  Account Already Exists");
        }
        $Registration_DocumentID = 0;
        if (!empty($data['rccFile'])) {
            $files = is_array($data['rccFile']) ? $data['rccFile'] : array($data['rccFile']); // Handle single file or array of files

            // Extract file data
            $fileData = isset($files['rccFile']) ? $files['rccFile'] : '';
            $fileName = isset($files['filename']) ? $files['filename'] : '';
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            // Check if file data and filename are available
            if ($fileData && $fileName) {
                // Prepare document parameters
                $docParam = array(
                    "file" => $fileData,
                    "ext" => $fileExt,
                    "DocumentsCategory" => "VENDORrccFile",
                    "DocumentsCategoryID" => null,
                    "DocumentSettingID" => null,
                    "DocumentTitle" => $fileName,
                    "DocumentAccessLevel" => "111",
                    "DocumentDisplayName" => $fileName,
                    "AddedByID" => 1,
                );

                // Call method to add document
                $documentRes = (new Documents())->addDocument($docParam);
                $Registration_DocumentID = $documentRes['return_data'];
            }
        }
        $FSSAILicenceDocumentID = 0;
        if (!empty($data['DriverLicencePath'])) {
            $files = is_array($data['DriverLicencePath']) ? $data['DriverLicencePath'] : array($data['DriverLicencePath']); // Handle single file or array of files

            // Extract file data
            $fileData = isset($files['driver_licence_path']) ? $files['driver_licence_path'] : '';
            $fileName = isset($files['filename']) ? $files['filename'] : '';
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            // Check if file data and filename are available
            if ($fileData && $fileName) {
                // Prepare document parameters
                $docParam = array(
                    "file" => $fileData,
                    "ext" => $fileExt,
                    "DocumentsCategory" => "VendorDriverLicence",
                    "DocumentsCategoryID" => null,
                    "DocumentSettingID" => null,
                    "DocumentTitle" => $fileName,
                    "DocumentAccessLevel" => "111",
                    "DocumentDisplayName" => $fileName,
                    "AddedByID" => 1,
                );

                // Call method to add document
                $documentRes = (new Documents())->addDocument($docParam);
                $FSSAILicenceDocumentID = $documentRes['return_data'];
            }
        }



        $query = "INSERT INTO `Vendors` (`AccountNo`,`AccountHolderName`, `BankName`, `BankBranch`,`IFSC`,`Registration_DocumentID`,`FSSAILicenceDocumentID`,ContactNo) 
        VALUES (:AccountNo, :AccountHolderName, :BankName, :BankBranch,:IFSC,:Registration_DocumentID, :FSSAILicenceDocumentID,:ContactNo);";
        // $documentsPath = trim($documentsPath);
        $param = [
            [":AccountNo", strip_tags($data["AccountNo"])],
            [":AccountHolderName", $data["AccountHolder"]],
            [":BankName",  $data['BankName']],
            [":BankBranch",  $data['BankBranch']],
            [":IFSC",  $data['IFSC']],
            [":Registration_DocumentID",  $Registration_DocumentID],
            [":FSSAILicenceDocumentID", $FSSAILicenceDocumentID],
            [":ContactNo", $data['ContactNo']],
        ];
        $VendorID = DBController::ExecuteSQLID($query, $param);
        if ($VendorID) {
            return array("return_code" => true, "return_data" => "Vendor Register successfully");
        }
        return array("return_code" => false, "return_data" => "Unable to add Vendor Registration");
    }
    function getRequestedVendor()
    {
        $query = "SELECT v.AccountNo, v.AccountHolderName, v.BankName, v.BankBranch, v.ContactNo, v.CreatedDateTime, d.DocumentEncryptedID, d.DocumentPath AS Registration_Document, d2.DocumentPath AS FSSAILicenceDocument FROM Vendors v INNER JOIN Documents d ON d.DocumentsID = v.Registration_DocumentID INNER JOIN Documents d2 ON d2.DocumentsID = v.FSSAILicenceDocumentID WHERE `isApproved` IS NULL";
        $res = DBController::getDataSet($query);
        if ($res)
            return array("return_code" => true, "return_data" => $res);
        return array("return_code" => false, "return_data" => "No Vendor Data Available");
    }
}
