<?php
namespace App\HTML;

class Form{

    private $data;
    private $errors;

    public function __construct($data, ?array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }


    /**
     * Création d'un label + input (HTML dynamique) de formulaire
     * Signature : $form->input('slug', 'URL');
     *
     * @param string $name (représente le nom du champ input, mais aussi l'id. Représente aussi l'attribut 'for' de label)
     * @param string $label (représente le nom du label)
     * @param string $type (type de l'input, text ou file)
     * @return string (retourne un input + label de formulaire)
     */ 
    public function input(string $name, string $label): string
    {
        $value = $this->getValue($name);
        return <<<HTML
        <div class="form-group">
            <label for="field{$name}">{$label}</label>
            <input type="text" id="field{$name}" class="{$this->getInputClass($name)}" name="{$name}" value="{$value}">
            {$this->getErrorFeedback($name)} 
        </div>
HTML;
    }


    public function inputFile(string $name, string $label): string
    {
        $value = $this->getValue($name);
        return <<<HTML
        <div class="form-group">
            <label for="field{$name}">{$label}</label>
            <input type="file" id="field{$name}" class="{$this->getInputClass($name,'-file')}" name="{$name}" value="{$value}" aria-describedby="fileHelp">
            <small id="fileHelp" class="form-text text-muted">Choisissez une belle image pour représenter votre bien.</small>
            {$this->getErrorFeedback($name)} 
        </div>
HTML;
    }


    /**
     * Création d'un champs textarea de formulaire
     * Signature : $form->textarea('content', 'Contenu');
     *
     * @param string $name (représente le nom du champ input, mais aussi l'id. Représente aussi l'attribut 'for' de label)
     * @param string $label (représente le nom du label)
     * @return string (retourne un input + label de formulaire)
     */ 
    public function textarea(string $name, string $label): string
    {
        $value = $this->getValue($name);
        
        return <<<HTML
        <div class="form-group">
            <label for="field{$name}">{$label}</label>
            <textarea type="text" id="field{$name}" class="{$this->getInputClass($name)}" name="{$name}">{$value}</textarea>
            {$this->getErrorFeedback($name)} 
        </div>    
HTML;
    }
 
    private function getValue(string $name): ?string
    {
        if(is_array($this->data)){
            return $this->data[$name] ?? null;
        }else{
            $method = 'get' . ucfirst($name); 
            $value = $this->data->$method(); 
            if($value instanceof \DateTimeInterface){
                return $value->format('Y-m-d H:i:s');
            }
            return $value;
        }
    }

    private function getInputClass(string $name, ?string $addFile = ""): string
    {
        $inputClass = 'form-control' . $addFile;
        if(isset($this->errors[$name])){
            $inputClass .= ' is-invalid'; 
        }
        return $inputClass;
    }

    private function getErrorFeedback($name)
    {
        if(isset($this->errors[$name])){
            return '<div class="invalid-feedback">' . $this->errors[$name] . '</div>'; 
        }
        return ''; 
    }


}