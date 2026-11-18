--
--  Nickname requested at signup: the player plays at once with a
--  temporary nickname (users.type flag USER_FLAG_TY_NICKTMP, 0x100000)
--  and the requested one waits here for a check in usermgmt.php. A table
--  of its own, one row per account with a request, instead of a column of
--  users: the queries that need it read users LEFT JOIN users_nickreq.
--  The row goes away with its account (ON DELETE CASCADE) and when the
--  nickname is approved.
--
--  A database that ran the first version of this file has the column
--  users.nick_req: move its values here and drop it by hand with
--    INSERT INTO #PFX#users_nickreq (ucode, nick)
--        SELECT code, nick_req FROM #PFX#users WHERE nick_req IS NOT NULL;
--    ALTER TABLE #PFX#users DROP COLUMN nick_req;
--
CREATE TABLE IF NOT EXISTS #PFX#users_nickreq (
       ucode      integer PRIMARY KEY REFERENCES #PFX#users (code) ON DELETE CASCADE,
       nick       text NOT NULL,
       ctime      timestamp DEFAULT now() NOT NULL
       );
CREATE INDEX IF NOT EXISTS #PFX#users_nickreq_nick ON #PFX#users_nickreq (lower(nick));
