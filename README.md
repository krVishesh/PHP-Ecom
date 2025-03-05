# PHP-Ecom

PHP-Ecom is a simple e-commerce web application built with PHP and MySQL. It includes user registration, login, shopping cart functionality, checkout, and order placement.

## Features

- **User Authentication**: Secure registration and login with hashed passwords.
- **Product Listing**: View products with details and prices.
- **Shopping Cart**: Add and remove products, with cart summarization.
- **Checkout Process**: Place orders and view order summaries.
- **Responsive Design**: Styled with custom CSS for various pages (login, homepage, checkout, and cart).

## Installation

1. **Clone Repository**
    ```
    git clone https://github.com/your-username/PHP-Ecom.git
    ```

2. **Database Setup**
    - Import the project and update MySQL credentials in `db.php`.
    - Run the application; the `db_init.php` will create and populate the database if it doesn't exist.

3. **Web Server**
    - Set up a local web server (e.g., XAMPP, WAMP) and point the document root to the project folder.

## Usage

1. Open the application in your browser.
2. Register a new account or login with a previously registered user.
3. Browse products on the homepage and add items to your cart.
4. View and manage your cart, then proceed to checkout.
5. Place an order and be redirected to the homepage upon success.

## File Structure

- **styles/**: CSS files for different pages.
- **db.php** & **db_init.php**: Database connection and initialization scripts.
- **register.php, login.php, logout.php**: User authentication.
- **homepage.php**: Product listing and cart management.
- **cart.php**: Shopping cart interface.
- **checkout.php**: Order processing.
- **README.md**: Project documentation.

Happy coding!
