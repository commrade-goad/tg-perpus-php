# LIST OF API AND HOW TO USE IT
## Hierarcy
```
├── api
│   ├── add_book
│   ├── add_tag
│   ├── add_user
│   ├── auth_destroy
│   ├── auth_user
│   ├── del_book
│   ├── del_tag
│   ├── del_user
│   ├── edit_book
│   ├── edit_tag
│   ├── edit_user
│   ├── get_book
│   ├── get_book_count
│   ├── get_book_from_tag
│   ├── get_tag
│   └── get_user
```

## Usage
**NOTE: ALL THE API USE GET FOR NOW**

1. `add_book` (admin access)

    - accept : `title`, `author`, `desc`, `tags`, `year`, `cover`
    - usage  : see [test.py](./test.py)
    - return : `error` or `success` with a string

2. `add_tag` (admin access)

    - accept : `name`, `img`(Optional)
    - usage  : `localhost/api/add_tag?name=manajemen&img=%2Fpath%2Fto%2Ffile.png`
    - return : `error` or `success` with a string

3. `add_user` (admin access)

    - accept : `id`, `password`, `type`
    - usage  : `localhost/api/add_user?id=1&password=yourpassword&type=1`
    - return : `error` or `success` with a string

4. `auth_destroy`

    - accept : none
    - usage  : `localhost/api/auth_destroy`
    - return : `success` with integer (1 success, 0 failed)

5. `auth_user`

    - accept : `id`, `password`
    - usage  : `localhost/api/auth_user?id=0&password=passDefinedAtConfig`
    - return : `success` with integer (1 success, 0 failed)

6. `del_book` (admin access)

    - accept : `id`
    - usage  : `localhost/api/del_book?id=1`
    - return : `error` or `success` with a string

7. `del_tag` (admin access)

    - accept : `id`
    - usage  : `localhost/api/del_tag?id=1`
    - return : `error` or `success` with a string

8. `del_user` (admin access)

    - accept : `id`
    - usage  : `localhost/api/del_user?id=1`
    - return : `error` or `success` with a string


9. `edit_book` (admin access)

    - accept : `id`, `title`, `author`, `desc`, `tags`, `year`, `cover`
    - usage  : see [test.py](./test.py) and add the `id=1`
    - return : `error` or `success` with a string

10. `edit_tag` (admin access)

    - accept : `id`, `name`, `img`(Optional)
    - usage  : `localhost/api/edit_tag?id=1&name=manajemen&img=%2Fpath%2Fto%2Ffile.png`
    - return : `error` or `success` with a string

11. `edit_user` (admin access)

    - accept : `id`, `password`
    - usage  : `localhost/api/edit_user?id=2&password=newPassword`
    - return : `error` or `success` with a string

12. `get_book`

    - accept : `id`(to take one book info), `from`, `range`, `sort`
    - usage  : `localhost/api/get_book?id=2`
    - usage  : `localhost/api/get_book?from=0&range=20&sort=ASC`
    - return : book json

13. `get_book_count`

    - accept : none
    - usage  : `localhost/api/get_book_count`
    - return : `count`: bookcount

14. `get_book_from_tag`

    - accept : `from`, `range`, `sort`
    - usage  : `localhost/api/get_book_from_tag?from=0&range=20&sort=DESC`
    - return : book json

15. `get_tag`

    - accept : `from`, `range`, `sort`
    - usage  : `localhost/api/get_tag?from=0&range=20`
    - return : tag json

15. `get_user`

    - accept : `from`, `range`, `sort`
    - usage  : `localhost/api/get_user?from=0&range=20`
    - return : user json

