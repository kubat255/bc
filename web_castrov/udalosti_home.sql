CREATE TABLE udalosti_home (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  image VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);