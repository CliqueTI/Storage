<?php

namespace CliqueTI\Storage\Helpers;

use Exception;

/**
 * HELPER DO ADAPTADOR LOCAL
 * LOCAL ADAPTER HELPER
 */
trait LocalHelper {

    use StorageHelper;

    /**
     * ANALISA O ARQUIVO EM BUSCA DE ERROS
     * ANALYZES THE FILE IN SEARCH OF ERRORS
     * @param array $file
     * @return void
     * @throws Exception
     */
    public function parseFile(array $file) {
        $this->hasError($file);
        $this->allowedType($file);
    }

    /**
     * VERIFICA SE O DIRETORIO ESTA CRIADO
     * VERIFY IF THE DIRECTORY IS CREATED
     * @param string|null $folder
     * @return void
     */
    public function parseFolder(?string $folder) {
        if(!is_dir($this->resolvePath($folder))){
            mkdir($this->resolvePath($folder), 0775, TRUE);
        }
    }

    /**
     * SALVA O ARQUIVO NO ENDEREÇO ESPECIFICADO E RETORNA O NOME COM CAMINHO SEM O ROOT
     * SAVES THE FILE AT THE SPECIFIED ADDRESS AND RETURNS THE NAME WITH PATH WITHOUT ROOT
     * @param array $file
     * @param string $name
     * @param string|null $folder
     * @return string
     * @throws Exception
     */
    public function putFileAs(array $file, string $name, ?string $folder) {

        $path = $this->resolvePath($folder);
        $name = $this->resolveName($file,$name);

        if(!move_uploaded_file($file['tmp_name'],"{$path}/{$name}")){
            throw new Exception('Falha ao salvar o arquivo');
        }

        return rtrim($folder,'/')."/{$name}";

    }



    /**
     * VERIFICA SE HOUVE ERROR NO UPLOAD
     * CHECK IF THERE WAS A UPLOAD ERROR
     * @throws Exception
     */
    private function hasError(array $file) {

        $errorTypes = [
            '1' => "O arquivo excede o tamanho permitido no servidor (upload_max_filesize).",
            '2' => "O arquivo excede o tamanho definido no form (MAX_FILE_SIZE).",
            '3' => "O upload do arquivo foi feito parcialmente.",
            '4' => "Nenhum arquivo foi enviado.",
            '6' => "Pasta temporária ausênte (Erro no PHP)",
            '7' => "Falha ao escrever o arquivo em disco (Permissão de Pasta).",
            '8' => "Uma extensão do PHP interrompeu o upload do arquivo (consulte phpinfo())."
        ];

        if(!empty($file['error'])){
            throw new Exception($errorTypes[$file['error']]);
        }

    }

    /**
     * RETORNA A EXTENSÃO DO ARQUICO ENVIADO
     * RETURNS THE EXTENSION OF THE SENT FILE
     * @param array $file
     * @return false|mixed|string
     */
    private function getExtension(array $file) {
        $arrName = explode('.',$file['name']);
        return (end($arrName));
    }

    /**
     * RETORNA O NOME COM A EXTENSÃO DO ARQUIVO
     * RETURN THE NAME WITH THE FILE EXTENSION
     * @param array $file
     * @param string $name
     * @return string
     */
    private function resolveName(array $file, string $name) {
        return $name.".".$this->getExtension($file);
    }

    /**
     * RETORNA O CAMINHO COMPLETO
     * RETURNS THE FULL PATH
     * @param string|null $folder
     * @return string
     */
    private function resolvePath(?string $folder) {
        $root = rtrim($this->root,'/')."/";
        $folder = (!empty($folder)?rtrim($folder,'/'):null);

        return "{$root}{$folder}";
    }

}