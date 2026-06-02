
-- 1. Create Users Table (Lawyers / Administrators)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Create Clients Table
CREATE TABLE clients (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    id_card VARCHAR(20),
    type VARCHAR(30) NOT NULL, -- 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Create Cases Table
CREATE TABLE cases (
    id_case INT AUTO_INCREMENT PRIMARY KEY,
    case_number VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    court VARCHAR(100),
    status VARCHAR(30) DEFAULT 'En cours',
    id_client INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES clients(id_client) ON DELETE CASCADE
);

-- 4. Create Appointments Table
CREATE TABLE appointments (
    id_appointment INT AUTO_INCREMENT PRIMARY KEY,
    appointment_date DATETIME NOT NULL,
    purpose VARCHAR(255) NOT NULL,
    status VARCHAR(30) DEFAULT 'En attente',
    id_client INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES clients(id_client) ON DELETE CASCADE
);

-- 5. Create Documents Table
CREATE TABLE documents (
    id_document INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    id_case INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_case) REFERENCES cases(id_case) ON DELETE CASCADE
);