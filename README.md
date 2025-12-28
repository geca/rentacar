# Rent-a-Car Laravel Application

This is a simple Laravel application for managing a rent-a-car business. The application provides RESTful API endpoints for managing countries, cities, users (customers and providers), and cars.

## Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or another supported database

### Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy `.env.example` to `.env` and configure your database
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## Accessing the Application

### Web GUI
The web interface is accessible at:
- **Local development**: `http://localhost:8000` or `http://127.0.0.1:8000`
- **Home page**: Displays the cars index view

### API Base URL
All API endpoints are prefixed with `/api`:
- **Base URL**: `http://localhost:8000/api`

## API Routes

### Countries

#### Get All Countries
```
GET /api/countries
```

#### Create Country
```
POST /api/countries
Content-Type: application/json

{
  "name": "United States",
  "code": "US",
  "short_name": "USA",
  "in_eu": false
}
```

#### Update Country
```
PUT /api/countries/{id}
Content-Type: application/json

{
  "name": "United States of America",
  "code": "US",
  "short_name": "USA",
  "in_eu": false
}
```

#### Delete Country
```
DELETE /api/countries/{id}
```

---

### Cities

#### Get All Cities
```
GET /api/cities
```

#### Create City
```
POST /api/cities
Content-Type: application/json

{
  "name": "New York",
  "postal_code": "10001",
  "country_id": 1
}
```

#### Update City
```
PUT /api/cities/{id}
Content-Type: application/json

{
  "name": "New York City",
  "postal_code": "10001",
  "country_id": 1
}
```

#### Delete City
```
DELETE /api/cities/{id}
```

---

### Users

#### Get All Users
```
GET /api/users
```

#### Get User by ID
```
GET /api/users/{id}
```

#### Create User
```
POST /api/users
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "securepassword123",
  "user_type": "customer",
  "country_id": 1,
  "city_id": 1
}
```

**For Rent-a-Car Provider:**
```json
{
  "name": "Jane Smith",
  "email": "jane@rentalcompany.com",
  "password": "securepassword123",
  "user_type": "provider",
  "business_name": "Best Car Rentals",
  "tax_id": "123456789",
  "country_id": 1,
  "city_id": 1
}
```

#### Update User
```
PUT /api/users/{id}
Content-Type: application/json

{
  "name": "John Updated",
  "email": "john.updated@example.com",
  "user_type": "customer",
  "country_id": 1,
  "city_id": 2
}
```

#### Delete User
```
DELETE /api/users/{id}
```

---

### Cars

#### Get All Cars
```
GET /api/cars
```

#### Get Car by ID
```
GET /api/cars/{id}
```

#### Create Car
```
POST /api/cars
Content-Type: application/json

{
  "provider_id": 2,
  "make": "Toyota",
  "model": "Camry",
  "year": 2023,
  "color": "Silver",
  "license_plate": "ABC-1234",
  "transmission": "automatic",
  "fuel_type": "gasoline",
  "seats": 5,
  "doors": 4,
  "daily_rate": 45.00,
  "country_id": 1,
  "city_id": 1,
  "status": "available"
}
```

**Status options**: `available`, `rented`, `maintenance`

#### Update Car
```
PUT /api/cars/{id}
Content-Type: application/json

{
  "make": "Toyota",
  "model": "Camry",
  "year": 2023,
  "color": "Blue",
  "license_plate": "ABC-1234",
  "transmission": "automatic",
  "fuel_type": "gasoline",
  "seats": 5,
  "doors": 4,
  "daily_rate": 50.00,
  "country_id": 1,
  "city_id": 1,
  "status": "available"
}
```

#### Delete Car
```
DELETE /api/cars/{id}
```

---

## Data Models

### Country
- `name` (string, required)
- `code` (string, required) - ISO country code
- `short_name` (string, required)
- `in_eu` (boolean, required)

### City
- `name` (string, required)
- `postal_code` (string, required)
- `country_id` (integer, required) - Foreign key to countries

### User
- `name` (string, required)
- `email` (string, required, unique)
- `password` (string, required)
- `user_type` (string, required) - `customer` or `provider`
- `business_name` (string, optional) - For providers
- `tax_id` (string, optional) - For providers
- `country_id` (integer, required)
- `city_id` (integer, required)

### Car
- `provider_id` (integer, required) - Foreign key to users
- `make` (string, required)
- `model` (string, required)
- `year` (integer, required)
- `color` (string, required)
- `license_plate` (string, required)
- `transmission` (string, required)
- `fuel_type` (string, required)
- `seats` (integer, required)
- `doors` (integer, required)
- `daily_rate` (decimal, required)
- `country_id` (integer, required)
- `city_id` (integer, required)
- `status` (string, required) - `available`, `rented`, or `maintenance`

## Testing the API

You can test the API using tools like:
- **Postman**
- **cURL**
- **Insomnia**
- **VS Code REST Client extension**

Example cURL request:
```bash
curl -X GET http://localhost:8000/api/cars
curl -X POST http://localhost:8000/api/cars \
  -H "Content-Type: application/json" \
  -d '{"provider_id":1,"make":"Honda","model":"Civic","year":2024,"color":"Red","license_plate":"XYZ-789","transmission":"manual","fuel_type":"gasoline","seats":5,"doors":4,"daily_rate":40.00,"country_id":1,"city_id":1,"status":"available"}'
```

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



php artisan migrate

php artisan make:migration create_countries_table --create=country

glej skrinšot
php artisan migrate