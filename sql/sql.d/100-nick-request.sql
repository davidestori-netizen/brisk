--
--  Nickname requested at signup: the player plays at once with a
--  temporary nickname and the requested one waits here for a check in
--  usermgmt.php. An account has the temporary nickname while it has a row
--  here: USER_FLAG_TY_NICKTMP (0x1000000) is not stored in users.type, the
--  code sets it when it reads the row (BriskDB::nicktmp_fix()). A table
--  of its own, one row per account with a request, instead of a column of
--  users: the queries that need it read users LEFT JOIN users_nickreq.
--  The row goes away with its account (ON DELETE CASCADE) and when the
--  nickname is approved.
--
--  A database that ran the first version of this file has the column
--  users.nick_req, and the temporary nickname stored as 0x100000 in
--  users.type, the bit now kept for the moderators: move the values here,
--  drop the column and clear the bit by hand, before any moderator is set,
--  with
--    INSERT INTO #PFX#users_nickreq (ucode, nick)
--        SELECT code, nick_req FROM #PFX#users WHERE nick_req IS NOT NULL;
--    ALTER TABLE #PFX#users DROP COLUMN nick_req;
--    UPDATE #PFX#users SET type = type & ~(CAST (X'00100000' as integer));
--
CREATE TABLE IF NOT EXISTS #PFX#users_nickreq (
       ucode      integer PRIMARY KEY REFERENCES #PFX#users (code) ON DELETE CASCADE,
       nick       text NOT NULL,
       ctime      timestamp DEFAULT now() NOT NULL
       );
CREATE INDEX IF NOT EXISTS #PFX#users_nickreq_nick ON #PFX#users_nickreq (lower(nick));
