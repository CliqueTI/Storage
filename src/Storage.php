<?php

namespace CliqueTI\Storage;

use Exception;

/**
 * PEQUENO GERENCIADOR DE UPLOADS
 * LITTLE UPLOADS MANAGER
 */
class Storage {

    /**
     * TIPO DE ARQUIVOS PERMITIDOS
     * ALLOWED FILE TYPES
     * @var array
     */
    protected array $mimeTypes;

    /**
     * CONFIGURAÇÕES INICIAIS
     * INITIAL SETTINGS
     */
    public function __construct() {
        $this->mimeTypes = $this->resolveConfig('mimeTypes') ?? [];
    }

    /**
     * DISCO OU ADAPTADOR QUE SERA UTILIZADO PARA GUARDAR OS ARQUIVOS
     * DISK OR ADAPTER THAT WILL BE USED TO SAVE THE FILES
     *
     * OPÇÕES DISPONIVEIS NA PASTA ADAPTADORES
     * OPTIONS AVAILABLE IN THE ADAPTERS FOLDER
     * @param string $name
     * @return mixed
     * @throws Exception
     */
    public function disk(string $name) {
        $class = 'CliqueTI\Storage\Adapters\\'.$name;
        if (class_exists($class)) {
            return (new $class());
        } else {
            throw new Exception('Disco não encontrado');
        }
    }

    /**
     * PERMITE UM NOVO MIME TYPE
     * ALLOW A NEW MIME TYPE
     * @param $mimeTypes
     * @return $this
     */
    public function mimeTypes($mimeTypes) {
        if(is_array($mimeTypes)){
            $this->mimeTypes = array_merge($this->mimeTypes,$mimeTypes);
            return $this;
        }
        $this->mimeTypes[] = $mimeTypes;
        return $this;
    }

    /**
     * GERA UM NOME PARA O ARQUIVO ALEATORIO
     * ALLOW A NEW MIME TYPE
     * @return string
     */
    protected function generateName() {
        return (date('Ymd').mt_rand());
    }

    /**
     * VERIFICA SE EXISTE CONSTANTE DE CONFIGURAÇÃO COM DETERMINADA PROPRIEDADE
     * VERIFIES IF THERE IS A CONFIGURATION CONSTANT WITH A CERTAIN PROPERTY
     * @param string $property
     * @return null
     */
    protected function resolveConfig(string $property) {
        if(defined('STORAGECONFIG') && !empty(STORAGECONFIG[$property])){
            return STORAGECONFIG[$property];
        }
        return null;
    }
    
}