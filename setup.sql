
CREATE TABLE IF NOT EXISTS users (
    id       SERIAL PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role     VARCHAR(10)  NOT NULL DEFAULT 'judge' CHECK (role IN ('judge', 'admin'))
);

CREATE TABLE IF NOT EXISTS scores (
    id             SERIAL PRIMARY KEY,
    judge_id       INT NOT NULL REFERENCES users(id),
    group_number   VARCHAR(50)  NOT NULL DEFAULT '1',
    group_members  VARCHAR(255) NOT NULL,
    project_title  VARCHAR(255) NOT NULL,
    crit1_dev      SMALLINT NULL CHECK (crit1_dev BETWEEN 0 AND 10),
    crit1_acc      SMALLINT NULL CHECK (crit1_acc BETWEEN 11 AND 15),
    crit2_dev      SMALLINT NULL CHECK (crit2_dev BETWEEN 0 AND 10),
    crit2_acc      SMALLINT NULL CHECK (crit2_acc BETWEEN 11 AND 15),
    crit3_dev      SMALLINT NULL CHECK (crit3_dev BETWEEN 0 AND 10),
    crit3_acc      SMALLINT NULL CHECK (crit3_acc BETWEEN 11 AND 15),
    crit4_dev      SMALLINT NULL CHECK (crit4_dev BETWEEN 0 AND 10),
    crit4_acc      SMALLINT NULL CHECK (crit4_acc BETWEEN 11 AND 15),
    total          SMALLINT NOT NULL DEFAULT 0,
    comments       TEXT NULL,
    submitted_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, role) VALUES
('judge1', 'placeholder', 'judge'),
('judge2', 'placeholder', 'judge'),
('judge3', 'placeholder', 'judge'),
('judge4', 'placeholder', 'judge'),
('admin',  'placeholder', 'admin')
ON CONFLICT (username) DO NOTHING;
