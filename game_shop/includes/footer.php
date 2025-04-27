    <!-- Подвал сайта -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Game Shop</h5>
                    <p>Лучший магазин видеоигр с 2023 года</p>
                </div>
                <div class="col-md-4">
                    <h5>Контакты</h5>
                    <p>Email: info@gameshop.ru</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                </div>
                <div class="col-md-4">
                    <h5>Мы в соцсетях</h5>
                    <a href="#" class="text-white mr-2">Facebook</a>
                    <a href="#" class="text-white mr-2">Twitter</a>
                    <a href="#" class="text-white">Instagram</a>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>&copy; 2025 QuestHorizon. Все права защищены.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Переключение темы
        $('#theme-toggle').on('click', function() {
            $('body').toggleClass('dark-mode');
            localStorage.setItem('darkMode', $('body').hasClass('dark-mode'));
        });
        
        // Проверка сохраненной темы
        if (localStorage.getItem('darkMode') === 'true') {
            $('body').addClass('dark-mode');
        }
        
        // Показать анимацию загрузки при переходе по ссылкам
        $(document).on('click', 'a', function() {
            const href = $(this).attr('href');
            if (href && href !== '#' && !$(this).hasClass('no-loading')) {
                $('.loading-animation').show();
            }
        });
    </script>
</body>
</html>