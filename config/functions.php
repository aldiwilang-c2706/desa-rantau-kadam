<?php
function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: '.$url); exit; }
function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function verify_csrf(): void {
    if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'])) {
        http_response_code(419); exit('CSRF token tidak valid.');
    }
}
function flash(): ?array { $x=$_SESSION['flash']??null; unset($_SESSION['flash']); return $x; }
function set_flash(string $type,string $message):void{$_SESSION['flash']=compact('type','message');}
function slugify(string $s):string{
    $s=strtolower(trim($s)); $s=preg_replace('/[^a-z0-9\s-]/','',$s)??'';
    return trim(preg_replace('/[\s-]+/','-',$s)??'','-') ?: 'berita';
}
function unique_slug(string $title,int $exclude=0):string{
    $base=slugify($title); $slug=$base; $i=1;
    while(true){
        $sql='SELECT COUNT(*) FROM berita WHERE slug=?'; $p=[$slug];
        if($exclude){$sql.=' AND id<>?';$p[]=$exclude;}
        $st=db()->prepare($sql);$st->execute($p);
        if(!(int)$st->fetchColumn()) return $slug;
        $slug=$base.'-'.(++$i);
    }
}
function upload_file(array $f,string $type):?string{
    if(($f['error']??UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE)return null;
    if(($f['error']??0)!==UPLOAD_ERR_OK)throw new RuntimeException('Upload gagal.');
    $limit=$type==='image'?MAX_IMAGE_SIZE:MAX_PDF_SIZE;
    if(($f['size']??0)>$limit)throw new RuntimeException('Ukuran file melebihi batas.');
    $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $allowed=$type==='image'?['image/jpeg'=>'jpg','image/png'=>'png']:['application/pdf'=>'pdf'];
    if(!isset($allowed[$mime]))throw new RuntimeException($type==='image'?'Gambar harus JPG/PNG.':'File harus PDF.');
    $folder=$type==='image'?'images':'docs'; $name=bin2hex(random_bytes(16)).'.'.$allowed[$mime];
    $dir=__DIR__.'/../uploads/'.$folder; if(!is_dir($dir))mkdir($dir,0755,true);
    if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name))throw new RuntimeException('File tidak dapat disimpan.');
    return $folder.'/'.$name;
}
function delete_upload(?string $path):void{
    if(!$path)return;
    $base=realpath(__DIR__.'/../uploads');$file=realpath(__DIR__.'/../uploads/'.$path);
    if($base&&$file&&str_starts_with($file,$base)&&is_file($file))@unlink($file);
}
function image_url(?string $path):string{return $path?BASE_URL.'/uploads/'.e($path):BASE_URL.'/assets/img-placeholder.svg';}
function log_activity(string $text):void{
    $u=$_SESSION['admin_user']['id']??null;
    $st=db()->prepare('INSERT INTO activity_logs(user_id,activity) VALUES(?,?)');$st->execute([$u,$text]);
}
