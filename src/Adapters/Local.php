<?php

namespace CliqueTI\Storage\Adapters;

use CliqueTI\Storage\Storage;
use CliqueTI\Storage\Helpers\LocalHelper;
use CliqueTI\Storage\Contracts\Storage as Contract;

/**
 * ADAPTADOR PARA ARQUIVOS LOCAIS
 * ADAPTER FOR LOCAL FILES
 */
class Local extends Storage implements Contract {

    use LocalHelper;

    /**
     * ENDEREÇO RAIZ
     * ROOT ADDRESS
     * @var string
     */
    private string $root;

    /**
     * CONFIGURAÇÕES INICIAIS
     * INITIAL SETTINGS
     */
    public function __construct() {
        parent::__construct();
        $this->root = $this->resolveConfig('root') ?? 'storage';
    }

    /**
     * SALVA ARQUIVO COM NOME ALEATORIO
     * SAVE FILE WITH RANDOM NAME
     * @param array $file
     * @param string|null $folder
     * @return string
     * @throws \Exception
     */
    public function store(array $file, string $folder=null): string {
        return $this->storeAs($file,$this->generateName(),$folder);
    }

    /**
     * SALVA ARQUIVO COM NOME ESPECIFICO
     * SAVE FILE WITH SPECIFIC NAME
     * @param array $file
     * @param string $name
     * @param string|null $folder
     * @return string
     * @throws \Exception
     */
    public function storeAs(array $file, string $name, string $folder=null): string {

        $this->parseFile($file);
        $this->parseFolder($folder);

        return $this->putFileAs($file, $name, $folder);

    }

}