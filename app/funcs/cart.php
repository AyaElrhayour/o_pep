<?php
require_once("./app/config/db.php");

function findPlantInCart($plant_id)
{
  global $con;
  $query = "SELECT * FROM cart_items WHERE plant_id = ?";
  $stmt = $con->prepare($query);
  $user_id = $_SESSION["user_id"];
  $stmt->bind_param("ii", $plant_id, $user_id);
  $stmt->execute();
  return $stmt->get_result();
}

function updateQte($plant_id, $qte)
{
  global $con;
  $query = "UPDATE cart_items SET quantity = ? WHERE plant_id = ?";
  $stmt = $con->prepare($query);
  $stmt->bind_param("ii", $qte, $plant_id);
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}
function addToCart($plant_id)
{
  global $con;
  $plant = findPlantInCart($plant_id);
  if ($plant > 0) {
    updateQte($plant_id, $plant["quantity"]++);
  } else {
    $query1 = "INSERT INTO cart(user_id) VALUES(?)";
    $stmt = $con->prepare($query1);
    $user_id = $_SESSION["user_id"];
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
      $cart_id = $con->insert_id;
      $query2 = "INSERT INTO cart_items(cart_id , plant_id ) VALUES(?,?)";
      $stmt = $con->prepare($query2);
      $stmt->bind_param("ii", $cart_id, $plant_id);
      if ($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}


function cartShow()
{
  global $con;
  $query = "SELECT * FROM plants p JOIN cart_items ci ON p.plant_id = ci.plant_id JOIN cart c ON c.cart_id = ci.cart_id JOIN users u ON u.user_id = c.user_id WHERE c.user_id = ?";
  $stmt = $con->prepare($query);
  $user_id = $_SESSION["user_id"];
  $stmt->bind_param("i", $user_id);
  if ($stmt->execute()) {
    return $stmt->get_result();
  } else {
    return false;
  }
}
