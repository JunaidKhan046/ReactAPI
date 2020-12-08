---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://127.0.0.1:8000/docs/collection.json)

<!-- END_INFO -->

#React API


<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
## Create a new user instance after a valid registration.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/register" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"name":"user","email":"user@test.com","password":"9657Ex@!1","password_confirmation":"9657Ex@!1."}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/register"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "name": "user",
    "email": "user@test.com",
    "password": "9657Ex@!1",
    "password_confirmation": "9657Ex@!1."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "Login Successfully.",
        "auth": {
            "access_token": "{token}",
            "token_type": "bearer",
            "expires_in": 3600,
            "user": {
                "id": 3,
                "name": "Junaid Khan",
                "email": "khanjunaid046@gmail.com",
                "email_verified_at": "null"
            }
        }
    }
}
```
> Example response (400):

```json
{
    "data": {
        "statusCode": "400",
        "status": "Bad Request",
        "message": "The email has already been taken."
    }
}
```

### HTTP Request
`POST api/auth/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The name of the user.
        `email` | string |  required  | unique The email of the user.
        `password` | alphanumeric |  required  | min:8 The password of the user.
        `password_confirmation` | alphanumeric |  required  | min:8 The confirm password of the user.
    
<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login user instance after a valid registration.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/login" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"user@test.com","password":"9657Ex@!1"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "email": "user@test.com",
    "password": "9657Ex@!1"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "auth": {
            "access_token": "{token}",
            "token_type": "bearer",
            "expires_in": "3600",
            "user": {
                "id": "3",
                "name": "Junaid Khan",
                "email": "khanjunaid046@gmail.com",
                "email_verified_at": "null"
            }
        }
    }
}
```
> Example response (400):

```json
{
    "data": {
        "statusCode": "400",
        "status": "Bad Request",
        "message": "The password format is invalid."
    }
}
```
> Example response (401):

```json
{
    "data": {
        "statusCode": "401",
        "status": "Unauthorized",
        "message": "These credentials do not match our records."
    }
}
```
> Example response (500):

```json
{
    "data": {
        "statusCode": "500",
        "status": "Server Error",
        "message": "Server exception."
    }
}
```

### HTTP Request
`POST api/auth/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | unique The email of the user.
        `password` | alphanumeric |  required  | min:8 The password of the user.
    
<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_19ff1b6f8ce19d3c444e9b518e8f7160 -->
## Log the user out (Invalidate the token).

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/logout" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"token":"token"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/logout"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "token": "token"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "'Successfully logged out"
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/auth/logout`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `token` | string |  required  | The string of the user auth token.
    
<!-- END_19ff1b6f8ce19d3c444e9b518e8f7160 -->

<!-- START_2f9eabfc6a8fa442ec422bd6f6f26519 -->
## Send a reset link to the given user.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/password/forget" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"user@test.com"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/password/forget"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "email": "user@test.com"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "We have e-mailed your password reset link!"
    }
}
```
> Example response (400):

```json
{
    "data": {
        "statusCode": "400",
        "status": "Bad Request",
        "message": "We can't find a user with that e-mail address."
    }
}
```

### HTTP Request
`POST api/auth/password/forget`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | The email of the user.
    
<!-- END_2f9eabfc6a8fa442ec422bd6f6f26519 -->

<!-- START_b24783c060b90093f81dc015cbcd068f -->
## Reset the given user&#039;s password.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/password/reset" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"user@test.com","password":"9657Ex@!1","password_confirmation":"9657Ex@!1","token":"token"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/password/reset"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "email": "user@test.com",
    "password": "9657Ex@!1",
    "password_confirmation": "9657Ex@!1",
    "token": "token"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "Your password has been reset!"
    }
}
```
> Example response (400):

```json
{
    "data": {
        "statusCode": "400",
        "status": "Bad Request",
        "message": "This password reset token is invalid or expired."
    }
}
```

### HTTP Request
`POST api/auth/password/reset`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | unique The email of the user.
        `password` | alphanumeric |  required  | min:8 The password of the user.
        `password_confirmation` | alphanumeric |  required  | min:8 The confirm password of the user.
        `token` | string |  required  | The reset token of the user we have sent the email.
    
<!-- END_b24783c060b90093f81dc015cbcd068f -->

<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
## Refresh a token.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/refresh" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/refresh"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "Login Successfully.",
        "auth": {
            "access_token": "token",
            "token_type": "bearer",
            "expires_in": 3600,
            "user": {
                "id": 3,
                "name": "Junaid Khan",
                "email": "khanjunaid046@gmail.com",
                "email_verified_at": null
            }
        }
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/auth/refresh`


<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->

<!-- START_a47210337df3b4ba0df697c115ba0c1e -->
## Get the authenticated User.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/me" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/me"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "user": {
            "id": 3,
            "name": "Junaid Khan",
            "email": "khanjunaid046@gmail.com",
            "email_verified_at": null
        }
    }
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`POST api/auth/me`


<!-- END_a47210337df3b4ba0df697c115ba0c1e -->

<!-- START_07f2bc00bb1c0f95c909f7772ec7a8f2 -->
## Send the email verification notification.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/resend" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"email":"user@test.com"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/resend"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "email": "user@test.com"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "Your email verification link has been successfully sent. or email already verified."
    }
}
```

### HTTP Request
`POST api/auth/resend`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | The email of the user.
    
<!-- END_07f2bc00bb1c0f95c909f7772ec7a8f2 -->

<!-- START_ab3ce89a5249d02e7d0c5bcab416e798 -->
## Mark the authenticated user&#039;s email address as verified.

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/auth/verify" \
    -H "Content-Type: application/json" \
    -H "X-Requested-With: XMLHttpRequest" \
    -H "Authorization: Bearer {token}" \
    -d '{"expires":"1607095509","hash":"8331c2de507b8ac5bd9118e3962d20ad3e486bd7","id":1,"signature":"06f3b646233bb92fabde010cf202564c84d1ed23cd7c8f97c1073fae59d9957b"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/auth/verify"
);

let headers = {
    "Content-Type": "application/json",
    "X-Requested-With": "XMLHttpRequest",
    "Authorization": "Bearer {token}",
    "Accept": "application/json",
};

let body = {
    "expires": "1607095509",
    "hash": "8331c2de507b8ac5bd9118e3962d20ad3e486bd7",
    "id": 1,
    "signature": "06f3b646233bb92fabde010cf202564c84d1ed23cd7c8f97c1073fae59d9957b"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "data": {
        "statusCode": "200",
        "status": "OK Request",
        "message": "Email verify successfully or email already verified."
    }
}
```

### HTTP Request
`POST api/auth/verify`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `expires` | string |  required  | The expire of the user.
        `hash` | string |  required  | The has of the user.
        `id` | integer |  required  | The id of the user.
        `signature` | string |  required  | The signature of the user.
    
<!-- END_ab3ce89a5249d02e7d0c5bcab416e798 -->


