# foodiehub
FoodieHub is a full-stack web-based food ordering and management system that allows users to browse a menu, place food orders, and for administrators to manage food items and order statuses. It uses HTML/CSS/JS for the frontend and PHP/MySQL for backend operations.

Frontend (Customer Side)
Files: index.html, menu.html, cart.html, order_confirmation.html, cart.js, style.css

index.html: Homepage or landing page for users to access the food menu.

menu.html: Displays the list of food items dynamically fetched via get_menu.php.

cart.html: Shows the items added to the cart by the user using JavaScript (cart.js).

order_confirmation.html: Shows order success/failure and details after placing an order.

cart.js: Handles cart operations such as adding/removing items, calculating totals, and sending the order to the backend (place_order.php).

🔧 Backend API (PHP)
Files: api/get_menu.php, api/place_order.php, db/db.php

db/db.php: Handles the database connection to a MySQL server.

get_menu.php: Fetches menu items from the database and returns them in JSON format.

place_order.php: Accepts order data via POST request and inserts it into the database.

🔐 Admin Panel (Admin Side)
Files in admin/ folder:

index.php & login.php/logout.php: Login interface and session handling for the admin.

manage_food.php: Displays existing food items and provides options to edit/delete.

add_food.php / edit_food.php / delete_food.php: CRUD operations for food items.

view_orders.php: Displays orders placed by customers.

update_order_status.php: Allows admin to update status (e.g., "Preparing", "Delivered").

export_order_json.php: Exports orders in JSON format (possibly for analysis or backup).

fetch_order_statuses.php: Retrieves current order statuses via AJAX.



orders table (for storing customer orders)

Possibly order_items, admin_users or similar

🧩 Features Summary
Feature	Description
Menu Display	Dynamic menu display using API
Cart System	Add/remove/view items via JavaScript
Order Placement	Sends order details to backend
Order Confirmation	Displays order summary
Admin Login	Secured access to admin panel
Food Management	Add/edit/delete food items
Order Management	Track/update orders
Export	Export order data as JSON

