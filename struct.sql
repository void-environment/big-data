CREATE TABLE visit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(255),
    ip VARCHAR(45),
    user_agent TEXT,
    browser VARCHAR(100),
    device VARCHAR(100),
    platform VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_id INT,
    email TEXT,
    phone TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (visit_id) REFERENCES visit (id)
);
