<?php
include 'includes/header.php';
?>

<div class="container">
    <h1 class="text-center my-5">Добро пожаловать в наш магазин игр!</h1>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Блок фильтров -->
            <div class="card filter-card">
                <div class="card-header">
                    <h5>Фильтры</h5>
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="form-group">
                            <label>Жанр:</label>
                            <div class="form-check">
                                <input class="form-check-input genre-filter" type="checkbox" value="RPG" id="rpg">
                                <label class="form-check-label" for="rpg">RPG</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input genre-filter" type="checkbox" value="Action" id="action">
                                <label class="form-check-label" for="action">Action</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input genre-filter" type="checkbox" value="Adventure" id="adventure">
                                <label class="form-check-label" for="adventure">Adventure</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Платформа:</label>
                            <select class="form-control" id="platform-filter">
                                <option value="">Все</option>
                                <option value="PC">PC</option>
                                <option value="PS4">PlayStation 4</option>
                                <option value="PS5">PlayStation 5</option>
                                <option value="Xbox">Xbox</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary btn-block" id="apply-filters">Применить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Блок товаров -->
            <div class="row" id="products-container">
                <?php
                // Подключаемся к базе данных
                include 'config.php';
                
                // Запрос для получения всех товаров
                $query = "SELECT * FROM products ORDER BY release_date DESC LIMIT 6";
                $stmt = $db->prepare($query);
                $stmt->execute();
                
                // Выводим товары
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="col-md-4 mb-4 product-card" data-genre="'.$row['genre'].'" data-platform="'.$row['platform'].'">
                        <div class="card h-100 game-card">
                            <img src="assets/images/'.$row['image_url'].'" class="card-img-top" alt="'.$row['name'].'">
                            <div class="card-body">
                                <h5 class="card-title">'.$row['name'].'</h5>
                                <p class="card-text">'.substr($row['description'], 0, 100).'...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge badge-primary">'.$row['genre'].'</span>
                                    <span class="price">'.$row['price'].' руб.</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-success btn-block add-to-cart" data-id="'.$row['id'].'">В корзину</button>
                                <a href="product.php?id='.$row['id'].'" class="btn btn-outline-primary btn-block mt-2">Подробнее</a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>