<?php

namespace SousControle\Core\Templating;

use SousControle\Core\Exceptions\FileUnfoundException;
use SousControle\Core\Templating\TemplatingEngine;

class MinimalBlade implements TemplatingEngine
{ 
    public string $VIEWS_DIR = __DIR__ . "/../../views/";

    public function process(string $template, array $data = []): string
    {
        $views_dir = $this->VIEWS_DIR;
        if(file_exists($views_dir . $template . ".blade.php")) {
            $templateContent = file_get_contents($views_dir . $template . ".blade.php"); 
            if($this->isTemplateContentContainExtends($templateContent)){
                $extendsFile = $this->isTemplateContentContainExtends($templateContent);
                $extendsFileContent = file_get_contents($views_dir . $extendsFile);
                $extendsFileContent = $this->replaceYields($extendsFileContent, $templateContent);
                $templateContent = $extendsFileContent; 
            } 
            $templateContent = $this->replaceIncludesToContents($templateContent);
            $templateContent = $this->replaceVariables($templateContent, $data);
            $templateContent = $this->replaceMinimalBadePhpTags($templateContent);
            $templateContent = $this->executePhpCode($templateContent, $data);
            return $templateContent;
        }else{
            throw new FileUnfoundException("Template $template.blade.php not found in $views_dir");
        }
    }

    private function isTemplateContentContainExtends(string $content): string|null // return the extends used name
    {
        $boolean = preg_match('/@extends\s*\(\s*[\'"](.*?)[\'"]\s*\)/', $content, $matches);
        if($boolean){
            $extendsFile = $matches[1] . ".blade.php";
            if(file_exists($this->VIEWS_DIR . $extendsFile)){
                return $extendsFile;
            }else{
                throw new FileUnfoundException("Your extended file $extendsFile not found in Views Directory");
            }
        }
        return null;
    }

    private function replaceYields(string $baseTemplateContentContainingYield, string $remplacementTemplateContent): string
    {
        // Trouver toutes les sections dans le contenu à insérer
        preg_match_all('/@section\s*\(\s*[\'"](.+?)[\'"]\s*\)(.*?)@endsection/s', $remplacementTemplateContent, $matches, PREG_SET_ORDER);
        
        // Tableau des sections récupérées
        $sections = [];
        foreach ($matches as $match) {
            $sections[$match[1]] = trim($match[2]); // Associe le nom de la section à son contenu
        }

        // Remplacer chaque @yield('section') par le contenu correspondant
        return preg_replace_callback('/@yield\s*\(\s*[\'"](.+?)[\'"]\s*\)/', function ($match) use ($sections) {
            return $sections[$match[1]] ?? ''; // Insère le contenu de la section ou une chaîne vide si non trouvé
        }, $baseTemplateContentContainingYield);
    }

    private function replaceIncludesToContents(string $templateContent): string 
    {
        return preg_replace_callback('/@include\s*\(\s*[\'"](.+?)[\'"]\s*\)/', function ($matches) {
            $filePath = $this->VIEWS_DIR . str_replace('.', '/', $matches[1]) . '.blade.php';
            if (!file_exists($filePath)) {
                throw new FileUnfoundException("Included File $filePath in template not found");
            }
            $filePathContent = file_get_contents($filePath);
            return $filePathContent; // Remplace @include('fichier') par le chemin réel
        }, $templateContent);
    }

    private function replaceVariables(string $templateContent, array $data): string
    {
        return preg_replace_callback('/{{\s*\$(\w+)\s*}}/', function ($matches) use ($data) {
            return htmlspecialchars($data[$matches[1]]) ?? ''; // Remplace par la valeur safe ou une chaîne vide si non trouvée
        }, $templateContent);
    }

    private function replaceMinimalBadePhpTags(string $templateContent): string
    {
        return preg_replace('/@php\s*(.*?)\s*@endphp/s', '<?php $1 ?>', $templateContent);
    }
    
    private function executePhpCode(string $templateContent, array $data = []): string
    {
        // Extraire les variables pour les rendre accessibles dans le template;
        extract($data); 

        // Exécuter le code PHP
        ob_start();
        eval("?>$templateContent<?php ");
        return ob_get_clean();
    }
}