## Few infos
- users can login using email or username & password.
- phone field is defaulted to Japan unless full specified country code used.
- users can not used disposable email addresses. 
- password has to be 8 characters minimum. 

## Routes
```
Endpoint : /register ||  Method: POST
Arguments : username, email, phone, password, password_confirmation
```
```
Endpoint : /login ||  Method: POST
Arguments : email, password
```
```
Endpoint : /me ||  Method: GET
Arguments : Bearer token
```
```
Endpoint : /update ||  Method: PATCH
Arguments : Bearer token, username, email, phone, password, password_confirmation
```
```
Endpoint : /logout ||  Method: GET
Arguments : Bearer token
```

## Packages used

-   [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) [ For API auth ]
-   [Laravel-Disposable-Email](https://github.com/Propaganistas/Laravel-Disposable-Email) [ For preventing users from using disposable emails ]
-   [Laravel-Phone](https://github.com/Propaganistas/Laravel-Phone) [ For validating phone number based on country ]

<br>
  <br>
  
This website was developed for Strawberry Jam Japan as a part of application process for backend developer position.
