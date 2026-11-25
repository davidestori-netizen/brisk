--
--  "Forgotten password?" (forgotten_password.php, new_password.php):
--  links sent by e-mail (only the sha256 of the code)
--
CREATE TABLE IF NOT EXISTS #PFX#passwd_reset (
       impronta   text PRIMARY KEY,                        -- sha256 of the code of the link
       login      text NOT NULL,
       ip         text,
       creato     timestamp DEFAULT now() NOT NULL,
       usato      timestamp                                -- NULL until the link is used
       );
CREATE INDEX IF NOT EXISTS #PFX#passwd_reset_login ON #PFX#passwd_reset (login, creato);
