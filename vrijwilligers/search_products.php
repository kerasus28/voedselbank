<?php
include '../components/connect.php';

if (isset($_POST['searchQuery'])) {
    $search_query = $_POST['searchQuery'];

    if (!empty($search_query)) {
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE ? OR streepjescode LIKE ?");
        $select_products->execute(["%$search_query%", "%$search_query%"]);

        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                // Toon de gevonden producten
                echo '<div class="box">';
                echo '<img src="../uploaded_img/' . $fetch_products['image_01'] . '" alt="">';
                echo '<div class="name">' . $fetch_products['name'] . '</div>';
                echo '<div class="price"><span>' . $fetch_products['price'] . '</span></div>';
                echo '<div class="details"><span>' . $fetch_products['details'] . '</span></div>';
                echo '<div class="flex-btn">';
                echo '<a href="update_product.php?update=' . $fetch_products['id'] . '" class="option-btn">update</a>';
                echo '</div></div>';
            }
        } else {
            echo '<p class="empty">Geen overeenkomende producten gevonden!</p>';
        }
    } else {
        echo '<p class="empty">Geen zoekopdracht ingevoerd!</p>';
    }
}
?>
