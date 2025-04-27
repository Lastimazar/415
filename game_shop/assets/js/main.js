$(document).ready(function() {
    // Добавление товара в корзину
    $(document).on('click', '.add-to-cart', function() {
        const productId = $(this).data('id');
        
        $.ajax({
            url: 'ajax/cart_actions.php',
            type: 'POST',
            data: {
                action: 'add',
                product_id: productId
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.success) {
                    showAlert('success', res.message);
                    updateCartCounter();
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function() {
                showAlert('danger', 'Ошибка сервера');
            }
        });
    });
    
    // Удаление товара из корзины
    $(document).on('click', '.remove-from-cart', function() {
        const cartId = $(this).data('id');
        
        if (confirm('Вы уверены, что хотите удалить товар из корзины?')) {
            $.ajax({
                url: 'ajax/cart_actions.php',
                type: 'POST',
                data: {
                    action: 'remove',
                    cart_id: cartId
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        showAlert('success', res.message);
                        location.reload(); // Перезагружаем страницу для обновления корзины
                    } else {
                        showAlert('danger', res.message);
                    }
                },
                error: function() {
                    showAlert('danger', 'Ошибка сервера');
                }
            });
        }
    });
    
    // Изменение количества товара
    $(document).on('click', '.update-quantity', function() {
        const cartId = $(this).data('id');
        const action = $(this).data('action');
        const input = $(this).closest('.input-group').find('.quantity-input');
        let quantity = parseInt(input.val());
        
        if (action === 'increase') {
            quantity++;
        } else if (action === 'decrease' && quantity > 1) {
            quantity--;
        }
        
        input.val(quantity);
        
        $.ajax({
            url: 'ajax/cart_actions.php',
            type: 'POST',
            data: {
                action: 'update_quantity',
                cart_id: cartId,
                quantity: quantity
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.success) {
                    if (res.message === 'Товар удален из корзины') {
                        location.reload();
                    } else {
                        // Обновляем только сумму строки
                        const row = input.closest('tr');
                        const price = parseFloat(row.find('td:eq(2)').text());
                        const sum = price * quantity;
                        row.find('td:eq(4)').text(sum.toFixed(2) + ' руб.');
                        updateTotal();
                    }
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function() {
                showAlert('danger', 'Ошибка сервера');
            }
        });
    });
    
    // Применение фильтров
    $('#apply-filters').on('click', function() {
        const selectedGenres = [];
        $('.genre-filter:checked').each(function() {
            selectedGenres.push($(this).val());
        });
        
        const platform = $('#platform-filter').val();
        
        $('.product-card').each(function() {
            const genre = $(this).data('genre');
            const productPlatform = $(this).data('platform');
            let show = true;
            
            // Проверка жанра
            if (selectedGenres.length > 0 && !selectedGenres.includes(genre)) {
                show = false;
            }
            
            // Проверка платформы
            if (platform && productPlatform.indexOf(platform) === -1) {
                show = false;
            }
            
            if (show) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Функция обновления счетчика корзины
    function updateCartCounter() {
        $.ajax({
            url: 'ajax/get_cart_count.php',
            type: 'GET',
            success: function(count) {
                $('.cart-counter').text(count);
            }
        });
    }
    
    // Функция показа уведомлений
    function showAlert(type, message) {
        const alert = `<div class="alert alert-${type} alert-dismissible fade show fixed-alert">
                          ${message}
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                       </div>`;
        $('body').append(alert);
        setTimeout(() => $('.fixed-alert').alert('close'), 3000);
    }
    
    // Инициализация счетчика корзины при загрузке страницы
    updateCartCounter();
});