<?php

namespace CliqueTI\Storage\Helpers;

use Exception;

/**
 * HELPERS DA CLASSE STORAGE
 * STORAGE CLASS HELPERS
 */
trait StorageHelper {
    /**
     * VERIFICA SE O TIPO DO ARQUIVO ESTA PERMITIDO
     * VERIFY IF THE FILE TYPE IS ALLOWED
     * @param array $file
     * @return void
     * @throws Exception
     */
    private function allowedType(array $file) {
        if(!empty($this->mimeTypes) && !in_array($file['type'],$this->mimeTypes)){
            throw new Exception('Tipo de arquivo não permitido');
        }
    }

    /**
     * FORMATA O NOME DO ARQUIVO
     * FORMAT FILE NAME
     * @param string $name
     * @return array|string|string[]
     */
    private function parseName(string $name) {
        $string = filter_var(mb_strtolower($name), FILTER_SANITIZE_STRIPPED);
        $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $name = str_replace(["-----", "----", "---", "--"], "-",
            str_replace(" ", "-",
                trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
            )
        );
        return $name;
    }
}