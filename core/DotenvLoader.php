<?php

namespace SousControle\Core;

class DotenvLoader
{
    public function load(string $fileName): void
    {
        $array = file($fileName); // get .env lines as an array
        $array = $this->removeNonValidArrayCases($array); 
        foreach($array as $line){
            $line = $this->removeComment($line);

            if($line){
                [$key, $value] = explode('=', $line);
                $_ENV[trim($key)] = trim($value);
            }
            
        } 
    }

    private function removeNonValidArrayCases(array $array): array|null // ex: 1 => "\n" inside an array // or ex: 1 => "# someText"
    {
        $spaces = [" ", "\t", "\n", "\r"];

        foreach($array as $key => $value){
            if(in_array($value, $spaces) || preg_match('/^\s*#.*$/', $value)){
                unset($array[$key]);
            }
        } 
        
        return $array;
    }

    private function removeComment(string $value): string
    {
        $pattern = '/#.*/';
        $remplacement = '';

        $resultat = preg_replace($pattern, $remplacement, $value);
        return $resultat;
    }
}