<?php
require_once '../../BusinessLayer/model/manageOrderModel.php';

class manageOrderController{
    
    function viewGood(){
        $service = new manageOrderModel();
        return $service->viewAllGood();
    }

    function viewFood(){
        $service = new manageOrderModel();
        return $service->viewAllFood();
    }

    function viewPet(){
        $service = new manageOrderModel();
        return $service->viewAllPet();
    }

    function viewMedical(){
        $service = new manageOrderModel();
        return $service->viewAllMedical();
    }

    //add item to the cart
    function addCart(){
        $service = new manageOrderModel();
        $service->custID = $_SESSION['custID'];
        $service->serviceID = $_POST['serviceID'];
        $service->itemname = $_POST['itemname'];
        $service->itemprice = $_POST['itemprice'];
        $service->itemquantity = $_POST['itemquantity'];
    
        // Check if the item already exists in the cart and update or insert accordingly
        $existingCartItem = $service->getCartItem($service->custID, $service->serviceID);
    
        if ($existingCartItem) {
            // Item exists in the cart, update its quantity
            $service->updateCartItem($service->custID, $service->serviceID, $existingCartItem['itemquantity'] + $service->itemquantity);
        } else {
            // Item doesn't exist, add a new entry to the cart
            $service->addToCart($service->custID, $service->serviceID, $service->itemname, $service->itemprice, $service->itemquantity);
        }
    
        // Redirect to the page where the cart is displayed or managed
        header("Location: ./customerViewCart.php?custID=".$_SESSION['custID']);
        exit();
    }

    //to view the cart
    function viewOrder(){
        $service = new manageOrderModel();
        $service->custID = $_SESSION['custID'];
        return $service->viewAllOrder();
    }

    function delete() {
        $service = new manageOrderModel();
        $service->custID = $_SESSION['custID'];
        $service->serviceID = $_POST['serviceID'];
        if($service->deleteOrder()){
            $message = "Delete Successful!";
            echo "<script type='text/javascript'>alert('$message');
            window.location = './customerViewCart.php?custID=".$_SESSION['custID']."';</script>";
        }
    }

    function updateOrder(){
        $service = new manageOrderModel();
        $service->custID = $_SESSION['custID'];
        $service->serviceID = $_POST['serviceID'];
        $service->itemname = $_POST['itemname'];
        $service->itemprice = $_POST['itemprice'];
        $service->itemquantity = $_POST['itemquantity'];

        if($service->updateOrders()){
            $message = "Success Update!";
		    echo "<script type='text/javascript'>alert('$message');
		    window.location = './customerViewCart.php?custID=".$_SESSION['custID']."';</script>";
        }
    }
}
?>
