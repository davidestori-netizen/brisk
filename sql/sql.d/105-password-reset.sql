--
--  "Forgotten password?" (forgotten_password.php, new_password.php):
--  links sent by e-mail (only the sha256 of the code) and copy of the old passwords
--
CREATE TABLE IF NOT EXISTS #PFX#passwd_reset (
       impronta   text PRIMARY KEY,                        -- sha256 of the code of the link
       login      text NOT NULL,
       ip         text,
       creato     timestamp DEFAULT now() NOT NULL,
       usato      timestamp                                -- NULL until the link is used
       );
CREATE INDEX IF NOT EXISTS #PFX#passwd_reset_login ON #PFX#passwd_reset (login, creato);

CREATE TABLE IF NOT EXISTS #PFX#users_passwd_backup (
       ts         timestamp DEFAULT now() NOT NULL,
       login      text,
       code       integer,
       old_pass   text,
       ip         text
       );
