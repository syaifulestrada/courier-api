    # Courier API

A RESTful API for managing courier master data, built with Laravel 13.

---

## Requirements

- PHP >= 8.3
- Composer
- MySQL
- Laravel 13

---

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/username/courier-api.git
    cd courier-api
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Copy environment file**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key**

    ```bash
    php artisan key:generate
    ```

5. **Configure database in `.env`**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=courier_api
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Run migrations and seeders**

    ```bash
    php artisan migrate --seed
    ```

7. **Start the development server**
    ```bash
    php artisan serve
    ```

---

## API Endpoints

Base URL: `http://localhost:8000/api`

| Method    | Endpoint         | Description          |
| --------- | ---------------- | -------------------- |
| GET       | `/couriers`      | List all couriers    |
| POST      | `/couriers`      | Create a new courier |
| GET       | `/couriers/{id}` | Get courier detail   |
| PUT/PATCH | `/couriers/{id}` | Update a courier     |
| DELETE    | `/couriers/{id}` | Delete a courier     |

---

## Query Parameters

Available for `GET /couriers`:

| Parameter | Example               | Description                                             |
| --------- | --------------------- | ------------------------------------------------------- |
| `search`  | `?search=budi+agung`  | Search by name (supports partial match per word)        |
| `sort`    | `?sort=registered_at` | Sort field (`name` or `registered_at`). Default: `name` |
| `order`   | `?order=desc`         | Sort direction (`asc` or `desc`). Default: `asc`        |
| `level`   | `?level=2,3`          | Filter by courier level (1–5, comma-separated)          |

**Example:**

```
GET /api/couriers?search=budi+agung&sort=registered_at&order=desc&level=2,3
```

**Response:**

```
{
    "current_page": 1,
    "data": [
        {
            "id": 201,
            "name": "Budiono Hadi Agung",
            "email": "budionohadiagung@gmail.com",
            "phone": "081231313212",
            "level": 2,
            "address": "Jl. Ahmad Yani Surabaya",
            "is_active": 1,
            "registered_at": "2026-05-18",
            "created_at": "2026-05-17T23:38:51.000000Z",
            "updated_at": "2026-05-17T23:38:51.000000Z"
        }
    ],
    "first_page_url": "http://courier-api.test/api/couriers?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://courier-api.test/api/couriers?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "page": null,
            "active": false
        },
        {
            "url": "http://courier-api.test/api/couriers?page=1",
            "label": "1",
            "page": 1,
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "page": null,
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://courier-api.test/api/couriers",
    "per_page": 10,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

---

## Request Body

### POST `/couriers` — Create Courier

| Field           | Type    | Rules                              |
| --------------- | ------- | ---------------------------------- |
| `name`          | string  | required, max 255                  |
| `email`         | string  | required, valid email, unique      |
| `phone`         | string  | required, max 13, unique           |
| `level`         | integer | required, between 1–5              |
| `address`       | string  | required                           |
| `is_active`     | boolean | required                           |
| `registered_at` | date    | required, before or equal to today |

**Example:**

```
POST /api/couriers
```

**Payload**

```
{
    name: "Agus",
    email: "agus123@gmail.com",
    phone: "08213164578",
    level: 1,
    address: "Jl. Mawar Melati 112",
    is_active: 1,
    registered_at: 2026-05-18
}
```

**Response:**

```
{
    "message": "Data successfully created",
    "data": {
        "name": "Agus",
        "email": "agus123@gmail.com",
        "phone": "08213164578",
        "level": "1",
        "address": "Jl. Mawar Melati 112",
        "is_active": "1",
        "registered_at": "2026-05-18",
        "updated_at": "2026-05-18T01:11:32.000000Z",
        "created_at": "2026-05-18T01:11:32.000000Z",
        "id": 204
    }
}
```

### PUT/PATCH `/couriers/{id}` — Update Courier

All fields are optional (`sometimes`). Same rules apply as above, with unique fields ignoring the current courier.

**Example**

```
PUT /couries/204
```

**Payload**

```
name: "Agus Hariyadi"
```

**Response**

```
{
    "message": "Data updated successfully",
    "data": {
        "id": 204,
        "name": "Agus Hariyadi",
        "email": "agus123@gmail.com",
        "phone": "08213164578",
        "level": 1,
        "address": "Jl. Mawar Melati 112",
        "is_active": 1,
        "registered_at": "2026-05-18",
        "created_at": "2026-05-18T01:11:32.000000Z",
        "updated_at": "2026-05-18T01:13:18.000000Z"
    }
}
```

### DELETE `/couriers/{id}` — Update Courier

**Example**

```
DELETE /couriers/204
```

**Response**

```
{
    "message": "Data deleted successfully"
}
```

## Running Tests

```bash
./vendor/bin/pest
```

Test coverage includes:

- `GET /couriers` — list with pagination
- `POST /couriers` — create, duplicate email, duplicate phone
- `GET /couriers/{id}` — show, not found
- `PUT /couriers/{id}` — update, not found, duplicate email, duplicate phone
- `DELETE /couriers/{id}` — delete, not found
