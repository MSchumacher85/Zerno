1) Настроить подключение к БД
2) Запустить миграции коммандой `php yii migrate`
3) Заполнить бд данными запустив последовательно команды
   1) `php yii seed/category`
   2) `php yii seed/author`
   3) `php yii seed/article`

Установка завершена.

# Примеры получения информации по ID
1) `/rest/categories/{id}`
2) `/rest/articles/{id}`
3) `/rest/authors/{id}`

# Примеры получения списка статей
1) при получении списка статей доступна мета информация с количеством страниц (totalPages) и количеством страниц доступным для отображения (pageSize). Количество записей можно изменить передав параметр pageSize
2) Получение статей с заголовком - test `/rest/articles?title=test`
3) Получение статей с категорией=1 - test `/rest/articles?category=1`
4) Получение статей с сортировкой по полю title - test `/rest/articles?sort=title`
5) Получение статей с сортировкой по полю title ASC - test `/rest/articles?sort=-title`


