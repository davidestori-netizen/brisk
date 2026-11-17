<?php
/*
 *  brisk - singlemsg.php
 *
 *  Copyright (C) 2014      Matteo Nastasi
 *                          mailto: nastasi@alternativeoutput.it
 *                                  matteo.nastasi@milug.org
 *                          web: http://www.alternativeoutput.it
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 */

$G_base = "";

require_once("Obj/brisk.phh");
require_once("Obj/user.phh");
require_once("Obj/auth.phh");
require_once("Obj/dbase_{$G_dbasetype}.phh");
require_once("Obj/singlemsg.phh");


singlemsg("Ci siamo title", "Ci siamo fun");

?>
