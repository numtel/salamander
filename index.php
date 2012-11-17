<?/*
node social program 20110503
Filename:		index.php
Description:	main page

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$time_start = microtime(true);
require_once('node.php');

$node=new Node();
//$node->user_user->login('ben2','numwtel');
echo $node->render_haml->render();

$time_end = microtime(true);
$time = $time_end - $time_start;

//echo "Did nothing in $time seconds\n";
?>
