<?php
require_once '../../BusinessLayer/model/manageServiceModel.php';

class manageServiceController{
    
    function add(){
        $item = new manageServiceModel();
        $item->spID = $_SESSION['spID'];
        $item->servicetype = $_POST['servicetype'];
        $item->itemname = $_POST['itemname'];
        $item->itemprice = $_POST['itemprice'];
        $item->itemimage = $_FILES['itemimage']['name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["itemimage"]["name"]);
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
        // Check extension
        if( in_array($imageFileType,$extensions_arr) ){
          // Convert to base64
          $image_base64 = base64_encode(file_get_contents($_FILES['itemimage']['tmp_name']) );
          $item->itemimage = 'data:image/'.$imageFileType.';base64,'.$image_base64;
        }

        if($item->addItem() > 0){
            $message = "Success Insert!";
			echo "<script type='text/javascript'>alert('$message');
			window.location = '../../ApplicationLayer/manageService/serviceProviderServiceView.php?spID=".$_SESSION['spID']."';</script>";
        }
    }

    function delete(){
        $item = new manageServiceModel();
        $item->serviceID = $_POST['serviceID'];
        if($item->deleteItem()){
            $message = "Success Delete!";
			echo "<script type='text/javascript'>alert('$message');
			window.location = '../../ApplicationLayer/manageService/serviceProviderServiceView.php?spID=".$_SESSION['spID']."';</script>";
        }
    }

    function viewAll(){
        $item = new manageServiceModel();
        $item->spID = $_SESSION['spID'];
        return $item->viewAllItem();
    }

    function viewItem($serviceID){
        $item = new manageServiceModel();
        $item->serviceID = $serviceID;
        return $item->viewPerItem();
    }
     
     function update(){
        $item = new manageServiceModel();
        $item->serviceID = $_POST['serviceID'];
        $item->itemname = $_POST['itemname'];
        $item->itemprice = $_POST['itemprice'];
        $item->servicetype = $_POST['servicetype'];
        $updateSuccess = false;
    
        // Handle image update
        if ($_FILES['new_itemimage']['size'] > 0) {
            // Process the new image and update the item image in the model
            $target_dir = "upload/";
            $target_file = $target_dir . basename($_FILES["new_itemimage"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
            // Check file extension
            $extensions_arr = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $extensions_arr)) {
                // Temporary file location
                $temp_file = $_FILES['new_itemimage']['tmp_name'];
    
                // Read the image file content
                $image_content = file_get_contents($temp_file);
    
                // Encode image content in base64
                $base64_image = base64_encode($image_content);
    
                // Set the itemimage property in the model with base64 encoded data
                $item->itemimage = 'data:image/' . $imageFileType . ';base64,' . $base64_image;
            }
        }
    
        if($item->updateItem()){
            // Your success message and redirection logic
            $updateSuccess = true;
        }
    
        return $updateSuccess;
    }
    }
?>
