<?php

class FTPException extends Exception {}

class FTPManager {

    public $conn_id;
    public $mode = FTP_BINARY;

    /**
     * FTPManager constructor.
     * @param $config
     * @throws FTPException
     */
    public function __construct($config)
    {
        $this->conn_id = ftp_connect($config['host']);
        if (!$this->conn_id){
            throw new FTPException($this->error());
        }
        $login = ftp_login($this->conn_id, $config['username'], $config['password']);
        if (!$login){
            throw new FTPException($this->error());
        }
    }

    /**
     * @param $directory
     */
    public function setDirectory($directory)
    {
        ftp_chdir($this->conn_id, $directory);
    }

    /**
     * @param string $directory
     * @return array
     */
    public function getDirectory($directory = '.')
    {
        $files = ftp_nlist($this->conn_id, $directory);
        return $files;
    }

    /**
     * @param $oldName
     * @param $newName
     * @return bool
     * @throws FTPException
     */
    public function rename($oldName, $newName)
    {
        if (!ftp_rename($this->conn_id, $oldName, $newName)){
            throw new FTPException($this->error());
        }
        return true;
    }

    /**
     * @param $file
     * @return bool
     * @throws FTPException
     */
    public function delete($file)
    {
        if (!ftp_delete($this->conn_id, $file)){
            throw new FTPException($this->error());
        }
        return true;
    }

    /**
     * @param $dirName
     * @return bool
     * @throws FTPException
     */
    public function makeDir($dirName)
    {
        $result = ftp_mkdir($this->conn_id, $dirName);
        if (!$result){
            throw new FTPException($this->error());
        }
        return $result;
    }

    /**
     * @param $dirName
     * @return bool
     * @throws FTPException
     */
    public function removeDir($dirName)
    {
        if (!ftp_rmdir($this->conn_id, $dirName)){
            throw new FTPException($this->error());
        }
        return true;
    }

    /**
     * @param $local
     * @param $remote
     * @return bool
     * @throws FTPException
     */
    public function upload($local, $remote)
    {
        if (!ftp_put($this->conn_id, $remote, $local, $this->mode)){
            throw new FTPException($this->error());
        }
        return true;
    }

    /**
     * @param $remote
     * @param null $local
     * @return bool
     * @throws FTPException
     */
    public function download($remote, $local)
    {
        if (!ftp_get($this->conn_id, $local, $remote, $this->mode)){
            throw new FTPException($this->error());
        }
        return true;
    }

    /**
     * @param $remote
     * @return false|string
     */
    public function read($remote)
    {
        ob_start();
        ftp_get($this->conn_id, 'php://output', $remote, $this->mode);
        $output = ob_get_clean();
        return $output;
    }

    /**
     * @return mixed
     */
    private function error()
    {
        $error = error_get_last();
        return $error['message'];
    }

}
