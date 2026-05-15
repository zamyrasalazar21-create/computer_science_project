<?php
require 'db.php';

$pdo->exec("
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL DEFAULT 'judge',
    full_name VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS grades (
    id SERIAL PRIMARY KEY,
    judge_id INT NOT NULL REFERENCES users(id),
    group_members VARCHAR(255) NOT NULL,
    group_number VARCHAR(50) NOT NULL,
    project_title VARCHAR(255) NOT NULL,
    articulate_developing SMALLINT,
    articulate_accomplished SMALLINT,
    tools_developing SMALLINT,
    tools_accomplished SMALLINT,
    presentation_developing SMALLINT,
    presentation_accomplished SMALLINT,
    teamwork_developing SMALLINT,
    teamwork_accomplished SMALLINT,
    total SMALLINT NOT NULL DEFAULT 0,
    comments TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, role, full_name) VALUES
('judge1', 'placeholder', 'judge', 'Judge One'),
('judge2', 'placeholder', 'judge', 'Judge Two'),
('judge3', 'placeholder', 'judge', 'Judge Three'),
('judge4', 'placeholder', 'judge', 'Judge Four'),
('admin', 'placeholder', 'admin', 'Administrator')
ON CONFLICT (username) DO NOTHING;
");

echo 'Tables created! Now visit /seed_passwords.php';
?>