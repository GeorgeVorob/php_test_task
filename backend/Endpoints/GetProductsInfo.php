<?php
require_once("../DataAccessLayer/ProductsDAL.php");

echo json_encode(ProductsDAL::GetAllProducts());
