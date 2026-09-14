<?php
require_once __DIR__.'/database.php';
require_once __DIR__.'/functions.php';
function current_user():?array{return $_SESSION['admin_user']??null;}
function login_user(array $u):void{session_regenerate_id(true);$_SESSION['admin_user']=['id'=>(int)$u['id'],'username'=>$u['username'],'nama_lengkap'=>$u['nama_lengkap'],'role'=>$u['role']];}
function require_login():void{if(!current_user())redirect(BASE_URL.'/login.php');}
function require_admin():void{require_login();if((current_user()['role']??'')!=='admin'){http_response_code(403);exit('403 - Khusus admin.');}}
