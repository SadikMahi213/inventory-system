# Inventory Management ERP System - API Documentation

## Overview

This document provides detailed information about the RESTful API endpoints available in the Inventory Management ERP System. All API endpoints are prefixed with `/api/` and require authentication via API tokens.

## Authentication

Most API endpoints require authentication. To authenticate, include the `Authorization` header with a Bearer token:

```
Authorization: Bearer YOUR_API_TOKEN
```

To obtain an API token, users must log in through the web interface and generate a token in their profile settings.

## Base URL

All API endpoints are relative to the base URL:

```
https://your-domain.com/api/
```

## Response Format

All API responses are returned in JSON format with the following structure:

```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": {}
}
```

In case of errors:

```json
{
  "success": false,
  "message": "Error description",
  "errors": []
}
```

## Rate Limiting

API requests are rate-limited to prevent abuse. The default limit is 60 requests per minute per IP address.

## Endpoints

### Authentication

#### POST `/auth/login`

Authenticate a user and obtain an API token.

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "API_TOKEN",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com"
    }
  }
}
```

#### POST `/auth/logout`

Logout the authenticated user.

**Headers:**
- Authorization: Bearer YOUR_API_TOKEN

**Response:**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### Products

#### GET `/products`

Retrieve a paginated list of products.

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search term to filter products

**Response:**
```json
{
  "success": true,
  "data": {
    "products": [
      {
        "id": 1,
        "product_code": "PRD-ABC123",
        "name": "Sample Product",
        "model": "Model X",
        "size": "Large",
        "color": "Red",
        "quality": "Premium",
        "unit": "pcs",
        "unit_price": 25.99,
        "selling_price": 35.99,
        "description": "Product description",
        "is_featured": false,
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 10,
      "total": 50
    }
  }
}
```

#### GET `/products/{id}`

Retrieve a specific product by ID.

**Response:**
```json
{
  "success": true,
  "data": {
    "product": {
      "id": 1,
      "product_code": "PRD-ABC123",
      "name": "Sample Product",
      "model": "Model X",
      "size": "Large",
      "color": "Red",
      "quality": "Premium",
      "unit": "pcs",
      "unit_price": 25.99,
      "selling_price": 35.99,
      "description": "Product description",
      "is_featured": false,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
  }
}
```

#### POST `/products`

Create a new product.

**Request Body:**
```json
{
  "name": "New Product",
  "model": "Model Y",
  "size": "Medium",
  "color": "Blue",
  "quality": "Standard",
  "unit": "pcs",
  "unit_price": 19.99,
  "selling_price": 29.99,
  "description": "New product description",
  "is_featured": false
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "product": {
      "id": 2,
      "product_code": "PRD-XYZ789",
      "name": "New Product",
      "model": "Model Y",
      "size": "Medium",
      "color": "Blue",
      "quality": "Standard",
      "unit": "pcs",
      "unit_price": 19.99,
      "selling_price": 29.99,
      "description": "New product description",
      "is_featured": false,
      "created_at": "2023-01-02T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
}
```

#### PUT/PATCH `/products/{id}`

Update an existing product.

**Request Body:**
```json
{
  "name": "Updated Product Name",
  "unit_price": 22.99
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "product": {
      "id": 1,
      "product_code": "PRD-ABC123",
      "name": "Updated Product Name",
      "model": "Model X",
      "size": "Large",
      "color": "Red",
      "quality": "Premium",
      "unit": "pcs",
      "unit_price": 22.99,
      "selling_price": 35.99,
      "description": "Product description",
      "is_featured": false,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
}
```

#### DELETE `/products/{id}`

Delete a product.

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

### Purchase Records

#### GET `/purchase-records`

Retrieve a paginated list of purchase records.

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search term to filter records

**Response:**
```json
{
  "success": true,
  "data": {
    "purchase_records": [
      {
        "id": 1,
        "date": "2023-01-01",
        "product_id": 1,
        "product_name": "Sample Product",
        "model": "Model X",
        "size": "Large",
        "color": "Red",
        "quality": "Premium",
        "quantity": 100,
        "unit": "pcs",
        "unit_price": 25.99,
        "total_price": 2599.00,
        "supplier_id": 1,
        "supplier_name": "Sample Supplier",
        "payment_status": "paid",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 3,
      "per_page": 10,
      "total": 30
    }
  }
}
```

#### POST `/purchase-records`

Create a new purchase record.

**Request Body:**
```json
{
  "date": "2023-01-02",
  "product_id": 1,
  "quantity": 50,
  "unit_price": 24.99,
  "supplier_id": 1,
  "payment_status": "pending"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Purchase record created successfully",
  "data": {
    "purchase_record": {
      "id": 2,
      "date": "2023-01-02",
      "product_id": 1,
      "product_name": "Sample Product",
      "model": "Model X",
      "size": "Large",
      "color": "Red",
      "quality": "Premium",
      "quantity": 50,
      "unit": "pcs",
      "unit_price": 24.99,
      "total_price": 1249.50,
      "supplier_id": 1,
      "supplier_name": "Sample Supplier",
      "payment_status": "pending",
      "created_at": "2023-01-02T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
}
```

### Sales Records

#### GET `/sales-records`

Retrieve a paginated list of sales records.

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search term to filter records

**Response:**
```json
{
  "success": true,
  "data": {
    "sales_records": [
      {
        "id": 1,
        "invoice_no": "INV-ABC123XYZ",
        "customer_id": 1,
        "customer_name": "Sample Customer",
        "product_id": 1,
        "product_name": "Sample Product",
        "price": 35.99,
        "quantity": 5,
        "total_amount": 179.95,
        "payment_status": "paid",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 2,
      "per_page": 10,
      "total": 20
    }
  }
}
```

#### POST `/sales-records`

Create a new sales record.

**Request Body:**
```json
{
  "customer_id": 1,
  "product_id": 1,
  "price": 35.99,
  "quantity": 3,
  "payment_status": "pending"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Sales record created successfully",
  "data": {
    "sales_record": {
      "id": 2,
      "invoice_no": "INV-DEF456UVW",
      "customer_id": 1,
      "customer_name": "Sample Customer",
      "product_id": 1,
      "product_name": "Sample Product",
      "price": 35.99,
      "quantity": 3,
      "total_amount": 107.97,
      "payment_status": "pending",
      "created_at": "2023-01-02T00:00:00.000000Z",
      "updated_at": "2023-01-02T00:00:00.000000Z"
    }
  }
}
```

### Stock

#### GET `/stocks`

Retrieve a paginated list of stock records.

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search term to filter stocks

**Response:**
```json
{
  "success": true,
  "data": {
    "stocks": [
      {
        "id": 1,
        "product_id": 1,
        "product_name": "Sample Product",
        "product_code": "PRD-ABC123",
        "current_stock": 95,
        "last_updated": "2023-01-02T00:00:00.000000Z",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-02T00:00:00.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 5
    }
  }
}
```

### Profit & Loss

#### GET `/profit-loss`

Retrieve a paginated list of profit & loss records.

**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Number of items per page (default: 10)
- `search` (optional): Search term to filter records

**Response:**
```json
{
  "success": true,
  "data": {
    "profit_loss_records": [
      {
        "id": 1,
        "product_id": 1,
        "product_name": "Sample Product",
        "revenue": 179.95,
        "cogs": 129.95,
        "staff_cost": 10.00,
        "shop_cost": 5.00,
        "transport_cost": 3.00,
        "other_expense": 2.00,
        "total_expenses": 20.00,
        "net_profit": 30.00,
        "report_date": "2023-01-01",
        "created_at": "2023-01-01T00:00:00.000000Z",
        "updated_at": "2023-01-01T00:00:00.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 10,
      "total": 5
    }
  }
}
```

### Dashboard

#### GET `/dashboard/stats`

Retrieve dashboard statistics.

**Response:**
```json
{
  "success": true,
  "data": {
    "stats": {
      "total_products": 25,
      "total_purchases": 150,
      "total_sales": 120,
      "total_stock": 1250,
      "today_sales": 2500.00,
      "monthly_revenue": 15000.00,
      "net_profit": 3500.00
    }
  }
}
```

#### GET `/dashboard/charts`

Retrieve chart data for the dashboard.

**Response:**
```json
{
  "success": true,
  "data": {
    "sales_chart": {
      "labels": ["Jan", "Feb", "Mar", "Apr", "May"],
      "data": [5000, 7500, 6200, 8100, 9300]
    },
    "profit_chart": {
      "labels": ["Jan", "Feb", "Mar", "Apr", "May"],
      "data": [1200, 1800, 1500, 2100, 2400]
    }
  }
}
```

## Error Codes

The API uses standard HTTP status codes:

- `200 OK` - Successful request
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request data
- `401 Unauthorized` - Authentication required
- `403 Forbidden` - Access denied
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors
- `500 Internal Server Error` - Server error

## Webhooks

The system supports webhooks for real-time notifications. To configure webhooks, visit the admin panel and set up webhook URLs for various events such as:

- New purchase record created
- New sales record created
- Stock level changes
- Profit/loss updates

Webhook payloads will be sent as POST requests with JSON data containing event details.

## Support

For API support, please contact the development team or refer to the main documentation.