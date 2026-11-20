<?php
/*
 *  brisk - nickreq.php
 *
 *  Copyright (C) 2026      Davide Stori
 *                          mailto: davidestori@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABLILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details. You should have received a
 * copy of the GNU General Public License along with this program; if
 * not, write to the Free Software Foundation, Inc, 59 Temple Place -
 * Suite 330, Boston, MA 02111-1307, USA.
 *
 */

/*
 *  A player that still plays with a temporary nickname (USER_FLAG_TY_NICKTMP)
 *  asks for another nickname, i.e. after the first one has been refused:
 *  it becomes his login, and is checked by hand in usermgmt.php like the
 *  first one; the others keep seeing the temporary nickname until then.
 */

foreach (array("HTTP_HOST", "DOCUMENT_ROOT") as $i) {
    if (isset($_SERVER[$i])) {
        $$i = $_SERVER[$i];
        }
    }

$G_base = "";

require_once($G_base."Obj/brisk.phh");
require_once($G_base."Obj/user.phh");
require_once($G_base."Obj/auth.phh");
require_once($G_base."Obj/dbase_{$G_dbasetype}.phh");
require_once($G_base."Obj/signup.phh");

require_once($G_base."spush/brisk-spush.phh");

function nickreq_page($msg, $is_error, $new_nick)
{
    header('Content-Type: text/html; charset=UTF-8');
?><!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Brisk: scegli un altro nickname</title>
<?php isc_style(); ?>
</head>
<body>
<div class="box">
  <div class="logo"><img src="img/brisk_logo64.png" alt="BRISK"></div>
<?php if ($new_nick != "") { ?>
  <h1>Nickname nuovo inviato</h1>
  <div class="ok"><?php echo $msg; ?></div>
  <div class="entra">
    <b>Per entrare</b> userai sempre il nickname <b><?php echo eschtml($new_nick); ?></b> e la tua password.
  </div>
  <a class="btn blu" href="index.php?n=<?php echo rawurlencode($new_nick); ?>">Entra a giocare</a>
<?php } else { ?>
  <h1>Il tuo nickname è stato rifiutato</h1>
<?php if ($msg != "") { ?>
  <div class="<?php echo ($is_error ? 'err' : 'ok'); ?>"><?php echo $msg; ?></div>
<?php } ?>
  <p>I moderatori non hanno approvato il nickname che avevi scelto. Scegline un altro: da subito entrerai con quello nuovo.
     Gli altri giocatori, per ora, continueranno a vederti con il nome con l'asterisco.</p>
  <form method="POST" action="nickreq.php" accept-charset="utf-8">
    <label for="f_login">Il tuo nickname attuale (quello rifiutato)</label>
    <input id="f_login" name="f_login" type="text" maxlength="12" autocapitalize="none" autocorrect="off" spellcheck="false">
    <label for="f_pass">Password</label>
    <input id="f_pass" name="f_pass" type="password" maxlength="64">
    <label for="f_nick">Nickname nuovo</label>
    <input id="f_nick" name="f_nick" type="text" maxlength="12" autocapitalize="none" autocorrect="off" spellcheck="false">
    <button type="submit" class="blu">Invia</button>
  </form>
  <a class="dopo" href="index.php">Torna all'ingresso</a>
<?php } ?>
</div>
</body>
</html>
<?php
}

function main()
{
    $msg = "";
    $is_error = TRUE;
    $new_nick = "";

    do {
        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST')
            break;

        $login = (isset($_POST['f_login']) ? trim((string)$_POST['f_login']) : "");
        $pass  = (isset($_POST['f_pass'])  ? (string)$_POST['f_pass'] : "");
        $nick  = (isset($_POST['f_nick'])  ? isc_lower(trim((string)$_POST['f_nick'])) : "");

        if (($bdb = BriskDB::create()) == FALSE) {
            $msg = "Connessione al database fallita, riprova più tardi.";
            break;
        }

        if ($login == "" || ($usr = $bdb->getrecord_bylogin($login)) == FALSE
            || strcmp($usr->pass, md5($pass)) != 0
            || ($usr->type & USER_FLAG_TY_NICKTMP) != USER_FLAG_TY_NICKTMP) {
            $msg = "Nome o password sbagliati.";
            break;
        }

        /* the same rules of the signup page (signup.php) */
        $esito = isc_nick_check($bdb, $nick);
        if ($esito[0] != 'ok') {
            $msg = eschtml($esito[1] . ($esito[2] != "" ? " Prova: " . $esito[2] : ""));
            break;
        }

        if ($bdb->user_login_change($usr->code, $nick) == FALSE) {
            $msg = "È occorso un errore, riprova più tardi.";
            break;
        }

        $msg = sprintf("Richiesta inviata: da adesso entri con '%s'. Il nome verrà controllato al più presto.", eschtml($nick));
        $is_error = FALSE;
        $new_nick = $nick;
    } while (FALSE);

    nickreq_page($msg, $is_error, $new_nick);
}

main();

?>
