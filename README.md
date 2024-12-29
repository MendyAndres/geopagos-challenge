# Tennis Tournament API

## Project Purpose

This project is a solution for a technical challenge aimed at modeling and simulating a tennis tournament.

### Challenge Requirements

The system models the following behavior for a tennis tournament:

1. The tournament uses a **single-elimination** format.
2. **Tournament Types**:
    - **Male Tournament**:
        - A male player's **strength** and **speed** are considered as additional parameters along with skill level and random luck to determine the winner.
    - **Female Tournament**:
        - A female player's **reaction time** along with skill level and random luck impacts the decision of the winner.
3. Players:
    - Each player has a **name** and a **skill level** (ranging from 0 to 100).
    - Male players also have attributes for **strength** and **speed**.
    - Female players have an attribute for **reaction time**.


## Domain-Driven Design (DDD) Structure

This project is organized following **Domain-Driven Design (DDD)** and **Clean Architecture** principles. Here's a breakdown of the primary structure:

### Layer Overview

1. **Application Layer**:
    - Contains all **Use Cases** necessary to orchestrate the business logic for `Tournaments` and `Players`.

2. **Domain Layer**:
    - Houses the core entities, services(business logic), and interfaces for repositories.

3. **Infrastructure Layer**:
    - Provides implementations for repository interfaces using Eloquent.
    - Contains controllers, HTTP requests, and routes for interacting with the API.


## Installation Instructions

This project utilizes **Laravel Sail** to provide a robust and containerized backend development environment. Follow these steps to set up the API:

### Prerequisites
Ensure the following are installed:
- **Docker** and **Docker Compose**: Required for Laravel Sail containers.
- **PHP 8.1+**.
- **Composer**: To install Laravel dependencies.

---

### Steps

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   cd <repository-name>
   ```

2. **Install dependencies**:
 
    ```bash
   composer install
   ```

3. **Copy the `.env` file**:

   ```bash
   cp .env.example .env
   ```

   You can adjust any necessary environment variables in `.env` as required (e.g., database). Laravel Sail defaults should work fine out of the box.

4. **Start Laravel Sail**:

   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Run migrations and seed the database**:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

---

### Accessing the API

Once the setup is complete, the API will be available at:  
`http://localhost`.

You can interact with endpoints under `http://localhost/api/v1` using tools like **Postman** or **cURL**.

---

### Useful Sail Commands

1. **Stop the containers**:
   ```bash
   ./vendor/bin/sail down
   ```

2. **Restart the environment**:
   ```bash
   ./vendor/bin/sail up -d
   ```

3. **Execute Artisan Commands**:
   Use Artisan commands inside the container:
   ```bash
   ./vendor/bin/sail artisan <command>
   ```

4. **Open a shell inside the PHP container**:
   ```bash
   ./vendor/bin/sail shell
   ```

5. **Access the MySQL database**:
   ```bash
   ./vendor/bin/sail mysql
   ```

---

### Testing the API

You can run all tests using Sail to ensure that everything is working as expected:
    ```bash
    ./vendor/bin/sail test
    ```

Sail provides an isolated environment to run your PHPUnit tests with all necessary dependencies.

---

- **Custom Configurations**:
  If additional configurations are needed (e.g., Redis or alternative database backends), update the `docker-compose.yml` provided by Sail, and rebuild the environment:
  ```bash
  ./vendor/bin/sail build --no-cache
  ```

---


## Available Endpoints

| **HTTP Method** | **Endpoint**                    | **Description**                                    |
|------------------|--------------------------------|----------------------------------------------------|
| **GET**          | `/api/v1/tournaments`          | Lists all tournaments with optional filters.       |
| **GET**          | `/api/v1/tournaments/{id}`     | Retrieves details of a specific tournament by ID.  |
| **POST**         | `/api/v1/tournaments/execute`  | Simulates and executes a tournament.               |

---

## API Documentation

### **1. List Tournaments**

- **URL**: `/api/v1/tournaments`
- **Method**: `GET`
- **Description**: Returns a list of all registered tournaments. Filters can be applied optionally.

#### **Optional Query Parameters**:
| **Parameter**   | **Type**   | **Description**                                    |
|------------------|------------|----------------------------------------------------|
| `gender`         | `string`   | Filter tournaments by gender (e.g., `male`, `female`). |
| `from_date`      | `string`   | Filter tournaments from this date (YYYY-MM-DD).      |
| `to_date`        | `string`   | Filter tournaments up to this date (YYYY-MM-DD).     |

#### **Example Successful Response (HTTP 200)**:
```json
{
    "status": "success", 
    "message": "Success",
    "data": [
        {
            "id": 1, 
            "name": "Roland Garros", 
            "type": "male"
        }, 
        {
            "id": 2, 
            "name": "Australian Open", 
            "type": "female"
        }
    ]
}
```

#### **Example Empty Response (HTTP 200)**:
```json
{
    "status": "success",
    "status": "Success",
    "data": []
}
```

---

### **2. Get Tournament Details**

- **URL**: `/api/v1/tournaments/{id}`
- **Method**: `GET`
- **Description**: Returns the details of a specific tournament by its ID.

#### **Path Parameter**:
| **Parameter** | **Type** | **Description**                     |
|---------------|----------|-------------------------------------|
| `id`          | `integer`| The ID of the tournament to retrieve.|

#### **Example Successful Response (HTTP 200)**:
```json
{
    "status": "success", 
    "data": {
        "id": 1, 
        "name": "US Open", 
        "players": [
            {
                "id": 101, 
                "name": "Roger Federer", 
                "skill_level": 90, 
                "gender": "male"
            }, 
            {
                "id": 102, 
                "name": "Rafael Nadal", 
                "skill_level": 85, 
                "gender": "male"
            }
        ]
    }
}
```

#### **Example Not Found Response (HTTP 404)**:
```json
{
    "status": "error", 
    "error": "Tournament not found", 
    "code": 404
}
```
---

### **3. Execute a Tournament**

- **URL**: `/api/v1/tournaments/execute`
- **Method**: `POST`
- **Description**: Simulates a tournament execution based on the players and tournament details provided in the request body.

#### **Input Parameters**:
The request body must include a JSON payload with the following format:

```json
{
    "tournament": {
        "name": "Wimbledon", 
        "type": "male"
    }, 
    "players": [
        {
            "name": "Novak Djokovic", 
            "skill_level": 80, 
            "gender": "male", 
            "strength_level": 70, 
            "speed_level": 60
        }, 
        {
            "name": "Guillermo Coria", 
            "skill_level": 75, 
            "gender": "male", 
            "strength_level": 65, 
            "speed_level": 55
        }
    ]
}
```

#### **Example Successful Response (HTTP 200)**:
```json
{
    "status": "success", 
    "message": "Tournament executed successfully", 
    "data": {
        "id": 1, 
        "name": "Abierto de Buenos Aires", 
        "winner": {
            "id": 2, 
            "name": "Juan Martin Del Potro", 
            "skill_level": 75, 
            "gender": "male", 
            "strength_level": 65, 
            "speed_level": 55, 
            "reaction_time": null, 
            "tournament_id": 1
        }
    }
}
```

#### **Example Error Response (HTTP 400)**:
```json
{
    "status": "error", 
    "error": "The number should be a power of two", 
    "code": 400
}
```

---
