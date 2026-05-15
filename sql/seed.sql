USE ecommerce_store;

INSERT INTO users (name, email, password_hash, phone, role, is_active) VALUES
('Delivery Manager', 'dm@sporshow.com', '$2y$12$Y1Mq0rjyjcy2.aBwXjklOOvAWaqIwhtBTv.kdL8.jRcaw2Crvh42S', '01712345678', 'delivery_manager', 1);

INSERT INTO users (name, email, password_hash, phone, role, is_active) VALUES
('Rahim Uddin', 'rahim@test.com', '$2y$12$Y1Mq0rjyjcy2.aBwXjklOOvAWaqIwhtBTv.kdL8.jRcaw2Crvh42S', '01777777777', 'customer', 1),
('Fatema Akter', 'fatema@test.com', '$2y$12$Y1Mq0rjyjcy2.aBwXjklOOvAWaqIwhtBTv.kdL8.jRcaw2Crvh42S', '01888888888', 'customer', 1);

INSERT INTO users (name, email, password_hash, phone, role, is_active) VALUES
('Kamal Hossain', 'kamal@test.com', '$2y$12$Y1Mq0rjyjcy2.aBwXjklOOvAWaqIwhtBTv.kdL8.jRcaw2Crvh42S', '01999999999', 'seller', 1);

INSERT INTO sellers (user_id, shop_name, shop_description, address, is_approved) VALUES
(4, 'Dhaka Electronics', 'Quality electronics shop in Dhaka', '25 Gulshan Avenue, Dhaka 1212', 1);

INSERT INTO categories (name, description) VALUES ('Electronics', 'Electronic items');

INSERT INTO products (seller_id, category_id, name, description, price, stock_qty, is_available) VALUES
(1, 1, 'Wireless Mouse', 'A nice wireless mouse', 1500.00, 50, 1),
(1, 1, 'USB Keyboard', 'Mechanical keyboard', 2500.00, 30, 1),
(1, 1, 'Monitor Stand', 'Adjustable monitor stand', 1800.00, 20, 1);

INSERT INTO delivery_zones (zone_name, delivery_fee, estimated_days) VALUES
('Dhaka City', 60.00, 1),
('Gazipur', 100.00, 1),
('Narayanganj', 100.00, 1),
('Chattogram', 150.00, 2),
('Sylhet', 180.00, 3);

INSERT INTO orders (customer_id, shipping_address, payment_method, subtotal, discount_amount, total_amount, status) VALUES
(2, '45 Dhanmondi Road 27, Dhaka 1209', 'Cash on Delivery', 4000.00, 0, 4000.00, 'shipped'),
(3, '12 Agrabad Commercial Area, Chattogram 4100', 'Card', 2500.00, 0, 2500.00, 'shipped'),
(2, '78 Banani Road 11, Dhaka 1213', 'Cash on Delivery', 1800.00, 0, 1800.00, 'shipped'),
(3, '5 Zindabazar, Sylhet 3100', 'Card', 1500.00, 0, 1500.00, 'confirmed'),
(2, '10 Uttara Sector 7, Dhaka 1230', 'Cash on Delivery', 4300.00, 0, 4300.00, 'delivered');

INSERT INTO order_items (order_id, product_id, seller_id, quantity, unit_price, item_status) VALUES
(1, 1, 1, 1, 1500.00, 'shipped'),
(1, 2, 1, 1, 2500.00, 'shipped'),
(2, 2, 1, 1, 2500.00, 'shipped'),
(3, 3, 1, 1, 1800.00, 'shipped'),
(4, 1, 1, 1, 1500.00, 'confirmed'),
(5, 2, 1, 1, 2500.00, 'delivered'),
(5, 3, 1, 1, 1800.00, 'delivered');

INSERT INTO delivery_agents (name, vehicle_type, phone, is_active) VALUES
('Arif Hossain', 'Motorcycle', '01611111111', 1),
('Sumon Rahman', 'Van', '01622222222', 1),
('Jahid Hasan', 'Motorcycle', '01633333333', 0);

INSERT INTO delivery_assignments (order_id, agent_id, status, delivery_zone, delivered_at) VALUES
(5, 1, 'delivered', 1, '2026-05-16 14:30:00');
