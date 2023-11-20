<?php
/*
class Validator
Проверка и валидация данных. Проверки форм и данных, присланных в запросах на сервер.

Поле $rules_list содержит все доступные правила проверки, которые могут быть применены к значениям. Каждое из этих правил представляет собой метод внутри класса Validator.

Поле $errors служит для хранения всех ошибок валидации, которые возникают при проверке данных.

Поле $messages содержит список сообщений об ошибках, которые будут выведены в случае несоответствия исходных данных определенным правилам.

Поле $data_items используется для хранения исходных данных для проверки.

Метод validate($data = [], $rules = []) является основным методом класса, он проверяет исходные данные ($data), применяя к ним правила ($rules).

Метод check($field) используется внутри validate для проверки каждого отдельного поля.

Метод addError($fieldname, $error) используется чтобы добавить конкретную ошибку валидации в массив ошибок.

Методы required($value, $rule_value), min($value, $rule_value), max($value, $rule_value), minNum($value, $rule_value), email($value, $rule_value) и match($value, $rule_value) являются функциями валидации, каждая из которых проверяет определенное условие.

Метод getErrors() возвращает все ошибки, которые возникли в процессе валидации.

Метод listErrors($fieldname) возвращает конкретные ошибки для определенного поля в виде HTML-строки.

Метод hasErrors() проверяет, есть ли ошибки валидации в принципе.
*/  
class Validator
{

    protected $rules_list = ['required', 'min', 'max', 'email', 'match', 'minNum'];
    protected $errors = [];
    protected $messages = [
        'required' => 'The :fieldname: field is required',
        'min' => 'The :fieldname: field must be a minimun :rulevalue: characters',
        'max' => 'The :fieldname: field must be a maximum :rulevalue: characters',
        'email' => 'Not valid email',
        'match' => 'The :fieldname: field must match :rulevalue: field',
        'minNum' => 'The :fieldname: field must be a number with a minimum value :rulevalue:',
    ];
    protected $data_items;

    public function validate($data = [], $rules = [])
    {
        $this->data_items = $data;

        foreach ($data as $field => $value) {
            // in_array($field, array_keys($rules))
            if (isset($rules[$field])) {
                $this->check([
                    'fieldname' => $field,
                    'value' => $value,
                    'rules' => $rules[$field],
                ]);
            }
        }
        return $this;
    }

    protected function check($field)
    {
        foreach ($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError(
                        $field['fieldname'],
                        str_replace([':fieldname:', ':rulevalue:'], [$field['fieldname'], $rule_value], $this->messages[$rule])
                    );
                }
            }
        }
    }

    protected function required($value, $rule_value)
    {
        return !empty(trim($value));
    }

    protected function min($value, $rule_value)
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value)
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function minNum($value, $rule_value)
    {
        return filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => $rule_value]]);
    }

    protected function email($value, $rule_value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function match($value, $rule_value)
    {
        return $value === $this->data_items[$rule_value];
    }

    protected function addError($fieldname, $error)
    {
        $this->errors[$fieldname][] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function listErrors($fieldname)
    {
        $output = '';
        if (isset($this->errors[$fieldname])) {
            $output .= "<div class='invalid-feedback d-block'><ul class='list-unstyled'>";
            foreach ($this->errors[$fieldname] as $error) {
                $output .= "<li>{$error}</li>";
            }
            $output .= "</ul></div>";
        }
        return $output;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }
}
