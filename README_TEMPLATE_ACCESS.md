# Template Download Access Guide

## Issue Explanation

Users may encounter a "404 Not Found" error when trying to access the Download Template functionality for Products or Purchase Records. This happens because these routes are protected by authentication for security reasons.

## Protected Routes

The following routes require authentication:

1. **Products Template Download**: `/products/download-template`
2. **Purchase Records Template Download**: `/purchase-records/download-template`

## Solution

To access these templates, you must be logged in to the system:

### Step 1: Navigate to Login
Go to the login page: `/login`

### Step 2: Authenticate
Enter your credentials to log in to the admin panel.

### Step 3: Access Templates
After logging in, you can access the templates through:

1. **Products Template**:
   - Navigate to Products section
   - Click on "Import Products" 
   - Click "Download Template" button

2. **Purchase Records Template**:
   - Navigate to Purchase Records section
   - Click on "Import Purchase Records"
   - Click "Download Template" button

## Alternative Direct Access

You can also access the templates directly after login:

- Products Template: `[BASE_URL]/products/download-template`
- Purchase Records Template: `[BASE_URL]/purchase-records/download-template`

## Security Note

These routes are intentionally protected to ensure that only authorized users can access the system's import/export functionality. This prevents unauthorized data manipulation.

## Troubleshooting

If you continue to experience issues:

1. Ensure you are logged in
2. Check that you have the necessary permissions
3. Clear your browser cache and cookies
4. Contact your system administrator if problems persist