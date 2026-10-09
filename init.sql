CREATE DATABASE IF NOT EXISTS api_gatewqay_db;
CREATE DATABASE IF NOT EXISTS admin_db;
CREATE DATABASE IF NOT EXISTS catalog_db;
CREATE DATABASE IF NOT EXISTS notification_db;
CREATE DATABASE IF NOT EXISTS order_db;
CREATE DATABASE IF NOT EXISTS payment_db;

GRANT ALL PRIVILEGES ON api_gatewqay_db.* TO 'shopwise'@'%';
GRANT ALL PRIVILEGES ON admin_db.* TO 'shopwise'@'%';
GRANT ALL PRIVILEGES ON catalog_db.* TO 'shopwise'@'%';
GRANT ALL PRIVILEGES ON notification_db.* TO 'shopwise'@'%';
GRANT ALL PRIVILEGES ON order_db.* TO 'shopwise'@'%';
GRANT ALL PRIVILEGES ON payment_db.* TO 'shopwise'@'%';
