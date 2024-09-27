<?php

namespace app\modules\delivery\classes;

use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;
use app\modules\vendor\classes\Session;
use app\modules\documents\classes\Documents;

class Delivery
{

    /* 
    Current Version: 2.0.0
    Created By: Devkanta,     dev1@techz.in
    Created On: 04/09/2024
    Modified By:
    Modified On: 

*/

    function saveDelivery($data)
    {

        //check account exist before creating
        $query = "SELECT COUNT(*) as count  FROM `Delivery_Partners` WHERE `AccountNo`=:AccountNo  AND AccountHolderName=:AccountHolderName LIMIT 1;";
        $checkparam = [
            [":AccountNo", strip_tags($data["AccountNo"])],
            [":AccountHolderName", strip_tags($data["AccountHolder"])]
        ];
        $delivery = DBController::sendData($query, $checkparam);
        if ($delivery['count'] > 0) {
            return array("return_code" => false, "return_data" => "Same Account already exist");
        }

        $VehicleFileDocumentID = 0;
        if (!empty($data['vehicleFile'])) {
            $files = is_array(value: $data['vehicleFile']) ? $data['vehicleFile'] : array($data['vehicleFile']); // Handle single file or array of files

            // Extract file data
            $fileData = isset($files['vehicleFile']) ? $files['vehicleFile'] : '';
            $fileName = isset($files['filename']) ? $files['filename'] : '';
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            // Check if file data and filename are available
            if ($fileData && $fileName) {
                // Prepare document parameters
                $docParam = array(
                    "file" => $fileData,
                    "ext" => $fileExt,
                    "DocumentsCategory" => "DeliveryVehicleFile",
                    "DocumentsCategoryID" => null,
                    "DocumentSettingID" => null,
                    "DocumentTitle" => $fileName,
                    "DocumentAccessLevel" => "111",
                    "DocumentDisplayName" => $fileName,
                    "AddedByID" => 1,
                );

                // Call method to add document
                $documentRes = (new Documents())->addDocument($docParam);
                $VehicleFileDocumentID = $documentRes['return_data'];
            }
        }
        $DriverLicenceDocumentID = 0;
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
                    "DocumentsCategory" => "DeliveryDriverLicence",
                    "DocumentsCategoryID" => null,
                    "DocumentSettingID" => null,
                    "DocumentTitle" => $fileName,
                    "DocumentAccessLevel" => "111",
                    "DocumentDisplayName" => $fileName,
                    "AddedByID" => 1,
                );

                // Call method to add document
                $documentRes = (new Documents())->addDocument($docParam);
                $DriverLicenceDocumentID = $documentRes['return_data'];
            }
        }
        $Residentail_DocumentID = 0;
        if (!empty($data['RCCFile'])) {
            $files = is_array($data['RCCFile']) ? $data['RCCFile'] : array($data['RCCFile']); // Handle single file or array of files

            // Extract file data
            $fileData = isset($files['rcc_file']) ? $files['rcc_file'] : '';
            $fileName = isset($files['filename']) ? $files['filename'] : '';
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            // Check if file data and filename are available
            if ($fileData && $fileName) {
                // Prepare document parameters
                $docParam = array(
                    "file" => $fileData,
                    "ext" => $fileExt,
                    "DocumentsCategory" => "DeliveryRCCFile",
                    "DocumentsCategoryID" => null,
                    "DocumentSettingID" => null,
                    "DocumentTitle" => $fileName,
                    "DocumentAccessLevel" => "111",
                    "DocumentDisplayName" => $fileName,
                    "AddedByID" => 1,
                );

                // Call method to add document
                $documentRes = (new Documents())->addDocument($docParam);
                $Residentail_DocumentID = $documentRes['return_data'];
            }
        }


        $query = "INSERT INTO `Delivery_Partners`(ContactNo,Driving_Licence_DocumentID,Vehicle_DocumentID,Residentail_DocumentID,`AccountNo`,`AccountHolderName`, `BankName`, `BankBranch`,`IFSC`) 
    VALUES (:ContactNo,:Driving_Licence_DocumentID,:Vehicle_DocumentID,:Residentail_DocumentID,:AccountNo, :AccountHolderName,:BankName,:BankBranch,:IFSC);";
        // $documentsPath = trim($documentsPath);
        $param = [
            [":ContactNo", $data['ContactNo']],
            [":Driving_Licence_DocumentID", $DriverLicenceDocumentID],
            [":Vehicle_DocumentID", $VehicleFileDocumentID],
            [":Residentail_DocumentID", $Residentail_DocumentID],
            [":AccountNo", strip_tags($data["AccountNo"])],
            [":AccountHolderName", $data["AccountHolder"]],
            [":BankName",  $data['BankName']],
            [":BankBranch",  $data['BankBranch']],
            [":IFSC",  $data['IFSC']]
        ];
        $Delivery = DBController::ExecuteSQL($query, $param);
        if ($Delivery) {
            return array("return_code" => true, "return_data" => "Delivery Registered successfully");
        }
        return array("return_code" => false, "return_data" => "Unable to add Delivery Registration");
    }
    function getRequestedDelivery()
    {
        $query = "SELECT  d.DocumentPath AS DriverLicencePath,  d1.DocumentPath AS VehicleDocumentPath, d2.DocumentPath AS ResidentialDocumentPath,dp.ContactNo,dp.AccountNo,dp.BankName,dp.BankBranch,dp.IFSC,dp.AccountHolderName,dp.CreatedDateTime
FROM 
    Delivery_Partners dp 
INNER JOIN 
    Documents d ON d.DocumentsID = dp.Driving_Licence_DocumentID
INNER JOIN 
    Documents d1 ON d1.DocumentsID = dp.Vehicle_DocumentID 
INNER JOIN 
    Documents d2 ON d2.DocumentsID = dp.Residentail_DocumentID;";
        $requestedDelivery = DBController::getDataSet($query);
        if ($requestedDelivery)
            return array("return_code" => true, "return_data" => $requestedDelivery);
        return array("return_code" => false, "return_data" => "No requested delivery found");
    }
}
