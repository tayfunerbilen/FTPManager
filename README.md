# FTPManager
Manage FTP Easily

```
try {
  $ftp = new FTPManager([
      'host' => 'IP_ADRESİ',
      'username' => 'USER_NAME',
      'password' => 'PASSWORD'
  ]);
  
  $ftp->setDirectory('./public_html');
  
  // dizin listesi için
  $ftp->getDirectory();
  
  // klasör ya da dosyayı yeniden adlandırma
  $ftp->rename('index.php', 'yeni.php');
  
  // dosya silmek için
  $ftp->delete('yeni.php');
  
  // dizin oluşturmak için
  $ftp->makeDir('klasoradi');
  
  // dizin silmek için
  $ftp->removeDir('klasoradi');
  
  // dosya yüklemek için
  $ftp->upload('localdosya.php', 'remotedosya.php');
  
  // dosya indirmek içinü
  $ftp->download('remotedosya.php', 'localdosya.php');
  
  // dosyayı okumak için
  $ftp->read('remotedosya.php');
} catch (FTPException $e){
    echo $e->getMessage();
}
```
